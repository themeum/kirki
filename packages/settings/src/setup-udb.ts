import { getClosest, startLoading, stopLoading } from "./utils";
import jQuery from "jquery";

declare var wp: any;
declare var kirkiSettings: any;
declare var ajaxurl: any;

export default function setupUdb() {
	const adminPage: HTMLElement | null = document.querySelector(
		".kirki-settings-page"
	);
	if (!adminPage) return;

	let doingAjax = false;
	const udbData = kirkiSettings.recommendedPlugins.udb;

	document.addEventListener("click", handleDocumentClick);

	function handleDocumentClick(e: Event) {
		const button = getClosest(e.target as HTMLElement, ".kirki-install-udb");
		if (!button) return;

		e.preventDefault();

		if (
			!confirm(
				"This will install and activate the Ultimate Dashboard plugin. Please don't leave this page until the installation is complete. Install now?"
			)
		) {
			return;
		}

		prepareUdb(button);
	}

	function disableOrEnableOtherButtons(
		actionType: string,
		currentButton: HTMLElement | HTMLButtonElement
	) {
		const buttons = document.querySelectorAll(".kirki-install-udb");
		if (!buttons.length) return;

		buttons.forEach((button) => {
			if (actionType === "disable") {
				if (currentButton && button === currentButton) return;
			}

			if (button.tagName.toLowerCase() === "button") {
				if (actionType === "disable") {
					button.setAttribute("disabled", "disabled");
				} else {
					button.removeAttribute("disabled");
				}
			} else {
				if (actionType === "disable") {
					button.classList.add("is-disabled");
				} else {
					button.classList.remove("is-disabled");
				}
			}
		});
	}

	function prepareUdb(button: HTMLElement) {
		if (!adminPage) return;
		if (doingAjax) return;
		startProcessing(button);

		const nonce = adminPage.dataset.setupUdbNonce
			? adminPage.dataset.setupUdbNonce
			: "";

		jQuery
			.ajax({
				url: ajaxurl,
				method: "POST",
				data: {
					action: "kirki_prepare_install_udb",
					nonce: nonce,
				},
			})
			.done(function (response) {
				if (!response.success) {
					alert(response.data);
					stopProcessing(button, "");
				}

				if (response.data.finished) {
					stopProcessing(button, udbData.redirectUrl);
					return;
				}

				doingAjax = false;
				installUdb(button);
				return;
			})
			.fail(function (jqXHR) {
				if (jqXHR.responseJSON && jqXHR.responseJSON.data) {
					alert(jqXHR.responseJSON.data);
				}

				stopProcessing(button, "");
			});
	}

	function installUdb(button: HTMLElement) {
		if (doingAjax) return;
		doingAjax = true;

		wp.updates.installPlugin({
			slug: udbData.slug,
			success: function () {
				doingAjax = false;
				activateUdb(button);
			},
			error: function (jqXHR: any) {
				// console.log(jqXHR);

				let abort = true;

				if (jqXHR.errorCode && jqXHR.errorMessage) {
					if (jqXHR.errorCode === "folder_exists") {
						console.log(
							"Plugin is already installed before, let's continue activating it."
						);

						doingAjax = false;
						abort = false;

						// If the plugin is already installed, just activate it.
						activateUdb(button);
					} else {
						alert(jqXHR.errorMessage);
					}
				} else {
					if (jqXHR.responseJSON && jqXHR.responseJSON.data) {
						alert(jqXHR.responseJSON.data);
					}
				}

				if (abort) {
					stopProcessing(button, "");
				}
			},
		});
	}

	function activateUdb(button: HTMLElement) {
		if (doingAjax) return;
		doingAjax = true;

		jQuery.ajax({
			async: true,
			type: "GET",
			url: udbData.activationUrl,
			success: function () {
				stopProcessing(button, udbData.redirectUrl);
			},
			error: function (jqXHR) {
				if (jqXHR.responseJSON && jqXHR.responseJSON.data) {
					alert(jqXHR.responseJSON.data);
				}

				stopProcessing(button, "");
			},
		});
	}

	function startProcessing(button: HTMLElement) {
		doingAjax = true;
		disableOrEnableOtherButtons("disable", button);
		startLoading(button);
	}

	function stopProcessing(button: HTMLElement, redirectUrl: string) {
		if (redirectUrl) {
			window.location.replace(redirectUrl);
		}

		stopLoading(button);
		doingAjax = false;
		disableOrEnableOtherButtons("enable", button);
	}
}

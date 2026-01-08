import { getClosest } from "./utils";

declare var ajaxurl: string;

(function () {
	function init() {
		document.addEventListener("click", handleDismissClick);
	}

	function handleDismissClick(e: Event) {
		const target = e.target as HTMLElement;
		const dismissButton = getClosest(
			target,
			".kirki-discount-notice.is-dismissible .notice-dismiss"
		);

		if (!dismissButton) return;
		dismiss(e);
	}

	function dismiss(e: Event) {
		const notice = getClosest(
			e.target as HTMLElement,
			".kirki-discount-notice"
		);
		if (!notice) return;
		let nonce = notice.dataset.dismissNonce;
		nonce = nonce ? nonce : "";

		const formData = new URLSearchParams();
		formData.append("action", "kirki_dismiss_discount_notice");
		formData.append("nonce", nonce);
		formData.append("dismiss", "1");

		fetch(ajaxurl, {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
			},
			body: formData.toString(),
			credentials: "same-origin",
		})
			.then((r) => r.json())
			.then((response) => {
				if (response && response.success) {
					console.log(response.data);
				}
			})
			.catch(() => {
				// Swallow errors to match previous silent failure behavior.
			});
	}

	init();
})();

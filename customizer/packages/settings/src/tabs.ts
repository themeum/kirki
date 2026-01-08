export default function setupTabsNavigation() {
	const tabNavItems = document.querySelectorAll<HTMLElement>(
		".heatbox-tab-nav-item"
	);

	tabNavItems.forEach((item) => {
		item.addEventListener("click", (event) => {
			const target = event.currentTarget as HTMLElement;

			tabNavItems.forEach((tab) => tab.classList.remove("active"));
			target.classList.add("active");

			const link = target.querySelector<HTMLAnchorElement>("a");
			if (!link || link.hash === "") return;

			const hashValue = link.hash.substring(1);
			togglePanels(hashValue);
		});
	});

	window.addEventListener("load", () => {
		let hashValue = window.location.hash.substring(1);

		if (!hashValue) {
			const currentActiveTabMenu = document.querySelector<HTMLElement>(
				".heatbox-tab-nav-item.active"
			);

			if (currentActiveTabMenu && currentActiveTabMenu.dataset.tab) {
				hashValue = currentActiveTabMenu.dataset.tab;
			}

			hashValue = hashValue ? hashValue : "settings";
		}

		tabNavItems.forEach((tab) => tab.classList.remove("active"));

		const activeTab = document.querySelector<HTMLElement>(
			`.heatbox-tab-nav-item.kirki-${hashValue}-panel`
		);
		if (activeTab) {
			activeTab.classList.add("active");
		}

		togglePanels(hashValue);
	});
}

function togglePanels(hashValue: string) {
	const panels = document.querySelectorAll<HTMLElement>(
		".heatbox-panel-wrapper .heatbox-admin-panel"
	);

	panels.forEach((panel) => {
		panel.style.display = "none";
	});

	const targetPanel = document.querySelector<HTMLElement>(
		`.heatbox-panel-wrapper .kirki-${hashValue}-panel`
	);

	if (targetPanel) {
		targetPanel.style.display = "block";
	}
}

import "./control.scss";

const setupTabs = () => {
  const childControls = document.querySelectorAll(
    "[data-kirki-parent-tab-id]"
  );
  if (!childControls.length) return;

  let tabIds = [];

  Array.from(childControls).forEach(function (childControl) {
    const parentTabId = childControl.dataset.kirkiParentTabId;

    if (!tabIds.includes(parentTabId)) {
      tabIds.push(parentTabId);
    }
  });

  const switchTabs = (tabId, tabItemName) => {
    const tabMenuItems = document.querySelectorAll(
      '[data-kirki-tab-id="' + tabId + '"] .kirki-tab-menu-item'
    );

    Array.from(tabMenuItems).forEach(function (menuItem) {
      menuItem.classList.remove("is-active");
    });

    const tabMenuItem = document.querySelector(
      '[data-kirki-tab-id="' +
        tabId +
        '"] [data-kirki-tab-menu-id="' +
        tabItemName +
        '"]'
    );

    if (tabMenuItem) tabMenuItem.classList.add("is-active");

    const tabItems = document.querySelectorAll(
      '[data-kirki-parent-tab-id="' + tabId + '"]'
    );

    Array.from(tabItems).forEach(function (tabItem) {
      if (tabItem.dataset.kirkiParentTabItem === tabItemName) {
        tabItem.classList.remove("kirki-tab-item-hidden");
      } else {
        tabItem.classList.add("kirki-tab-item-hidden");
      }
    });
  };

  const setupTabClicks = () => {
    document.addEventListener("click", function (e) {
      const tabLink = e.target.closest(".kirki-tab-menu-item a");
      if (!tabLink) return;

      e.preventDefault();

      const tabMenuItem = tabLink.closest(".kirki-tab-menu-item");
      const tabContainer = tabMenuItem.closest("[data-kirki-tab-id]");
      const tabId = tabContainer.dataset.kirkiTabId;
      const tabItemName = tabMenuItem.dataset.kirkiTabMenuId;

      switchTabs(tabId, tabItemName);
    });
  };

  const setupBindings = () => {
    tabIds.forEach(function (tabId) {
      wp.customize.section(tabId, function (section) {
        section.expanded.bind(function (isExpanded) {
          if (isExpanded) {
            const activeTabMenu = document.querySelector(
              '[data-kirki-tab-id="' +
                tabId +
                '"] .kirki-tab-menu-item.is-active'
            );

            if (activeTabMenu) {
              switchTabs(tabId, activeTabMenu.dataset.kirkiTabMenuId);
            }
          }
        });
      });
    });
  };

  setupTabClicks();
  setupBindings();
};

wp.customize.bind("ready", function () {
  setupTabs();
});

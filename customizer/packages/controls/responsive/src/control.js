import "./control.scss";

const api = wp.customize;

const setupDevices = () => {
  // Get all controls which are responsive-able (not the device control it self).
  const childControls = document.querySelectorAll(
    "[data-kirki-parent-responsive-id]"
  );
  if (!childControls.length) return;

  // Responsive ids are collection of the id of the responsive controls (the device controls).
  let responsiveIds = [];

  [].slice.call(childControls).forEach(function (childControl) {
    const parentResponsiveId = childControl.dataset.kirkiParentResponsiveId;
    const device = childControl.dataset.kirkiDevicePreview;
    const setting = childControl.dataset.kirkiSetting;

    if (!responsiveIds.includes(parentResponsiveId)) {
      responsiveIds.push(parentResponsiveId);
    }

    /**
     * Grouped controls are collection of control which contains some child-controls.
     * Example of grouped controls: field-dimensions, field-typography, field-multicolor.
     */
    const groupedControls = document.querySelectorAll(
      '[data-kirki-parent-control-setting="' + setting + '"]'
    );

    // Check if childControl is a field that groups other controls.
    if (groupedControls.length) {
      [].slice.call(groupedControls).forEach(function (groupedControl) {
        // Inherit the parentResponsiveId & device from the group's parent.
        groupedControl.dataset.kirkiParentResponsiveId = parentResponsiveId;
        groupedControl.dataset.kirkiDevicePreview = device;
      });
    }
  });

  // Move the device icons next to the control's title.
  responsiveIds.forEach(function (responsiveId) {
    const deviceButtons = document.querySelector(
      "#customize-control-" + responsiveId + " .kirki-device-buttons"
    );

    if (!deviceButtons) return;

    deviceButtons.setAttribute("data-kirki-devices-for", responsiveId);

    const titleElement = document.querySelector(
      "#customize-control-" + responsiveId + " .customize-control-title"
    );

    if (titleElement) {
      titleElement.appendChild(deviceButtons);
    }
  });
};

const setupPreview = () => {
  function init() {
    switchDevice("desktop"); // Initial state.
    setupDeviceClicks();
    syncPreviewButtons();
  }

  function setupDeviceClicks() {
    const deviceButtons = document.querySelectorAll(".kirki-device-button");
    if (!deviceButtons.length) return;

    // Loop through Kirki device buttons and assign the click event.
    [].slice.call(deviceButtons).forEach(function (deviceButton) {
      deviceButton.addEventListener("click", function (e) {
        var device = this.getAttribute("data-kirki-device");

        // Trigger WordPress device event.
        api.previewedDevice.set(device);
      });
    });
  }

  /**
   * Sync device preview button from WordPress to Kirki and vice versa.
   */
  function syncPreviewButtons() {
    // Bind device changes from WordPress default.
    api.previewedDevice.bind(function (newDevice) {
      switchDevice(newDevice);
    });
  }

  /**
   * Setup device preview.
   *
   * @param string device The device (mobile, tablet, or desktop).
   */
  function switchDevice(device) {
    // Remove active class from all device buttons.
    const allDeviceButtons = document.querySelectorAll(".kirki-device-button");
    [].slice.call(allDeviceButtons).forEach(function (button) {
      button.classList.remove("is-active");
    });

    // Add active class to the selected device button.
    const activeDeviceButton = document.querySelector(
      ".kirki-device-button-" + device
    );
    if (activeDeviceButton) {
      activeDeviceButton.classList.add("is-active");
    }

    // Hide all device preview items.
    const allPreviewItems = document.querySelectorAll(
      "[data-kirki-device-preview]"
    );
    [].slice.call(allPreviewItems).forEach(function (item) {
      item.classList.add("kirki-responsive-item-hidden");
    });

    // Show items for the selected device.
    const devicePreviewItems = document.querySelectorAll(
      '[data-kirki-device-preview="' + device + '"]'
    );
    [].slice.call(devicePreviewItems).forEach(function (item) {
      item.classList.remove("kirki-responsive-item-hidden");
    });
  }

  init();
};

// Run setupDevices & setupPreview after the customizer is ready.
wp.customize.bind("ready", function () {
  setTimeout(function () {
    setupDevices();
    setupPreview();
  }, 250);
});

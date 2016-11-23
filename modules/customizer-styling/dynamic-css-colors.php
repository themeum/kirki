<?php

return '
/** Generic background color **/
.wp-full-overlay-sidebar {
  background: COLOR_BACK;
}

/** Title background color **/
#customize-controls .customize-info .accordion-section-title,
#customize-controls .panel-meta.customize-info .accordion-section-title:hover {
  background: COLOR_BACK
}

/** Borders **/
#customize-controls .customize-info {
  border-top-color: BORDER_COLOR;
  border-bottom-color: BORDER_COLOR;
}

.customize-section-title {
  border-bottom-color: BORDER_COLOR;
}

.customize-panel-back,
.customize-section-back {
  border-right-color:BORDER_COLOR;
}

#customize-header-actions {
  border-bottom-color: BORDER_COLOR;
}

.customize-controls-close,
.customize-overlay-close {
  border-right-color: BORDER_COLOR !important;
}

/** back & close buttons color **/
.customize-panel-back:focus,
.customize-panel-back:hover,
.customize-section-back:focus,
.customize-section-back:hover,
.customize-panel-back,
.customize-section-back,
.customize-controls-close,
.customize-overlay-close {
  background: BUTTONS_COLOR;
}

.control-panel-back:focus,
.control-panel-back:hover,
.customize-controls-close:focus,
.customize-controls-close:hover,
.customize-controls-preview-toggle:focus,
.customize-controls-preview-toggle:hover,
.customize-overlay-close:focus,
.customize-overlay-close:hover {
  background: BUTTONS_COLOR
}

/** Sections list titles **/
#customize-theme-controls .accordion-section-title {
  background: COLOR_BACK;
  color: COLOR_FONT;
}

#customize-controls .control-section .accordion-section-title:focus,
#customize-controls .control-section .accordion-section-title:hover,
#customize-controls .control-section.open .accordion-section-title,
#customize-controls .control-section:hover>.accordion-section-title {
  background: COLOR_ACCENT;
  color: CONTROLS_COLOR;
}

/** Arrows **/
.accordion-section-title:after,
.handlediv,
.item-edit,
.sidebar-name-arrow,
.widget-action {
  color: ARROWS_COLOR;
}

#customize-theme-controls .control-section .accordion-section-title:focus:after,
#customize-theme-controls .control-section .accordion-section-title:hover:after,
#customize-theme-controls .control-section.open .accordion-section-title:after,
#customize-theme-controls .control-section:hover>.accordion-section-title:after {
  color: COLOR_ACCENT_TEXT
}

/** Title for active section **/
.customize-section-title {
  background: COLOR_BACK;
}

.customize-section-title h3,
h3.customize-section-title {
  color: COLOR_FONT;
}

/** Active section background **/
#customize-theme-controls .accordion-section-content {
  background: SECTION_BACKGROUND_COLOR;
}

/** Title color for active panels etc **/
#customize-controls .customize-info .preview-notice {
  color: COLOR_FONT;
}
';

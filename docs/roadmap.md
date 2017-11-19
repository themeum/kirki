---
layout: default
title: Kirki Roadmap
subtitle: Plan big
mainMaxWidth: 50rem;
bodyClasses: roadmap
---

Below is a list of things I want to accomplish in the next versions. The items on this list are in no particular order and at this point there are no ETAs or versions. This is just a rough draft of my goals regarding Kirki

#### Rewrite the `postMessage` module

<span class="secondary label">Planned for</span><span class="alert label">future version</span>


When Kirki started almost 4 years ago WordPress's APIs for the customizer were limited.
However these past 4 years a lot has changed and unfortunately the code behind this module hasn't changed a lot.
This module requires a complete rewrite, and it will all be in JS. No more auto-generating scripts.
Instead we can simply have a JS file that will parse the controls, check their arguments and apply any CSS (or HTML) rules directly. It will be a lot faster & cleaner this way.

---

#### Move markup for controls from PHP to JS

<span class="secondary label">Planned for</span><span class="warning label">3.1.0</span>

I recently introduced a `kirkiDynamicControl` object in Kirki - derived from the [wp-customize-posts](https://github.com/xwp/wp-customize-posts) plugin. When a Kirki control extends that object we're able to initialize the control not when the customizer loads, but when the control's section is activated. This makes the initial customizer load a lot faster, but the actual markup for many controls is still added on load. By moving the markup to the JS files we'll be able to render the controls only when they are needed instead of on load.

<div class="callout success">
<strong>EDIT</strong>: Work on this has already started in the develop branch and it will be Implemented in stages, starting with version 3.0.16. The plan is to have everything finished by the time we reach 3.1.0
</div>

---

#### Abstract controls by creating a global `kirki` object

<span class="secondary label">Planned for</span><span class="warning label">3.1.0</span>

Abstracting the controls would allow us for example to create complex controls easier and more effectively.
The `typography` control wouldn't need to create everything from scratch.
Instead we'd add all input fields that consitute the typography control using the `kirki` object, and everything else would be taken care of automatically.
Repeaters would be able to act as wrapper for complete control structures instead of wrappers for simple input elements.

<div class="callout success">
<strong>EDIT</strong>: Work on this has already started in the develop branch and it will be Implemented in stages, starting with version 3.0.16. The plan is to have everything finished by the time we reach 3.1.0
</div>

#### Deprecate the `customizer-styling` module

<span class="secondary label">Planned for</span><span class="alert label">future version</span>

This module will be deprecated. It should not be part of the plugin's core. We can provide it as a separate module that developers can add if they want it.

---

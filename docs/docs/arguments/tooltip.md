---
layout: default
title: tooltip
published: true
mainMaxWidth: 55rem;
---

Using the `tooltip` argument you can add tooltips to your controls.

We recommend using descriptions instead of tooltips as descriptions are always visible while tooltips require the user to click the `(i)` icon next to the control in order to see the details.

<div class="callout warning">
	<h4>Backwards-compatibility notice</h4>
	<p>Note: This argument was called <code>help</code> in versions < 2.2.</p>
	<p>For backwards-compatibility purposes we're keeping compatibility with the <code>help</code> argument but we advise you to use the <code>tooltip</code> argument instead for consistency.</p>
	<p>If you use the <code>help</code> argument instead of <code>tooltip</code> you may see a PHP Notice in your error-log informing you you should change to <code>tooltip</code></p>
</div>

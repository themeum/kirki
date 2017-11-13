---
layout: default
title: Documentation
subtitle: We are currently rewriting all documentation, please be patient.
mainMaxWidth: 55rem;
---

### What is Kirki?

Kirki is a collection of tools that allow WordPress developers to build rich user experiences with minimal code.

### Why was Kirki created?

Kirki was created to satisfy a personal need. While building WordPress themes I found myself repeating a lot of code. Initially a wrapper was created to make the creation of controls and settings in the WordPress Customizer API faster to write, then that wrapper was expanded to allow me to change the theme's styles based on the values of those controls, and it slowly evolved to its current point.

### Should you use Kirki?

Our target is WordPress developers building complex themes or plugins that require dozens of controls in the customizer, complex CSS generation based on the values of those controls, live-updating the customizer preview without a refresh (using `postMessage`) and other features that Kirki includes.

<div class="callout alert">
	<p>If you do not have an understanding of PHP, JS, the WordPress Customizer and its APIs you should not use Kirki.</p>
</div>

### Getting Started

The first thing you should do is decide how you are going to distribute and integrate Kirki with your project. You can read more about that in [this article](integration).

The next step is to [create a configuration](config). The ID you choose for your config has to be unique and will be used to differentiate your project from other projects that may be using Kirki on the same site (since Kirki can be used not only by themes but also plugins).

After you create your config you can start [adding panels and sections](adding-panels-and-sections), or if you already have some sections you have created via the WordPress Customizer API move directly to [adding controls](controls).

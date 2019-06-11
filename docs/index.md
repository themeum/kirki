---
layout: default
title: WordPress Customizer Framework (Open-Source)
subtitle: A complete toolkit for WordPress theme Developers.
heroButtons:
  - url: https://wordpress.org/plugins/kirki
    class: white button round
    icon: fa fa-wordpress
    label: WordPress Page
  - url: https://github.com/aristath/kirki
    class: white button round
    icon: fa fa-github
    label: Github Project
  - url: docs
    class: white button round border-only
    icon: fa fa-play
    label: Documentation
skipWrapper: true
bodyClasses: home
hideEditLink: true
script: testimonials-script.html
---

<div id="main" class="grid-container grid-margin-x">
    <div class="cell">
        <div class="grid-x grid-margin-x features">
            <div class="feature cell medium-6">
                <h3>100% Open-Source</h3>
                <p>Built with love and an ever-expanding active community, visit the <a href="https://github.com/aristath/kirki">Github Repository</a> to contribute or get help.</p>
            </div>
            <div class="feature cell medium-6">
                <h3>Controls</h3>
                <p>With 30 custom controls and counting at your disposal, chances are Kirki has what you need. <a href="https://kirki.org/docs/controls/">Take a look at what's available</a></p>
            </div>
        </div>
        <div class="grid-x grid-margin-x features">
            <div class="feature cell medium-6">
                <h3>Clean Code</h3>
                <p>Kirki's codebase is 100% compliant with WordPress Coding Standards and we continuously improve the quality of our code for performance and security.</p>
            </div>
            <div class="feature cell medium-6">
                <h3>More features</h3>
                <p>Simplified CSS generation, Live Previews and a lot more make building themes using the WordPress Customizer easier than ever.</p>
            </div>
        </div>
    </div>
</div>

<div style="text-align:center;"><a href="roadmap" class="button round large white"><i class="fa fa-map-signs" aria-hidden="true"></i> Roadmap</a></div>

{% include testimonials.html testimonials=site.data.testimonials %}

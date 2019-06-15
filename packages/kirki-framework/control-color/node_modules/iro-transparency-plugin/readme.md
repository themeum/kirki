<h1 align="center"><img height="330" src="https://raw.githubusercontent.com/jaames/iro-transparency-plugin/master/assets/screenshot.png"/><br/>iro-transparency-plugin</h1>

<p align="center">
  <b>Adds comprehensive transparency support to <a href="https://github.com/jaames/iro.js">iro.js</a></b>
</p>

<p align="center">
  <a href="https://github.com/jaames/iro-transparency-plugin/blob/master/LICENSE.txt">
    <img src="https://badgen.net/github/license/jaames/iro-transparency-plugin" alt="license" />
  </a>
  <a href="https://npmjs.org/package/iro-transparency-plugin">
    <img src="https://badgen.net/npm/v/iro-transparency-plugin?color" alt="version" />
  </a>
  <a href="https://npmjs.org/package/iro-transparency-plugin">
    <img src="https://badgen.net/npm/dt/iro-transparency-plugin?color" alt="downloads" />
  </a>
  <a href="https://bundlephobia.com/result?p=iro-transparency-plugin">
    <img src="https://badgen.net/bundlephobia/minzip/iro-transparency-plugin?color" alt="minzip size" />
  </a>
  <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XS9R3QTLZYAXQ&source=url">
    <img src="https://badgen.net/badge/donate/paypal/ED5151" alt="donate" />
  </a>
</p>

<p align="center">
  <a href="#features">Features</a> | <a href="#installation">Installation</a> | <a href="#usage">Usage</a> | <a href="#color-api-extras">Color API Extras</a>
</p>

<br/>

## Features

* Color picker transparency slider
* Extends iro.js color API to add support for hsva, hsla, rgba, hex8 and hex4 colors
* 7kb minified, or less than 2kB minified + gzipped

<br/>

## Installation

### Install with NPM

```bash
$ npm install iro-transparency-plugin --save
```

If you are using a module bundler like Webpack or Rollup, import iro-transparency-plugin into your project **after iro.js**: 

**Using ES6 modules**:

```js
import iro from '@jaames/iro';
import iroTransparencyPlugin from 'iro-transparency-plugin';
```

**Using CommonJS modules**:

```js
const iro = require('@jaames/iro');
const iroTransparencyPlugin = require('iro-transparency-plugin');
```

### Download and host yourself

**[Development version](https://raw.githubusercontent.com/jaames/iro-transparency-plugin/master/dist/iro-transparency-plugin.js)**<br/>
Uncompressed at around 20kB, with source comments included

**[Production version](https://raw.githubusercontent.com/jaames/iro-transparency-plugin/master/dist/iro-transparency-plugin.min.js)**<br/>
Minified to 8kB

Then add it to the `<head>` of your page with a `<script>` tag **after iro.js**:

```html
<html>
  <head>
    <!-- ... -->
    <script src="./path/to/iro.min.js"></script>
    <script src="./path/to/iro-transparency-plugin.min.js"></script>
  </head>
  <!-- ... -->
</html>
```

### Using the jsDelivr CDN

```html
<script src="https://cdn.jsdelivr.net/npm/iro-transparency-plugin/dist/iro-transparency-plugin.min.js"></script>
```

<br/>

## Usage

### Register Plugin

After both [**iro.js**](https://github.com/jaames/iro.js) and **iro-transparency-plugin** have been imported/downloaded, the plugin needs to be registered with `iro.use`:

```js
iro.use(iroTransparencyPlugin);
```

### ColorPicker Setup

The plugin adds a new `transparency` config option to `iro.ColorPicker`. If set to `true`, a transparency slider will be added to the color picker. 

```js
var colorPicker = new iro.ColorPicker({
  width: 320,
  color: {r: 255, g: 100, b: 100, a: 1},
  transparency: true
})
```

### Color API Extras

There are also additional [color properties](https://github.com/jaames/iro.js#color-properties) for getting / setting the selected color from various color-with-alpha formats. Note that the alpha value should always be between 0 and 1 here.

All of these formats are also supported by the `set` method and the color picker's `color` option.

| Property     | Example Format     |
|:-------------|:-------------------|
| `alpha`      | `0.5` |
| `hex8String` | `"#ff0000ff"` |
| `rgba`       | `{ r: 255, g: 0, b: 0, a: 0.5 }` |
| `rgbaString` | `"rgba(255, 0, 0, 0.5)"` |
| `hsla`       | `{ h: 360, s: 100, l: 50, a: 0.5 }` |
| `hslaString` | `"hsla(360, 100%, 50%, 0.5)"` |
| `hsva`       | `{ h: 360, s: 100, v: 100, a: 0.5 }` |

© [James Daniel](https://github.com/jaames)
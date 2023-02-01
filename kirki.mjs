#!/usr/bin/env node

import shell from "shelljs";
import sade from "sade";

const packagePaths = {
	"control-base": {
		path: "packages/control-base",
		sources: ["src/control.js"],
	},
	"control-checkbox": {
		path: "packages/control-checkbox",
		sources: ["src/control.js"],
	},
	"control-color-palette": {
		path: "packages/control-color-palette",
		sources: ["src/control.js"],
	},
	"control-dashicons": {
		path: "packages/control-dashicons",
		sources: ["src/control.js"],
	},
	"control-date": {
		path: "packages/control-date",
		sources: ["src/control.js"],
	},
	"control-dimension": {
		path: "packages/control-dimension",
		sources: ["src/control.js"],
	},
	"control-editor": {
		path: "packages/control-editor",
		sources: ["src/control.js"],
	},
	"control-generic": {
		path: "packages/control-generic",
		sources: ["src/control.js"],
	},
	"control-image": {
		path: "packages/control-image",
		sources: ["src/control.js"],
	},
	"control-multicheck": {
		path: "packages/control-multicheck",
		sources: ["src/control.js"],
	},
	"control-palette": {
		path: "packages/control-palette",
		sources: ["src/control.js"],
	},
	"control-radio": {
		path: "packages/control-radio",
		sources: ["src/control.js"],
	},
	"control-react-colorful": {
		path: "packages/control-react-colorful",
		sources: ["src/control.js", "src/preview.js"],
	},
	"control-react-select": {
		path: "packages/control-react-select",
		sources: ["src/control.js"],
	},
	"control-repeater": {
		path: "packages/control-repeater",
		sources: ["src/control.js"],
	},
	"control-select": {
		path: "packages/control-select",
		sources: ["src/control.js"],
	},
	"control-slider": {
		path: "packages/control-slider",
		sources: ["src/control.js"],
	},
	"control-sortable": {
		path: "packages/control-sortable",
		sources: ["src/control.js"],
	},
	"field-dimensions": {
		path: "packages/field-dimensions",
		sources: ["src/control.scss", "src/preview.js"],
	},
	"field-typography": {
		path: "packages/field-typography",
		sources: ["src/control.js", "src/preview.js"],
	},
	"module-field-dependencies": {
		path: "packages/module-field-dependencies",
		sources: ["src/control.js"],
	},
	"module-tooltips": {
		path: "packages/module-tooltips",
		sources: ["src/control.js"],
	},
};

const program = sade("kirki");

program.version("1.0.0");

program
	.command("build <packageName>")
	.describe("Build a package by package name")
	.option("-d, --debug", "Output as unminified code for debugging purposes")
	.example("build control-base")
	.example("build control-base --debug")
	.action(async (packageName, opts) => {
		let command = "";

		// Check if packageName exists in the packagePaths.
		if (!packagePaths[packageName]) {
			console.log(`Package ${packageName} does not exist.`);
			return;
		}

		let sourcePaths = "";

		// Build the source command from the packagePaths.
		packagePaths[packageName].sources.forEach((source) => {
			sourcePaths += `${packagePaths[packageName].path}/${source} `;
		});

		sourcePaths = sourcePaths.trim();

		// Build the command along with the opts.
		command += `parcel build ${sourcePaths} ${
			opts.d ? "--no-optimize" : ""
		} --dist-dir ${packagePaths[packageName].path}/dist`;

		shell.exec(`${command}`);
	});

program.parse(process.argv);

#!/usr/bin/env node

import shell from "shelljs";
import sade from "sade";

const definedPackages = {
    settings: {
        path: "kirki-packages/settings",
        sources: [
            "src/admin-notice.scss",
            "src/settings.ts",
            "src/discount-notice.ts",
        ],
    },
    "control-base": {
        path: "kirki-packages/control-base",
        sources: ["src/control.js"],
    },
    "control-checkbox": {
        path: "kirki-packages/control-checkbox",
        sources: ["src/control.js"],
    },
    "control-color-palette": {
        path: "kirki-packages/control-color-palette",
        sources: ["src/control.js"],
    },
    "control-dashicons": {
        path: "kirki-packages/control-dashicons",
        sources: ["src/control.js"],
    },
    "control-date": {
        path: "kirki-packages/control-date",
        sources: ["src/control.js"],
    },
    "control-dimension": {
        path: "kirki-packages/control-dimension",
        sources: ["src/control.js"],
    },
    "control-editor": {
        path: "kirki-packages/control-editor",
        sources: ["src/control.js"],
    },
    "control-generic": {
        path: "kirki-packages/control-generic",
        sources: ["src/control.js"],
    },
    "control-image": {
        path: "kirki-packages/control-image",
        sources: ["src/control.js"],
    },
    "control-multicheck": {
        path: "kirki-packages/control-multicheck",
        sources: ["src/control.js"],
    },
    "control-palette": {
        path: "kirki-packages/control-palette",
        sources: ["src/control.js"],
    },
    "control-radio": {
        path: "kirki-packages/control-radio",
        sources: ["src/control.js"],
    },
    "control-react-colorful": {
        path: "kirki-packages/control-react-colorful",
        sources: ["src/control.js", "src/preview.js"],
    },
    "control-react-select": {
        path: "kirki-packages/control-react-select",
        sources: ["src/control.js"],
    },
    "control-repeater": {
        path: "kirki-packages/control-repeater",
        sources: ["src/control.js"],
    },
    "control-select": {
        path: "kirki-packages/control-select",
        sources: ["src/control.js"],
    },
    "control-slider": {
        path: "kirki-packages/control-slider",
        sources: ["src/control.js"],
    },
    "control-sortable": {
        path: "kirki-packages/control-sortable",
        sources: ["src/control.js"],
    },
    "field-dimensions": {
        path: "kirki-packages/field-dimensions",
        // Yes, the files are control.scss & preview.js :)
        sources: ["src/control.scss", "src/preview.js"],
    },
    "field-typography": {
        path: "kirki-packages/field-typography",
        sources: ["src/control.js", "src/preview.js"],
    },
    "module-field-dependencies": {
        path: "kirki-packages/module-field-dependencies",
        sources: ["src/control.js"],
    },
    "module-tooltips": {
        path: "kirki-packages/module-tooltips",
        sources: ["src/control.js"],
    },

};

const parcelBinPath = "node_modules/.bin/parcel";

function getPackageData(packageName) {
    return definedPackages[packageName] ? definedPackages[packageName] : null;
}

function getSourcesPath(packageData) {
    let sourcesPath = "";

    // Build the source command from the definedPackages.
    packageData.sources.forEach((source) => {
        sourcesPath += `${packageData.path}/${source} `;
    });

    return sourcesPath.trim();
}

function runParcel(commandType, packageName, opts) {
    const packageData = getPackageData(packageName);

    if (!packageData) {
        console.warn(`Package "${packageName}" is not defined.`);
        return;
    }

    if (!packageData.sources.length) {
        console.warn(
            `Package "${packageName}" does not have any sources to compile.`
        );
        return;
    }

    const sourcesPath = getSourcesPath(packageData);
    let command = "";

    // Build the CLI command along with the opts.
    command += `"${parcelBinPath}" ${commandType} ${sourcesPath} ${
		opts.d && commandType == "build" ? "--no-optimize" : ""
	} --dist-dir ${packageData.path}/dist`;

    command = command.replace(/  +/g, " ");
    command = command.trim();

    shell.exec(`${command}`);
}

// Create the program.

const program = sade("kirki");
program.version("5.1.0");

program
    .command("build <packageName>")
    .describe("Build a package by package name")
    .option("-d, --debug", "Build as unminified code for debugging purpose")
    .example("build control-base")
    .example("build control-base --debug")
    .action((packageName, opts) => {
        runParcel("build", packageName, opts);
    });

program
    .command("watch <packageName>")
    .describe(
        "Build in debug mode by package name and watch for changes. Visit your local site using normal URL. It will reload the browser automatically if there's JS change. And will implement CSS instantly when there's CSS change. Use CTRL+C to stop watching."
    )
    .example("watch control-base")
    .action((packageName, opts) => {
        runParcel("watch", packageName, opts);
    });

program
    .command("make wp")
    .describe(
        "Build Kirki as a WordPress plugin that's ready to push to WordPress.org. It will put the result into `builds` folder."
    )
    .example("make wp")
    .action((opts) => {
        // Execute build.sh
        shell.exec("bash build.sh");
    });

program.parse(process.argv);
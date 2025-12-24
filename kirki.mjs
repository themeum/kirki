#!/usr/bin/env node

import shell from "shelljs";
import sade from "sade";

const definedPackages = {
    settings: {
        path: "inc/packages/settings",
        sources: [
            "src/admin-notice.scss",
            "src/settings.ts",
            "src/discount-notice.ts",
        ],
    },
    "control-base": {
        path: "inc/packages/control-base",
        sources: ["src/control.js"],
    },
    "control-checkbox": {
        path: "inc/packages/control-checkbox",
        sources: ["src/control.js"],
    },
    "control-color-palette": {
        path: "inc/packages/control-color-palette",
        sources: ["src/control.js"],
    },
    "control-dashicons": {
        path: "inc/packages/control-dashicons",
        sources: ["src/control.js"],
    },
    "control-date": {
        path: "inc/packages/control-date",
        sources: ["src/control.js"],
    },
    "control-dimension": {
        path: "inc/packages/control-dimension",
        sources: ["src/control.js"],
    },
    "control-editor": {
        path: "inc/packages/control-editor",
        sources: ["src/control.js"],
    },
    "control-generic": {
        path: "inc/packages/control-generic",
        sources: ["src/control.js"],
    },
    "control-image": {
        path: "inc/packages/control-image",
        sources: ["src/control.js"],
    },
    "control-multicheck": {
        path: "inc/packages/control-multicheck",
        sources: ["src/control.js"],
    },
    "control-palette": {
        path: "inc/packages/control-palette",
        sources: ["src/control.js"],
    },
    "control-radio": {
        path: "inc/packages/control-radio",
        sources: ["src/control.js"],
    },
    "control-react-colorful": {
        path: "inc/packages/control-react-colorful",
        sources: ["src/control.js", "src/preview.js"],
    },
    "control-react-select": {
        path: "inc/packages/control-react-select",
        sources: ["src/control.js"],
    },
    "control-repeater": {
        path: "inc/packages/control-repeater",
        sources: ["src/control.js"],
    },
    // "control-select": {
    //     path: "inc/packages/control-select",
    //     sources: ["src/control.js"],
    // },
    "control-slider": {
        path: "inc/packages/control-slider",
        sources: ["src/control.js"],
    },
    "control-sortable": {
        path: "inc/packages/control-sortable",
        sources: ["src/control.js"],
    },
    "field-dimensions": {
        path: "inc/packages/field-dimensions",
        // Yes, the files are control.scss & preview.js :)
        sources: ["src/control.scss", "src/preview.js"],
    },
    "field-typography": {
        path: "inc/packages/field-typography",
        sources: ["src/control.js", "src/preview.js"],
    },
    "module-field-dependencies": {
        path: "inc/packages/module-field-dependencies",
        sources: ["src/control.js"],
    },
    "module-tooltips": {
        path: "inc/packages/module-tooltips",
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
	} ${commandType == "build" && !opts.d ? "--no-source-maps" : ""} --dist-dir ${packageData.path}/dist`;

    command = command.replace(/  +/g, " ");
    command = command.trim();

    shell.exec(`${command}`);
}

// Create the program.

const program = sade("kirki");
program.version("5.1.0");

program
    .command("build [packageName]")
    .describe("Build a package by package name")
    .option("-d, --debug", "Build as unminified code for debugging purpose")
		.option("-a, --all", "Build all packages, overriding the name supplied")
    .example("build control-base")
    .example("build control-base --debug")
    .action((packageName, opts) => {
			if (opts.a) {
				Object.keys(definedPackages).forEach(name => {
					console.log(name);
					runParcel("build", name, opts)
				});
			} else {
				if (packageName) {
					runParcel("build", packageName, opts);
				}
			}
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

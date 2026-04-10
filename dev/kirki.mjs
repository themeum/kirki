#!/usr/bin/env node

import { execSync } from "child_process";

const definedPackages = {
    settings: {
        path: "customizer/packages/settings",
        sources: [
            "src/admin-notice.scss",
            "src/settings.ts",
            "src/discount-notice.ts",
        ],
    },
    "control-base": {
        path: "customizer/packages/controls/base",
        sources: ["src/control.js"],
    },
    "control-checkbox": {
        path: "customizer/packages/controls/checkbox",
        sources: ["src/control.js"],
    },
    "control-color-palette": {
        path: "customizer/packages/controls/color-palette",
        sources: ["src/control.js"],
    },
    "control-dashicons": {
        path: "customizer/packages/controls/dashicons",
        sources: ["src/control.js"],
    },
    "control-date": {
        path: "customizer/packages/controls/date",
        sources: ["src/control.js"],
    },
    "control-dimension": {
        path: "customizer/packages/controls/dimension",
        sources: ["src/control.js"],
    },
    "control-editor": {
        path: "customizer/packages/controls/editor",
        sources: ["src/control.js"],
    },
    "control-generic": {
        path: "customizer/packages/controls/generic",
        sources: ["src/control.js"],
    },
    "control-image": {
        path: "customizer/packages/controls/image",
        sources: ["src/control.js"],
    },
    "control-input-slider": {
        path: "customizer/packages/controls/input-slider",
        sources: ["src/control.js"],
    },
    "control-margin-padding": {
        path: "customizer/packages/controls/margin-padding",
        sources: ["src/control.js", "src/preview.js"],
    },
    "control-multicheck": {
        path: "customizer/packages/controls/multicheck",
        sources: ["src/control.js"],
    },
    "control-palette": {
        path: "customizer/packages/controls/palette",
        sources: ["src/control.js"],
    },
    "control-radio": {
        path: "customizer/packages/controls/radio",
        sources: ["src/control.js"],
    },
    "control-react-colorful": {
        path: "customizer/packages/controls/react-colorful",
        sources: ["src/control.js", "src/preview.js"],
    },
    "control-react-select": {
        path: "customizer/packages/controls/react-select",
        sources: ["src/control.js"],
    },
    "control-repeater": {
        path: "customizer/packages/controls/repeater",
        sources: ["src/control.js"],
    },
    "control-responsive": {
        path: "customizer/packages/controls/responsive",
        sources: ["src/control.js"],
    },
    // "control-select": {
    //     path: "customizer/packages/controls/select",
    //     sources: ["src/control.js"],
    // },
    "control-slider": {
        path: "customizer/packages/controls/slider",
        sources: ["src/control.js"],
    },
    "control-sortable": {
        path: "customizer/packages/controls/sortable",
        sources: ["src/control.js"],
    },
    "control-tabs": {
        path: "customizer/packages/controls/tabs",
        sources: ["src/control.js"],
    },
    "field-dimensions": {
        path: "customizer/packages/fields/dimensions",
        // Yes, the files are control.scss & preview.js :)
        sources: ["src/control.scss", "src/preview.js"],
    },
    "field-typography": {
        path: "customizer/packages/fields/typography",
        sources: ["src/control.js", "src/preview.js"],
    },
    "module-field-dependencies": {
        path: "customizer/packages/modules/field-dependencies",
        sources: ["src/control.js"],
    },
    "module-tooltips": {
        path: "customizer/packages/modules/tooltips",
        sources: ["src/control.js"],
    },
    "module-panels": {
        path: "customizer/packages/modules/panels",
        sources: ["src/script.js"],
    },
    "module-sections": {
        path: "customizer/packages/modules/sections",
        sources: ["src/script.js"],
    },
    "module-preset": {
        path: "customizer/packages/modules/preset",
        sources: ["src/script.js"],
    },
    "module-postmessage": {
        path: "customizer/packages/modules/postmessage",
        sources: ["src/postMessage.js"],
    },
    "module-section-icons": {
        path: "customizer/packages/modules/section-icons",
        sources: ["src/icons.js"],
    },
    "field-background": {
        path: "customizer/packages/fields/background",
        sources: ["src/script.js"],
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

    execSync(command, { stdio: "inherit" });
}

// Parse command line arguments
const args = process.argv.slice(2);
const command = args[0];
const packageName = args[1];

// Parse options
const opts = {
    d: args.includes("--debug") || args.includes("-d"),
    a: args.includes("--all") || args.includes("-a"),
};

// Handle commands
if (command === "build") {
    if (opts.a) {
        Object.keys(definedPackages).forEach((name) => {
            console.log(name);
            runParcel("build", name, opts);
        });
    } else if (packageName) {
        runParcel("build", packageName, opts);
    } else {
        console.error("Error: Package name is required for build command (or use --all)");
        console.log("Usage: kirki build <packageName>");
        console.log("       kirki build --all");
        console.log("Example: kirki build control-base");
        process.exit(1);
    }
} else if (command === "watch") {
    if (packageName) {
        runParcel("watch", packageName, opts);
    } else {
        console.error("Error: Package name is required for watch command");
        console.log("Usage: kirki watch <packageName>");
        console.log("Example: kirki watch control-base");
        process.exit(1);
    }
} else if (command === "make" && args[1] === "wp") {
    // Execute build.sh
    execSync("bash build.sh", { stdio: "inherit" });
} else {
    console.log("Kirki Build Tool v5.1.0");
    console.log("");
    console.log("Usage:");
    console.log("  kirki build [packageName]     Build a package by package name");
    console.log("  kirki build [packageName] --debug  Build as unminified code for debugging");
    console.log("  kirki build --all             Build all packages");
    console.log("  kirki watch <packageName>     Build in debug mode and watch for changes");
    console.log("  kirki make wp                 Build Kirki as a WordPress plugin");
    console.log("");
    console.log("Examples:");
    console.log("  kirki build control-base");
    console.log("  kirki build control-base --debug");
    console.log("  kirki watch control-base");
    console.log("  kirki make wp");
    process.exit(1);
}

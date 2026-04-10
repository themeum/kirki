import { execSync } from "child_process";
import fs from "fs";
import path from "path";

const PLUGIN_FILE = "kirki.php";
const content = fs.readFileSync(PLUGIN_FILE, "utf-8");
const versionMatch = content.match(/Version:\s*(.+)/);
const VERSION = versionMatch ? versionMatch[1].trim() : "unknown";

const PLUGIN_SLUG = "kirki";
const ZIP_NAME = `${PLUGIN_SLUG}-${VERSION}.zip`;
const BUILD_DIR = "dist-temp";
const FINAL_DIST_DIR = "dist";

console.log(`Building Kirki v${VERSION}...`);

// 1. Clean up
if (fs.existsSync(BUILD_DIR)) fs.rmSync(BUILD_DIR, { recursive: true });
if (fs.existsSync(FINAL_DIST_DIR)) fs.rmSync(FINAL_DIST_DIR, { recursive: true });
fs.mkdirSync(FINAL_DIST_DIR);

// 2. Run the main build
console.log("Running Parcel build...");
execSync("npm run build", { stdio: "inherit" });

// 3. Prepare temporary build directory
console.log("Preparing files for zip...");
const fullBuildPath = path.join(BUILD_DIR, PLUGIN_SLUG);
fs.mkdirSync(fullBuildPath, { recursive: true });

// Files to copy to the root of the plugin
const toCopy = [
    "assets",
    "customizer",
    "languages",
    "kirki.php",
    "readme.txt",
    "LICENSE",
    "composer.json",
];

toCopy.forEach((item) => {
    if (fs.existsSync(item)) {
        execSync(`cp -r "${item}" "${fullBuildPath}/"`);
    }
});

// 3.5 Generate POT file
console.log("Generating translation file (.pot)...");
try {
    // We run it on the temporary directory so it includes all copied PHP/JS
    execSync(`cd "${fullBuildPath}" && wp i18n make-pot . languages/${PLUGIN_SLUG}.pot --slug=${PLUGIN_SLUG} --domain=${PLUGIN_SLUG}`, { stdio: "inherit" });
} catch (e) {
    console.warn("WP-CLI i18n failed. Skipping POT generation. (Is WP-CLI installed?)");
}

// 4. Handle Autoloader (No external dependencies needed)
console.log("Generating optimized autoloader...");
try {
    // Generate autoloader for local packages only
    execSync(`cd "${fullBuildPath}" && composer dump-autoload --no-dev --optimize -n`, { stdio: "inherit" });
} catch (e) {
    console.warn("Composer failed. Autoloading might be broken.");
}

// 5. Cleanup inside the zip content
console.log("Cleaning up unneeded files from zip content...");

// Delete unnecessary files and directories
const cleanupCommands = [
    `find "${fullBuildPath}" -type f -name "*.map" -delete`,
    `find "${fullBuildPath}" -type f -name "*.ts" -delete`,
    `find "${fullBuildPath}" -type f -name "*.tsx" -delete`,
    `find "${fullBuildPath}" -type f -name "*.scss" -delete`,
    `find "${fullBuildPath}" -type f -name "*.sass" -delete`,
    `find "${fullBuildPath}" -type f -name ".gitignore" -delete`,
    `find "${fullBuildPath}" -type f -name ".babelrc" -delete`,
    `find "${fullBuildPath}" -type f -name "tsconfig.json" -delete`,
    `find "${fullBuildPath}" -type f -name "jsconfig.json" -delete`,
    `find "${fullBuildPath}" -type f -name "package.json" -delete`,
    `find "${fullBuildPath}" -type f -name "package-lock.json" -delete`,
    `find "${fullBuildPath}" -type f -name "composer.json" -delete`,
    `find "${fullBuildPath}" -type f -name "composer.lock" -delete`,
    `find "${fullBuildPath}" -type f -name "Gruntfile.js" -delete`,
    `find "${fullBuildPath}" -type f -name "README.md" -delete`,
    `find "${fullBuildPath}" -type f -name "CHANGELOG.md" -delete`,
    `find "${fullBuildPath}" -type f -name "CODE_OF_CONDUCT.md" -delete`,
    `find "${fullBuildPath}" -type f -name "readme.txt" ! -path "${fullBuildPath}/readme.txt" -delete`,
    `find "${fullBuildPath}" -type f -name "LICENSE" ! -path "${fullBuildPath}/LICENSE" -delete`,
    `find "${fullBuildPath}" -type f -name "*.xml" -delete`,
    `find "${fullBuildPath}" -type f -name "*.mjs" -delete`,
    `find "${fullBuildPath}" -type f -name "*.bat" -delete`,
    // Heavy JSON files and polyfills
    `find "${fullBuildPath}" -type f -name "webfont-files.json" -delete`,
    `rm -rf "${fullBuildPath}/customizer/packages/compatibility/src/scripts"`,
    // Cleanup non-minified assets from the bundle folder
    `find "${fullBuildPath}/assets/customizer" -type f ! -name "*.min.*" -delete`,
    // Cleanup source JS from packages (built files are in assets/)
    `find "${fullBuildPath}/customizer/packages" -type f -name "*.js" -delete`,
    `rm -f "${fullBuildPath}/customizer/example.php"`,
    // Dirs
    `find "${fullBuildPath}" -type d -name ".github" -exec rm -rf {} +`,
    `find "${fullBuildPath}" -type d -name ".git" -exec rm -rf {} +`,
    `find "${fullBuildPath}/vendor" -type d -name "tests" -exec rm -rf {} +`,
    `find "${fullBuildPath}/vendor" -type f -name "phpunit.xml*" -delete`,
];

cleanupCommands.forEach((cmd) => {
    try {
        execSync(`${cmd} 2>/dev/null || true`);
    } catch (e) { }
});

// 6. Create the zip
console.log(`Creating ${ZIP_NAME}...`);
execSync(`cd ${BUILD_DIR} && zip -r "../${FINAL_DIST_DIR}/${ZIP_NAME}" ${PLUGIN_SLUG} > /dev/null`);

// 7. Final Cleanup
fs.rmSync(BUILD_DIR, { recursive: true });

console.log(`\nSUCCESS! Build ready at ${FINAL_DIST_DIR}/${ZIP_NAME}`);
const stats = fs.statSync(`${FINAL_DIST_DIR}/${ZIP_NAME}`);
console.log(`Final zip size: ${(stats.size / 1024 / 1024).toFixed(2)} MB`);

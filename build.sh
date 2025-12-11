#!/usr/bin/env bash

echo ""
echo "*******************************************"
echo "**   Building the WP plugin version...   **"
echo ""

shopt -s extglob
shopt -s dotglob

if [ ! -d "builds" ]; then
	mkdir builds
fi

if [ -d "builds/kirki" ]; then
	rm -rf builds/kirki
fi

if [ -d "builds/kirki.zip" ]; then
	rm -rf builds/kirki.zip
fi

mkdir builds/kirki

echo "Copying files (please be patient :) ...";

cp -r !(.|..|.git|.gitignore|.gitattributes|.github|builds|node_modules|.parcel-cache|.editorconfig|.phpcs.xml.dist|phpcs.xml.dist|phpcs.xml|kirki.mjs|kirki.bat|build.sh|CHANGELOG.md|CODE_OF_CONDUCT.md|example.php|package.json|package-lock.json|pnpm-lock.yaml|README.md|Gruntfile.js|webpack.config.js|.babelrc|.prettierrc.js|.prettierignore) builds/kirki

cd builds/kirki

echo "Removing dev dependencies content from composer.json ...";

# sed -i '/composer\/installers/d' composer.json
sed -i '/composer\/installers": "*"/d' composer.json
# sed -i '/dealerdirect\/phpcodesniffer-composer-installer/d' composer.json
sed -i '/dealerdirect\/phpcodesniffer-composer-installer": "*"/d' composer.json
sed -i '/wp-coding-standards\/wpcs/d' composer.json
sed -i '/phpcompatibility\/phpcompatibility-wp/d' composer.json
sed -i '/wptrt\/wpthemereview/d' composer.json

echo "Now updating composer after the dev dependencies removal ...";

composer install --no-dev --optimize-autoloader --classmap-authoritative -n

echo "Removing un-necessary files inside individual packages ..."

# Remove source map files from production build
echo "Removing source map files (.map) ..."
find kirki-packages -type f -name "*.map" -delete
find pro-src -type f -name "*.map" -delete 2>/dev/null || true

# Remove development files (not needed for WordPress plugin functionality)
echo "Removing development files (LICENSE, package.json, .gitignore, Gruntfile.js) ..."
find kirki-packages -type f \( -name "LICENSE" -o -name "package.json" -o -name ".gitignore" -o -name "Gruntfile.js" \) -delete
find pro-src -type f \( -name "package.json" -o -name "composer.json" -o -name ".gitignore" \) -delete 2>/dev/null || true
find . -type f -name "LICENSE" -delete 2>/dev/null || true

# Remove composer installed.json files (not needed for autoloading)
echo "Removing composer installed.json files ..."
find . -type f -path "*/composer/installed.json" -delete 2>/dev/null || true

# Remove source files that are compiled to dist/ (keep PHP files and directly-used JS files)
echo "Removing compiled source files (.ts, .tsx, .scss, .sass, and .js in src/ except required ones) ..."
# Remove TypeScript source files (compiled to dist/)
find kirki-packages -type f -path "*/src/*" \( -name "*.ts" -o -name "*.tsx" \) -delete 2>/dev/null || true
find pro-src -type f -path "*/src/*" \( -name "*.ts" -o -name "*.tsx" \) -delete 2>/dev/null || true

# Remove SCSS source files (compiled to dist/)
find kirki-packages -type f -path "*/src/*" \( -name "*.scss" -o -name "*.sass" \) -delete 2>/dev/null || true
find pro-src -type f -path "*/src/*" \( -name "*.scss" -o -name "*.sass" \) -delete 2>/dev/null || true

# Remove JS source files that are compiled to dist/ (but keep compatibility scripts and webfontloader)
# These are source files that get compiled - only dist/ files are needed
find kirki-packages/control-* -type f -path "*/src/*.js" ! -path "*/compatibility/*" -delete 2>/dev/null || true
find kirki-packages/field-* -type f -path "*/src/*.js" -delete 2>/dev/null || true
find kirki-packages/module-* -type f -path "*/src/*.js" ! -path "*/module-webfonts/src/assets/scripts/vendor-typekit/webfontloader.js" -delete 2>/dev/null || true
find kirki-packages/settings -type f -path "*/src/*.js" -delete 2>/dev/null || true
find pro-src -type f -path "*/src/*.js" -delete 2>/dev/null || true

# Remove webfonts vendor source files (webfontloader.js is the compiled version, source files not needed)
find kirki-packages/module-webfonts/src/assets/scripts/vendor-typekit/src -type f -delete 2>/dev/null || true
find kirki-packages/module-webfonts/src/assets/scripts/vendor-typekit -type d -name "src" -exec rm -rf {} + 2>/dev/null || true
find kirki-packages/module-webfonts/src/assets/scripts/vendor-typekit -type f -name "*.yml" -delete 2>/dev/null || true

cd ../../

shopt -u extglob
shopt -u dotglob

echo ""
echo "** All done.                                  **"
echo "** WP plugin version is ready                 **"
echo '** You can check the result in "builds/kirki" **'
echo "**                                            **"
echo "******************** DONE **********************"
echo ""

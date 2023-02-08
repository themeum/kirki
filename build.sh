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

cp -r !(.|..|.git|.gitignore|.gitattributes|.github|builds|node_modules|.parcel-cache|.editorconfig|.phpcs.xml.dist|phpcs.xml.dist|phpcs.xml|kirki.mjs|kirki.bat|build.sh|CHANGELOG.md|CODE_OF_CONDUCT.md|example.php|package.json|package-lock.json|README.md|Gruntfile.js|webpack.config.js|.babelrc|.prettierrc.js|.prettierignore) builds/kirki

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

composer update -n

echo "Removing un-necessary files inside individual packages ..."

# Would you like to remove the CSS source files?
# If so, un-comment the following lines.
# rm -rf kirki-packages/**/src/*.scss
# rm -rf kirki-packages/**/src/scss/*.scss

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

#!/usr/bin/env bash

echo ""
echo "******************************************"
echo "** Building the WP plugin version...    **"
echo ""

shopt -s extglob
shopt -s dotglob

if [ -d "kirki" ]; then
	rm -rf kirki
fi

mkdir kirki

echo "Copying files ...";

cp -r !(.|..|.git|.github|kirki|node_modules|.editorconfig|.gitignore|.gitattributes|.phpcs.xml.dist|build.sh|CHANGELOG.md|CODE_OF_CONDUCT.md|example.php|package.json|package-lock.json|README.md) kirki/

cd ..

if [ -d "kirki" ]; then
	rm -rf kirki
fi

mkdir kirki

mv kirki-git/kirki/* kirki/

rm -rf kirki-git/kirki/

cd kirki

echo "Updating composer to remove dev dependencies (be patient :) ...";

sed -i '/composer\/installers/d' composer.json
sed -i '/dealerdirect\/phpcodesniffer-composer-installer/d' composer.json
sed -i '/wp-coding-standards\/wpcs/d' composer.json
sed -i '/phpcompatibility\/phpcompatibility-wp/d' composer.json
sed -i '/wptrt\/wpthemereview/d' composer.json

composer update

echo "Removing un-necessary files inside individual packages ..."

rm -rf packages/kirki-framework/**/.github
rm -rf packages/kirki-framework/**/.gitignore
rm -rf packages/kirki-framework/**/src/*.scss
rm -rf packages/kirki-framework/**/src/scss/*.scss
rm -rf packages/kirki-framework/**/.prettierrc.js
rm -rf packages/kirki-framework/**/.prettierignore
rm -rf packages/kirki-framework/**/.babelrc
rm -rf packages/kirki-framework/**/webpack.config.js
rm -rf packages/kirki-framework/**/package.json
rm -rf packages/kirki-framework/**/Gruntfile.js
rm -rf packages/kirki-framework/**/README.md

cd ../kirki-git

shopt -u extglob
shopt -u dotglob

echo ""
echo "** All done.                            **"
echo "** WP plugin version is ready           **"
echo "** You can check the result in ../kirki **"
echo "**                                      **"
echo "****************** DONE ******************"
echo ""

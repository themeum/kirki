#!/usr/bin/env bash
echo ""
echo "******************************************"
echo "**                                      **"
echo "** Cloning repository...                **"
if [ -d "../kirki-package" ]; then
	rm -rf ../kirki-package &> /dev/null
	mkdir ../kirki-package
fi

git clone https://github.com/aristath/kirki.git ../kirki-package/kirki &> /dev/null

cd ../kirki-package/kirki

echo "** Running npm install...               **"
npm install &> /dev/null

echo "** Running grunt...                     **"
grunt  &> /dev/null

echo "** Cleaning up files...                 **"
rm -rf .git
rm -rf .github
rm -rf .sass-cache
rm -rf controls/css/*.map
rm -rf controls/js/src
rm -rf controls/scss
rm -rf docs
rm modules/custom-sections/*.scss
rm modules/custom-sections/*.map
rm modules/tooltips/*.scss
rm modules/tooltips/*.map
rm -rf node_modules
rm -rf tests
rm .codeclimate.yml
rm .coveralls.yml
rm .csslintrc
rm .editorconfig
rm .gitignore
rm .jscsrc
rm .jshintignore
rm .jshintrc
rm .jhintrc
rm .phpcs.xml.dist
rm .simplecov
rm .travis.yml
rm CODE_OF_CONDUCT.md
rm composer.*
rm -rf vendor/
rm example.php
rm Gruntfile.js
rm package.json
rm phpunit.xml
rm phpunit.xml.dist
rm README.md
rm *.sh
rm package-lock.json

cd ..
zip -rq kirki.zip kirki

echo "** All done.                            **"
echo "** Final plugin ready for release       **"
echo "** You can get in from ../kirki-package **"
echo "**                                      **"
echo "****************** DONE ******************"
echo ""

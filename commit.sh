#!/usr/bin/env bash

SVNMSG="${1//#/https\:\/\/github.com\/aristath\/kirki\/issues\/}"

# Create svn directory if it doesn't exist
if [ ! -d "./svn" ]; then
	mkdir svn
	svn co https://plugins.svn.wordpress.org/kirki svn
fi

# commit & push to git
git add .
git commit -a -m "$1"
git push origin develop

# Copy files to SVN directory
rm -rf ../svncopytemp
cp -r . ../svncopytemp
rm -rf ../svncopytemp/svn
rm -rf svn/trunk
cp -r ../svncopytemp svn/trunk
rm -rf ../svncopytemp

# Cleanup files in trunk
rm -rf svn/trunk/.git
rm -rf svn/trunk/.github
rm -rf svn/trunk/assets/scss/
rm -rf svn/trunk/vendor/
rm -rf svn/trunk/node_modules
rm -rf svn/trunk/.sass-cache
rm -rf svn/trunk/tests
rm -f svn/trunk/*.sh
rm -f svn/trunk/.codeclimate.yml
rm -f svn/trunk/.coveralls.yml
rm -f svn/trunk/.csslintrc
rm -f svn/trunk/.editorconfig
rm -f svn/trunk/.gitignore
rm -f svn/trunk/.jscsrc
rm -f svn/trunk/.jshintignore
rm -f svn/trunk/.jshintrc
rm -f svn/trunk/.simplecov
rm -f svn/trunk/.travis.yml
rm -f svn/trunk/Gruntfile.js
rm -f svn/trunk/composer.json
rm -f svn/trunk/package.json
rm -f svn/trunk/phpunit.xml
rm -f svn/trunk/codesniffer.ruleset.xml
rm -f svn/trunk/README.md

# commit to SVN
cd svn
svn rm $( svn status | sed -e '/^!/!d' -e 's/^!//' )
svn add trunk/* --force
svn ci -m "$SVNMSG"
cd ..

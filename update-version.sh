#!/usr/bin/env bash

Grunt
npm install && grunt

# Create svn directory.
if [ -d "./svn" ]; then
	rm -rf svn
fi
mkdir svn
svn co https://plugins.svn.wordpress.org/kirki svn

# Copy files to SVN directory
# We're using a dummy dir for convenience here.
rm -rf ../svncopytemp
cp -r . ../svncopytemp
rm -rf ../svncopytemp/svn
rm -rf svn/trunk
cp -r ../svncopytemp svn/trunk
rm -rf ../svncopytemp

# Cleanup files in trunk
rm -rf svn/trunk/.git
rm -rf svn/trunk/.github
rm -rf svn/trunk/.sass-cache
rm -rf svn/trunk/node_modules
rm -rf svn/trunk/tests
rm -r svn/trunk/.codeclimate.yml
rm -r svn/trunk/.coveralls.yml
rm -r svn/trunk/.csslintrc
rm -r svn/trunk/.editorconfig
rm -r svn/trunk/.gitignore
rm -r svn/trunk/.jscsrc
rm -r svn/trunk/.jshintignore
rm -r svn/trunk/.jshintrc
rm -r svn/trunk/.simplecov
rm -r svn/trunk/.travis.yml
rm -r svn/trunk/composer.json
rm -r svn/trunk/Gruntfile.js
rm -r svn/trunk/package.json
rm -r svn/trunk/phpcs.ruleset.xml
rm -r svn/trunk/phpunit.xml
rm -r svn/trunk/README.md
rm -r svn/trunk/update-version.sh
rm -r svn/trunk/**/*.css.map
rm -r svn/trunk/**/*.scss
rm -r svn/trunk/assets/vendor/select2/kirki.css.map
rm -r svn/trunk/assets/vendor/select2/kirki.scss

# Copy trunk to tags.
cp -r svn/trunk svn/tags/$1

# commit to SVN
cd svn
svn rm $( svn status | sed -e '/^!/!d' -e 's/^!//' )
svn add trunk/* --force
svn add tags/* --force
svn ci -m "Version $1"
cd ..

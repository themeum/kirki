#!/usr/bin/env bash

if [ $# -lt 3 ]; then
	echo "usage: $0 message <old-version> <new-version>"
	exit 1
fi

rm -Rf ../kirki-release
git clone git@github.com:aristath/kirki.git ../kirki-release
cd ../kirki-release

# Replace version number in the files
find . -name kirki.php -exec sed -i "s/Version:       $2/Version:       $3/g" {} \;
find . -name readme.txt -exec sed -i "s/Stable tag: $2/Stable tag: $3/g" {} \;

# Run grunt
npm install
grunt
grunt googlefonts
grunt makepot
grunt readme

if [[ '' != $1 ]]; then
	# Git commit
	git add . && git commit -a -m "$1" && git push
fi

mkdir svn
svn co https://plugins.svn.wordpress.org/kirki svn

# remove trunk
rm -rf svn/trunk

# copy fresh copy to trunk
rsync -av . svn/trunk --exclude svn

# remove unnecessary files
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

# Update svn
cd svn
if [[ '' != $1 ]]; then
	if [[ $2 != $3 ]]; then
		rm tags/$3
		cp -r trunk tags/$3
	fi
	svn rm $( svn status | sed -e '/^!/!d' -e 's/^!//' )
	svn add * --force
	svn ci -m "$1"
	cd ../..
	rm -rf kirki-release
fi

#!/usr/bin/env bash

if [ $# -lt 3 ]; then
	echo "usage: $0 <old-version> <new-version>"
	echo "OR: $0 <old-version> <new-version> push (to directly push to both git & svn)"
	exit 1
fi

rm -Rf ../kirki-release
git clone git@github.com:aristath/kirki.git ../kirki-release
cd ../kirki-release

# Replace version number in the files
find . -name kirki.php -exec sed -i "s/Version:       $1/Version:       $2/g" {} \;
find . -name readme.txt -exec sed -i "s/Stable tag: $1/Stable tag: $2/g" {} \;

# Run grunt
npm install
grunt
grunt googlefonts
grunt makepot
grunt readme

if [[ $3 == 'push' ]]; then
	# Git commit
	git add . && git commit -a -m "Version $2" && git push
fi

mkdir svn
svn co https://plugins.svn.wordpress.org/kirki svn

# remove trunk
rm -rf svn/trunk

# copy fresh copy to trunk
rsync -av . svn/trunk --exclude svn

# remove unnecessary files
rm -rf svn/trunk/node_modules
rm -rf svn/trunk/.sass-cache
rm -rf svn/trunk/.git
rm -rf svn/trunk/.github
# rm -rf svn/trunk/tests
rm -rf svn/trunk/*.sh
rm -rf svn/trunk/.codeclimate.yml
rm -rf svn/trunk/.coveralls.yml
rm -rf svn/trunk/.csslintrc
rm -rf svn/trunk/.editorconfig
rm -rf svn/trunk/.gitignore
rm -rf svn/trunk/.simplecov
rm -rf svn/trunk/.travis.yml
rm -rf svn/trunk/Gruntfile.js
rm -rf svn/trunk/composer.json
rm -rf svn/trunk/package.json
rm -rf svn/trunk/phpunit.xml
rm -rf svn/trunk/assets/scss/
rm -rf svn/trunk/vendor/

# Update svn
cd svn
if [[ $3 == 'push' ]]; then
	rm tags/$2
	cp -r trunk tags/$2
	svn rm $( svn status | sed -e '/^!/!d' -e 's/^!//' )
	svn add * --force
	svn ci -m "v$2"
	cd ../..
	rm -rf kirki-release
fi

#!/usr/bin/env bash

if [ $# -lt 3 ]; then
	echo "usage: $0 <old-version> <new-version>"
	echo "OR: $0 <old-version> <new-version> push (to directly push to both git & svn)"
	exit 1
fi

# Replace version number in the files
find . -name kirki.php -exec sed -i "s/Version:       $1/Version:       $2/g" {} \;
find . -name readme.txt -exec sed -i "s/Stable tag: $1/Stable tag: $2/g" {} \;
find ./includes -name class-kirki-toolkit.php -exec sed -i "s/protected static $version = '$1';/protected static $version = '$2';/g" {} \;

# Run grunt
npm install
grunt
grunt googlefonts
grunt makepot
grunt wp_readme_to_markdown

if [[ $3 == 'push' ]]; then
	# Git commit
	git add . && git commit -a -m "Version $2" && git push
fi

# Remove existing kirki-svn folder and pull a fresh copy
rm -rf ../kirki-svn
mkdir ../kirki-svn
svn co https://plugins.svn.wordpress.org/kirki ../kirki-svn

# remove trunk
rm -rf ../kirki-svn/trunk

# copy fresh copy to trunk
rsync -av . ../kirki-svn/trunk --exclude svn

# remove unnecessary files
rm -rf ../kirki-svn/trunk/node_modules
rm -rf ../kirki-svn/trunk/.sass-cache
rm -rf ../kirki-svn/trunk/.git
rm -rf ../kirki-svn/trunk/.github
# rm -rf ../kirki-svn/trunk/tests
rm -rf ../kirki-svn/trunk/*.sh
rm -rf ../kirki-svn/trunk/.codeclimate.yml
rm -rf ../kirki-svn/trunk/.coveralls.yml
rm -rf ../kirki-svn/trunk/.csslintrc
rm -rf ../kirki-svn/trunk/.editorconfig
rm -rf ../kirki-svn/trunk/.gitignore
rm -rf ../kirki-svn/trunk/.simplecov
rm -rf ../kirki-svn/trunk/.travis.yml
rm -rf ../kirki-svn/trunk/Gruntfile.js
rm -rf ../kirki-svn/trunk/composer.json
rm -rf ../kirki-svn/trunk/package.json
rm -rf ../kirki-svn/trunk/phpunit.xml
rm -rf ../kirki-svn/trunk/assets/scss/
rm -rf ../kirki-svn/trunk/vendor/

# Update svn
cd ../kirki-svn
if [[ $3 == 'push' ]]; then
	rm tags/$2
	cp -r trunk tags/$2
fi
svn rm $( svn status | sed -e '/^!/!d' -e 's/^!//' )
svn add * --force
if [[ $3 == 'push' ]]; then
	svn ci -m "v$2"
fi

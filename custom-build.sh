if [ -f assets/vendor/wp-color-picker-alpha/wp-color-picker-alpha.js ]; then
	cat assets/vendor/wp-color-picker-alpha/wp-color-picker-alpha.js >> build.js
	rm assets/vendor/wp-color-picker-alpha/wp-color-picker-alpha.js
fi
for controlDir in ./controls/*; do
	if [ -d "${controlDir}" ]; then
		for scssFile in "${controlDir}"/*.scss; do
			if [ -f "${scssFile}" ]; then
				cat "$scssFile" >> build.scss
				rm "${controlDir}"/*.scss
				rm "${controlDir}"/*.map
				rm "${controlDir}"/*.css
			fi
		done
		for jsFile in "${controlDir}"/*.js; do
			if [ -f "${jsFile}" ]; then
				cat "$jsFile" >> build.js
				rm "${controlDir}"/*.js
			fi
		done
	fi
done

# Add the custom colorpicker if it exists.
if [ -f assets/vendor/wp-color-picker-alpha/wp-color-picker-alpha.js ]; then
	cat assets/vendor/wp-color-picker-alpha/wp-color-picker-alpha.js >> build.js
	rm assets/vendor/wp-color-picker-alpha/wp-color-picker-alpha.js
fi

# Loop controls.
for controlDir in ./controls/*; do
	if [ -d "${controlDir}" ]; then
		# Compile all SCSS files to a single build.scss file and delete them.
		for scssFile in "${controlDir}"/*.scss; do
			if [ -f "${scssFile}" ]; then
				cat "$scssFile" >> build.scss
				rm "${controlDir}"/*.scss
				rm "${controlDir}"/*.map
				rm "${controlDir}"/*.css
			fi
		done
		# Compile all JS files to a single build.js file and delete them.
		for jsFile in "${controlDir}"/*.js; do
			if [ -f "${jsFile}" ]; then
				cat "$jsFile" >> build.js
				rm "${controlDir}"/*.js
			fi
		done
	fi
done

sass --update build.scss:build.css
sass --update build.scss:build.min.css --style compressed

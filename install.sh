#!/bin/bash
# VestaCP Wordpress Application Installer

echo "This will install VeataCP Wordpress Installer in your VestaCP"

# Check if WP CLI is Installed // Install WP CLI
wpcli=/usr/local/vesta/bin/wp
if test -f "$wpcli"; then
	echo "WP-CLI already installed."
	echo "This Script Will Update VeataCP Wordpress Installer"
	cd /usr/local/vesta/bin
	curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
	mv wp-cli.phar wp
	chmod +x wp
	echo "WP-CLI ppdated succefully."

else
	# Installing WP-CLI
	echo "Installing WP CLI"
	cd /usr/local/vesta/bin
	curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
	mv wp-cli.phar wp
	chmod +x wp
	mkdir /usr/local/vesta/web/install
	mkdir /usr/local/vesta/web/install/wordpress
	echo "WP-CLI installed succefully."

fi

# Install / Update VestaCP Wordpress Application Installer

	cd /usr/local/vesta/bin
	curl -O https://raw.githubusercontent.com/maskoid/vestacp-wordpress-installer/master/vesta/bin/v-install-wordpress
	chmod 755 v-install-wordpress
	chmod +x v-install-wordpress

	cd /usr/local/vesta/web/install/wordpress
	curl -O https://raw.githubusercontent.com/maskoid/vestacp-wordpress-installer/master/vesta/web/install/wordpress/index.php
	cd /usr/local/vesta/web/templates/admin
	curl -O https://raw.githubusercontent.com/maskoid/vestacp-wordpress-installer/master/vesta/web/templates/admin/install_wp.html
	# Add to Navigation Admin User
	curl -O https://raw.githubusercontent.com/maskoid/vestacp-wordpress-installer/master/vesta/web/templates/admin/panel.html
	# Add to Navigation Normal User
	cd /usr/local/vesta/web/templates/user
	curl -O https://raw.githubusercontent.com/maskoid/vestacp-wordpress-installer/master/vesta/web/templates/user/panel.html

	# Success
	echo "VestaCP Wordpress Application Installer by maskoid.com is SUCCESSFULLY INSTALLED/UPDATED"



#!/bin/bash
# VestaCP Wordpress Application Installer

echo "This will install VeataCP Wordpress Installer in your VestaCP"

# Check if WP CLI is Installed // Install WP CLI
wpcli=/usr/local/vesta/bin/wp-cli.phar
if test -f "$wpcli"; then
	echo "WP-CLI already installed."
else
	cd /usr/local/vesta/bin
	curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
	chmod +x wp-cli.phar
	#All users will use same folder for cache. Good when there are 100s of users on single server.
	echo "WP_CLI_CACHE_DIR=/home/admin/.wp-cli/cache" >> /etc/environment
	source /etc/environment
fi

# Install VestaCP Wordpress Application Installer

mkdir /usr/local/vesta/web/install
mkdir /usr/local/vesta/web/install/wordpress

cd /usr/local/vesta/bin
curl -O https://raw.githubusercontent.com/maskoid/vestacp-wordpress-installer/master/bin/v-install-wordpress
chmod 755 v-install-wordpress
chmod +x v-install-wordpress

cd /usr/local/vesta/web/install/wordpress
curl -O https://raw.githubusercontent.com/maskoid/vestacp-wordpress-installer/master/web/install/wordpress/index.php
cd /usr/local/vesta/web/templates/admin
curl -O https://raw.githubusercontent.com/maskoid/vestacp-wordpress-installer/master/web/templates/admin/install_wp.html
# Add to Navigation Admin User
curl -O https://raw.githubusercontent.com/maskoid/vestacp-wordpress-installer/master/web/templates/admin/panel.html
# Add to Navigation Normal User
cd /usr/local/vesta/web/templates/user
curl -O https://raw.githubusercontent.com/maskoid/vestacp-wordpress-installer/master/web/templates/user/panel.html

# Success

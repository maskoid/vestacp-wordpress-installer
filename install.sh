# VestaCP Wordpress Application Installer

echo "This will install VeataCP Wordpress Installer in your VestaCP"

# Install WP CLI
cd /usr/local/vesta/bin
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
echo "WP_CLI_CACHE_DIR=/home/admin/.wp-cli/cache" >> /etc/environment
##export WP_CLI_CACHE_DIR=/dev/null
source /etc/environment

# Install Installer
https://github.com/maskoid/vestacp-wordpress-installer/blob/master/bin/v-install-wordpress

Change MOde to 755
Make it executable
chmod +x v-install-wordpress

# Install FrontEnd

mkdir /usr/local/vesta/web/install
mkdir /usr/local/vesta/web/install/wordpress
cd /usr/local/vesta/web/install/wordpress
curl -O https://raw.githubusercontent.com/maskoid/vestacp-wordpress-installer/master/web/install/wordpress/index.php

# Chmod files 
chmod 755 /usr/local/vesta/web/list/wp  
chmod 644 /usr/local/vesta/web/list/wp/index.php
chmod 644 /usr/local/vesta/web/list/wp/api.php

# Add to Navigation

# Add the link to the panel.html file 
if grep -q 'WP' /usr/local/vesta/web/templates/admin/panel.html; then
		echo 'Already there.'
	else 
sed -i '/<div class="l-menu clearfix noselect">/a <div class="l-menu__item <?php if($TAB == "WP" ) echo "l-menu__item--active"; ?>"><a href="/list/wp/" target="_blank"><?=__("WP Install")?></a></div>' /usr/local/vesta/web/templates/admin/panel.html;
fi
echo "Done! Check VestaCP!" 


# Success

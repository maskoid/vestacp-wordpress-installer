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


# Add to Navigation

# Success

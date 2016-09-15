

```
# remove y purge de apache2 y php
sudo apt-get remove apache2 php*
sudo apt-get purge apache2 php*

# add ppa's
sudo apt-get install -y language-pack-en-base
sudo LC_ALL=en_US.UTF-8 add-apt-repository -y ppa:ondrej/php
sudo LC_ALL=en_US.UTF-8 add-apt-repository -y ppa:ondrej/apache2
sudo apt-get update

# install custom php7.0 and apache2
sudo apt-get install -y php7.0
sudo apt-get install apache2

# install php basics
sudo apt-get install libapache2-mod-php7.0 php7.0-mysql php7.0-curl php7.0-json



# prepare workspace
DOCROOT="~/workspaces/apache2"
mkdir -p $DOCROOT

# modify doc root
sudo gedit /etc/apache2/apache2.conf 
	
	# add/modify this entries
	<Directory />
		Options FollowSymLinks
		AllowOverride All
		Require all granted
	</Directory>

	<Directory /home/<user>/workspaces/apache2/>
		Options FollowSymLinks
		AllowOverride All
		Require all granted
	</Directory>

sudo gedit /etc/apache2/sites-available/000-default.conf 
	
	# modify the DOC ROOT
	DocumentRoot /home/<user>/workspaces/apache2

sudo service apache2 restart


# test
echo '<?php phpinfo(); ?>' > "$DOCROOT"/info.php


## phppgadmin
# install
sudo apt-get install postgresql postgresql-contrib
sudo apt-get install phppgadmin

# setup
sudo -u postgres psql
alter user postgres password 'apassword';
create user yerusername createdb createuser password 
'somepass';
create database yerusername owner yerusername;


# si aparece un error de apache, usar:
sudo a2dismod php5
sudo a2dismod php7.0
sudo a2enmod php7.0
sudo service apache2 restart

# add to /etc/apache2/apache2.conf 
	Include /etc/apache2/conf.d/phppgadmin
sudo service apache2 restart

```




```
## CakePHP requirements
sudo a2enmod rewrite
sudo apt-get install -y php7.0-mbstring php7.0-intl php7.0-pgsql php7.0-mcrypt 
sudo service apache2 restart

## composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer

# obtener app
git clone https://github.com/mpavezb/conectados-al-sur.git cas-app

# setup db:
'Datasources' => [
        'default' => [
			'driver' => 'Cake\Database\Driver\Postgres',
			'port' => 5432,
			'username' => '...',
            'password' => '...',
            'database' => '...',
```

```
## Base de datos

# setup
crear base de datos: dvinecl_cake
crear usuario: dvinecl_baker
dar permisos a dvinecl_baker

``


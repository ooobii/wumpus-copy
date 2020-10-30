#depends on pandoc curl dpkg php7.3 php7.3-cli php7.3-mbstring php7.3-json php7.3-xml 

all: package
clean: remove_files

package: clean create_struct copy_files composer_install create_control create_deb
install: clean package install_deb
test: package install uninstall clean


VER_MAJOR=1
VER_MINOR=0
VER_REVIS=1

PROJ_DIR=./../

PKG_NAME=wumpuscopy_$(VER_MAJOR).$(VER_MINOR)-$(VER_REVIS)
PKG_BUILD_DIR=./build
PKG_DIR=$(PKG_BUILD_DIR)/$(PKG_NAME)

LIB_DIR=/usr/share/wumpus-copy
ETC_DIR=/etc/wumpus-copy
BIN_DIR=/usr/local/bin
MAN_DIR=/usr/share/man/man1


create_struct:
	# create build directory...
	mkdir $(PKG_BUILD_DIR)
	# create package directory...
	mkdir $(PKG_DIR)

	# create debian package metadata structure...
	mkdir $(PKG_DIR)/DEBIAN
	touch $(PKG_DIR)/DEBIAN/control
	
	# create pkg lib folder...
	mkdir -p $(PKG_DIR)$(LIB_DIR)
	mkdir $(PKG_DIR)$(LIB_DIR)/composer

	# create pkg etc folder...
	mkdir -p $(PKG_DIR)$(ETC_DIR)

	# create pkg bin folder...
	mkdir -p $(PKG_DIR)$(BIN_DIR)

	# create pkg man folder...
	mkdir -p $(PKG_DIR)$(MAN_DIR)



copy_files:
	# generate manpage from README...
	pandoc -s --metadata title=wumpuscopy\(1\) -t man $(PROJ_DIR)/man/wumpuscopy.1.md -o $(PKG_DIR)$(MAN_DIR)/wumpuscopy.1 

	# copy libraries...
	mkdir $(PKG_DIR)$(LIB_DIR)/lib
	cp $(PROJ_DIR)/lib/*.php $(PKG_DIR)$(LIB_DIR)/lib

	# copy main...
	cp $(PROJ_DIR)/wumpus-copy.php $(PKG_DIR)$(LIB_DIR)
	chmod a+x $(PKG_DIR)$(LIB_DIR)/wumpus-copy.php

	# copy template config...
	cp $(PROJ_DIR)/configexample.json $(PKG_DIR)$(ETC_DIR)/config.json

	# create symlink to main...
	ln -s $(shell readlink -f $(LIB_DIR))/wumpus-copy.php $(shell readlink -f $(PKG_DIR)/$(BIN_DIR))/wumpuscopy



composer_install:
	# download composer installation script...
	curl -sS https://getcomposer.org/installer -o composer-setup.php

	# install composer to package...
	php composer-setup.php --install-dir=$(PKG_DIR)/$(LIB_DIR)/composer --filename=composer

	# remove composer installation script...
	rm -rf composer-setup.php

	# copy composer metadata...
	\cp $(PROJ_DIR)/composer.json $(PKG_DIR)$(LIB_DIR)/composer.json
	\cp $(PROJ_DIR)/composer.lock $(PKG_DIR)$(LIB_DIR)/composer.lock

	# run composer installation...
	$(PKG_DIR)$(LIB_DIR)/composer/composer install --no-cache --no-dev -d $(PKG_DIR)$(LIB_DIR)

	# remove composer...
	rm -rf $(PKG_DIR)$(LIB_DIR)/composer

	# remove composer metadata...
	rm -rf $(PKG_DIR)$(LIB_DIR)/composer.json
	rm -rf $(PKG_DIR)$(LIB_DIR)/composer.lock



create_control:
	# write debian package control file...
	@/bin/echo -e \
Package: wumpuscopy \\n\
Version: $(VER_MAJOR).$(VER_MINOR)-$(VER_REVIS) \\n\
Section: base \\n\
Priority: optional \\n\
Architecture: amd64 \\n\
Depends: php7.3, php7.3-cli, php7.3-json, php7.3-mbstring, git, unzip \\n\
Maintainer: Matthew Wendel \<matthewwendel77\@gmail.com\> \\n\
Description: A Discord bot that allows messages to be coppied from an individual's available channels to a bot's available channels. \
>> $(PKG_DIR)/DEBIAN/control


create_deb:
	# create debian package file...
	dpkg -b $(PKG_DIR) $(PKG_BUILD_DIR)/$(PKG_NAME).deb


install_deb:
	# installing debian package...
	sudo dpkg -i $(PKG_BUILD_DIR)/$(PKG_NAME).deb
	

uninstall:
	# removing debian package...
	sudo apt remove --purge -y wumpuscopy



remove_files:
	# cleaning build directory
	@rm -rf $(PKG_BUILD_DIR)

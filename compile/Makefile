all: package
clean: remove_files

package: clean create_struct copy_files composer_install create_control create_deb
install: clean package install_deb
test: package install uninstall clean


VER_MAJOR=1
VER_MINOR=0
VER_REVIS=1

PROJ_DIR=./../../wumpus-copy

PKG_NAME=wumpuscopy_$(VER_MAJOR).$(VER_MINOR)-$(VER_REVIS)
PKG_BUILD_DIR=./../build
PKG_DIR=$(PKG_BUILD_DIR)/$(PKG_NAME)

LIB_DIR=$(PKG_DIR)/usr/share/wumpus-copy
ETC_DIR=$(PKG_DIR)/etc/wumpus-copy
BIN_DIR=$(PKG_DIR)/usr/local/bin


create_struct:
	# create build directory...
	mkdir $(PKG_BUILD_DIR)
	# create package directory...
	mkdir $(PKG_DIR)

	# create debian package metadata folder structure...
	mkdir $(PKG_DIR)/DEBIAN
	touch $(PKG_DIR)/DEBIAN/control
	
	# create file install location structure...
	mkdir -p $(LIB_DIR)
	mkdir -p $(ETC_DIR)
	mkdir -p $(BIN_DIR)



copy_files:
	# copy libraries...
	mkdir $(LIB_DIR)/lib
	cp $(PROJ_DIR)/lib/*.php $(LIB_DIR)/lib

	# copy main...
	cp $(PROJ_DIR)/wumpus-copy.php $(LIB_DIR)
	chmod a+x $(LIB_DIR)/wumpus-copy.php

	# copy template config...
	cp $(PROJ_DIR)/configexample.json $(ETC_DIR)/config.json

	# create symlink to main...
	ln -s $(shell readlink -f $(LIB_DIR))/wumpus-copy.php $(shell readlink -f $(BIN_DIR))/wumpuscopy



composer_install:
	# copy composer metadata...
	\cp $(PROJ_DIR)/composer.json $(LIB_DIR)/composer.json
	\cp $(PROJ_DIR)/composer.lock $(LIB_DIR)/composer.lock

	# run composer installation...
	composer install --no-dev -d $(LIB_DIR)



create_control:
	# write debian package control file...
	@/bin/echo -e \
Package: wumpuscopy \\n\
Version: $(VER_MAJOR).$(VER_MINOR)-$(VER_REVIS) \\n\
Section: base \\n\
Priority: optional \\n\
Architecture: amd64 \\n\
Depends: php7.3, php7.3-cli, php7.3-json \\n\
Maintainer: Matthew Wendel \<matthewwendel77\@gmail.com\> \\n\
Description: A Discord bot that allows messages to be coppied from an individual's available channels to a bot's available channels. >> $(PKG_DIR)/DEBIAN/control


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

#depends on pandoc curl dpkg php7.3 php7.3-cli php7.3-mbstring php7.3-json php7.3-xml 
SHELL = bash


all: package
structure_debian: create_control create_changelog create_postinst create_prerm create_postrm create_compat 

configure: clean clean create_struct copy_files composer_prep composer_install 
configure_dev:  clean clean create_struct copy_files composer_prep composer_install_dev

package: configure composer_uninstall structure_debian create_deb clean_deb_datastruct
install: package install_deb


VER_MAJOR=1
VER_MINOR=0
VER_REVIS=2

PROJ_DIR=./../../
PKG_NAME=wumpuscopy_$(VER_MAJOR).$(VER_MINOR)-$(VER_REVIS)
PKG_BUILD_DIR=./../../build
PKG_DIR=$(PKG_BUILD_DIR)/$(PKG_NAME)

LIB_DIR=/usr/share/wumpus-copy
ETC_DIR=/etc/wumpus-copy
BIN_DIR=/usr/local/bin
MAN_DIR=/usr/share/man/man1
SVC_DIR=/etc/systemd/system


define CONTROL_BODY
Source:  wumpuscopy
Package: wumpuscopy
Version: $(VER_MAJOR).$(VER_MINOR)-$(VER_REVIS)
Section: base
Priority: optional
Architecture: amd64
Depends: php7.3, php7.3-cli, php7.3-json, php7.3-mbstring, git, zip, unzip
Maintainer: Matthew Wendel \<matthewwendel77\@gmail.com\>
Description: A Discord bot that allows messages to be copied from an individual's available channels to a bot's available channels.
endef
export CONTROL_BODY


define CHANGELOG_BODY
wumpus-copy ($(VER_MAJOR).$(VER_MINOR)-$(VER_REVIS)) stretch; urgency=medium

 * Added a service

 -- Matthew Wendel <matthewwendel77@gmail.com>  Sat, 08 Nov 2020 13:59:26 +0000

wumpus-copy (1.0-1) stretch; urgency=medium

 * Converted packaging to new debian package guidelines.

 -- Matthew Wendel <matthewwendel77@gmail.com>  Sat, 08 Nov 2020 13:59:26 +0000
endef
export CHANGELOG_BODY


define POSTINST_BODY
{
	# SYMLINK ============
	# create symlink in bin folder
	sudo ln -s $(LIB_DIR)/wumpus-copy.php $(BIN_DIR)/wumpuscopy

	# SERVICE ============
	# write service file
	cat <<'EOSERVICE' | sudo tee $(SVC_DIR)/wumpuscopy.service
	[Unit]
	Description=WumpusCopy Discord Bot
	After=network.target
	StartLimitIntervalSec=0

	[Service]
	Type=simple
	Restart=on-failure
	RestartSec=2
	User=~username~
	ExecStart=$(BIN_DIR)/wumpuscopy

	[Install]
	WantedBy=multi-user.target
	EOSERVICE

	# reload daemon
	sudo systemctl daemon-reload
} &> /dev/null

endef
export POSTINST_BODY

define PRERM_BODY

endef
export PRERM_BODY

define POSTRM_BODY

endef
export POSTRM_BODY


create_struct:
	# create build directory...
	mkdir $(PKG_BUILD_DIR)
	# create package directory...
	mkdir $(PKG_DIR)

	# create debian package metadata structure...
	mkdir $(PKG_DIR)/DEBIAN
	touch $(PKG_DIR)/DEBIAN/control
	touch $(PKG_DIR)/DEBIAN/changelog
	touch $(PKG_DIR)/DEBIAN/compat
	touch $(PKG_DIR)/DEBIAN/postinst
	touch $(PKG_DIR)/DEBIAN/prerm
	touch $(PKG_DIR)/DEBIAN/postrm
	
	# create pkg lib folder...
	mkdir -p $(PKG_DIR)$(LIB_DIR)
	mkdir $(PKG_DIR)$(LIB_DIR)/composer

	# create pkg etc folder...
	mkdir -p $(PKG_DIR)$(ETC_DIR)

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



composer_prep:
	# download composer installation script...
	curl -sS https://getcomposer.org/installer -o $(PKG_BUILD_DIR)/composer-setup.php

	# install composer to package...
	php $(PKG_BUILD_DIR)/composer-setup.php --install-dir=$(PKG_DIR)/$(LIB_DIR)/composer --filename=composer

	# remove composer installation script...
	rm -rf $(PKG_BUILD_DIR)/composer-setup.php

	# copy composer metadata...
	\cp $(PROJ_DIR)/composer.json $(PKG_DIR)$(LIB_DIR)/composer.json
	\cp $(PROJ_DIR)/composer.lock $(PKG_DIR)$(LIB_DIR)/composer.lock


composer_install:
	# run composer installation...
	$(PKG_DIR)$(LIB_DIR)/composer/composer install --no-dev -d $(PKG_DIR)$(LIB_DIR)

composer_install_dev:
	# run composer installation with development packages...
	$(PKG_DIR)$(LIB_DIR)/composer/composer install --no-cache -d $(PKG_DIR)$(LIB_DIR)


composer_uninstall:
	# remove composer...
	rm -rf $(PKG_DIR)$(LIB_DIR)/composer

	# remove composer metadata...
	rm -rf $(PKG_DIR)$(LIB_DIR)/composer.json
	rm -rf $(PKG_DIR)$(LIB_DIR)/composer.lock



create_control:
	# write debian package control file...
	@echo "$$CONTROL_BODY" >> $(PKG_DIR)/DEBIAN/control

create_changelog:
	# write debian changelog file...
	@echo "$$CHANGELOG_BODY" >> $(PKG_DIR)/DEBIAN/changelog

create_postinst:
	# write debian post installation script...
	@echo "$$POSTINST_BODY" >> $(PKG_DIR)/DEBIAN/postinst
	@chmod 0775 $(PKG_DIR)/DEBIAN/postinst

create_prerm:
	# write debian pre-removal script...
	@echo "$$PRERM_BODY" >> $(PKG_DIR)/DEBIAN/prerm
	@chmod 0775 $(PKG_DIR)/DEBIAN/prerm

create_postrm:
	# write debian post-removal script...
	@echo "$$POSTRM_BODY" >> $(PKG_DIR)/DEBIAN/postrm
	@chmod 0775 $(PKG_DIR)/DEBIAN/postrm

create_compat:
	echo 9 > $(PKG_DIR)/DEBIAN/compat



create_deb:
	# create debian package file...
	echo $(PWD)
	env DH_VERBOSE=1 dpkg -b $(PKG_DIR) $(PKG_BUILD_DIR)/$(PKG_NAME).deb


clean_deb_datastruct:
	# removing references to important directories from internal package tarball...
	mkdir $(PKG_BUILD_DIR)/data-tarball

	ar x $(PKG_BUILD_DIR)/$(PKG_NAME).deb data.tar.xz --output $(PKG_BUILD_DIR)/data-tarball
	/usr/bin/unxz $(PKG_BUILD_DIR)/data-tarball/data.tar.xz
	rm -rf $(PKG_BUILD_DIR)/data-tarball/data.tar.xz

	tar --delete --occurrence -f $(PKG_BUILD_DIR)/data-tarball/data.tar ./etc/
	tar --delete --occurrence -f $(PKG_BUILD_DIR)/data-tarball/data.tar ./usr/
	tar --delete --occurrence -f $(PKG_BUILD_DIR)/data-tarball/data.tar ./usr/share/
	tar --delete --occurrence -f $(PKG_BUILD_DIR)/data-tarball/data.tar ./usr/share/man/
	tar --delete --occurrence -f $(PKG_BUILD_DIR)/data-tarball/data.tar ./usr/share/man/man1/

	/usr/bin/xz $(PKG_BUILD_DIR)/data-tarball/data.tar
	ar r $(PKG_BUILD_DIR)/$(PKG_NAME).deb $(PKG_BUILD_DIR)/data-tarball/data.tar.xz

	rm -rf $(PKG_BUILD_DIR)/data-tarball


install_deb:
	sudo dpkg -i $(PKG_BUILD_DIR)/$(PKG_NAME).deb


clean:
	# cleaning build directory
	@rm -rf $(PKG_BUILD_DIR)

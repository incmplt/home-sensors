# Makefile : Home Sensors on RaspberryPi
PREFIX=/opt/iot/

prepare:
	apt install python3
	apt install i2c-tools
	pip3 install mh-z19

install:
	-mkdir -p ${PREFIX}/bin
	-cp -a ./bin/* ${PREFIX}/bin/
	chmod 0755 ${PREFIX}/bin/*.pl
	chmod 0755 ${PREFIX}/bin/*.py
	chmod 0755 ${PREFIX}/bin/*.sh


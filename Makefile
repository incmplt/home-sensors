# Makefile : Home Sensors on RaspberryPi
PREFIX=/opt/iot/

install:
	-mkdir -p ${PREFIX}/bin
	-cp -a ./bin/* ${PREFIX}/bin/
	chmod 0755 ${PREFIX}/bin/*.pl
	chmod 0755 ${PREFIX}/bin/*.py
	chmod 0755 ${PREFIX}/bin/*.sh


#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Author: incmplt@gmail.com
#import commands # for Python2
import subprocess # fo Python3

if __name__ == "__main__":
    # for Python2
    #Temp = commands.getoutput("cat /sys/bus/iio/devices/iio:device0/in_temp_input")
    #RH = commands.getoutput("cat /sys/bus/iio/devices/iio:device0/in_humidityrelative_input")
    #Pre = commands.getoutput("cat /sys/bus/iio/devices/iio:device0/in_pressure_input")
    # for Python3
    Temp = subprocess.getoutput("cat /sys/bus/iio/devices/iio:device0/in_temp_input")
    RH = subprocess.getoutput("cat /sys/bus/iio/devices/iio:device0/in_humidityrelative_input")
    Pre = subprocess.getoutput("cat /sys/bus/iio/devices/iio:device0/in_pressure_input")
    print( str(round((int(Temp)/1000.0),2)) +","+ str(round((float(RH)/1000.0),2)) +","+ str(round((float(Pre)*10),1)) )

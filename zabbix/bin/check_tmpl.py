#!/usr/bin/env python3
import subprocess # fo Python3

SENSOR_POS = 0

if __name__ == "__main__":
    tmpl = subprocess.getoutput("cat /sys/bus/iio/devices/iio:device0/in_temp_input")
    t1 = round((int(tmpl)/1000.0),2)

    print( t1 )
    
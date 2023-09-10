#!/usr/bin/env python3
import subprocess # fo Python3

SENSOR_POS = 0

if __name__ == "__main__":
    rh = subprocess.getoutput("cat /sys/bus/iio/devices/iio:device0/in_humidityrelative_input")
    r1 = round((float(rh)/1000.0),2)

    print( r1 )

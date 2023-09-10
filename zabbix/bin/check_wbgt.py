#!/usr/bin/env python3
import subprocess # fo Python3

SENSOR_POS = 0

if __name__ == "__main__":
    tmpl = subprocess.getoutput("cat /sys/bus/iio/devices/iio:device0/in_temp_input")
    rh = subprocess.getoutput("cat /sys/bus/iio/devices/iio:device0/in_humidityrelative_input")
    t1 = round((int(tmpl)/1000.0),2)
    r1 = round((float(rh)/1000.0),2)

    # Heat index : Wet Bulb Globe Temperature (WBGT)
    wbgt=0.0
    if SENSOR_POS == 0:
        # indoor sensor 
        wbgt = round( float( t1 *0.725 + r1 *0.0368 + 0.00364* t1 * r1 - 3.246 ), 2 )
    else:
        # outdoors sensor
        wbgt = round( float( t1 *0.735 + r1 *0.0374 + 0.00292* t1 * r1 - 4.064 ), 2 )

    print( wbgt )
    

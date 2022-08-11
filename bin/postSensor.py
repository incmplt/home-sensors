#!/usr/bin/python3
# -*- coding: utf-8 -*-
#import commands
import time
import mh_z19
import datetime
import subprocess
import config
import requests

def getaddr():
  addr = subprocess.getoutput("/opt/iot/bin/getmac.sh")
  return addr

def postmsg( mac, tmpl, rh, pre, co2, wbgt ):
  print( "Post sensor vlues")
  posthost = config.SENSOR_PROTOCOL +'://'+ config.SENSOR_SERVER + config.SENSOR_ENDPOINT
  postbody = { 'mac': mac, 'tmpl': tmpl, 'rh': rh, 'pre': pre, 'co2': co2, 'wbgt': wbgt }
  response = requests.post( posthost, data=postbody )

def sensmgmt( tmpl, rh, pre, co2 ):
  now = datetime.datetime.today()
  nowstr = now.strftime("%Y/%m/%d %H:%M:%S")
  t1 = round((int(tmpl)/1000.0),2)
  r1 = round((float(rh)/1000.0),2)
  p1 = round((float(pre)*10),1)

  # Heat index : Wet Bulb Globe Temperature (WBGT)
  wbgt=0.0
  if config.SENSOR_POS == 0:
    # indoor sensor 
    wbgt = round( float( t1 *0.725 + r1 *0.0368 + 0.00364* t1 * r1 - 3.246 ), 2 )
  else:
    # outdoors sensor
    wbgt = round( float( t1 *0.735 + r1 *0.0374 + 0.00292* t1 * r1 - 4.064 ), 2 )

  logline = nowstr +","+ str( t1 ) +","+ str( r1 ) +","+ str( p1 ) +","+ str( float(co2) ) +","+ str( wbgt )
  print(logline) 
  mac = getaddr()
  postmsg( mac, t1, r1, p1, co2, wbgt )

if __name__ == "__main__":
  Tmpl = subprocess.getoutput("cat /sys/bus/iio/devices/iio:device0/in_temp_input")
  RH = subprocess.getoutput("cat /sys/bus/iio/devices/iio:device0/in_humidityrelative_input")
  Pre = subprocess.getoutput("cat /sys/bus/iio/devices/iio:device0/in_pressure_input")
  Co2 = mh_z19.read_all()["co2"]

  #print( str(round((int(Temp)/1000.0),2)) +","+ str(round((float(RH)/1000.0),2)) +","+ str(round((float(Pre)*10),1)) +","+ str( float(Co2) ) )
  sensmgmt( Tmpl, RH, Pre, Co2 )

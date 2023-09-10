#!/usr/bin/python3
# -*- coding: utf-8 -*-
#import commands
import time
import mh_z19
import datetime
import subprocess



if __name__ == "__main__":
    Co2 = mh_z19.read_all()["co2"]
    print( Co2 )
    
#!/usr/bin/env python
# vim: et : ts=4 : set fileencoding=utf-8 :
#probably needs to use virtualenv Python2.7, probably in /opt/venv/bin/

import pandas as pd
import numpy as np
from numpy import exp, abs, angle
import arrow
import sqlite3

import sys

if len(sys.argv) >1:
    #date specified
    start_obj = arrow.get(sys.argv[1],'YYYY-MM-DD').replace(hour=18,minute=0,second=0)
else:
    #default to start yesterday
    start_obj = arrow.now().replace(days=-1,hour=18,minute=0,second=0)


def FtoC(Ftemp):
    '''converts absolute temp in °F to °C'''
    return (5.0/9.0)*(Ftemp-32)

def polar2z(rho,phideg):
    phi = np.deg2rad(phideg)
    x = rho * np.cos(phi)
    y = rho * np.sin(phi)
    return(x, y)

def z2polar(x, y):
    rho = np.sqrt(x**2 + y**2)
    phi = np.arctan2(y, x)
    return(rho, np.rad2deg(phi))

sqlfile = "/data/davis/sql/weewx.sdb"

conn = sqlite3.connect(sqlfile)

end_obj = start_obj.replace(hours=+24)

start = start_obj.timestamp
end = end_obj.timestamp
noon = end_obj.replace(hour=12)

df = pd.read_sql_query("SELECT * FROM archive WHERE dateTime > %d AND dateTime <= %d" % (start, end), conn, index_col='dateTime', parse_dates={'dateTime':'s'})

#convert to components
(df['u'], df['v']) = polar2z(df.windSpeed, df.windDir)

noonperiod = df[noon.replace(minutes=-7, seconds=-30).strftime('%Y-%m-%d %H:%m:%S'):noon.replace(minutes=+7, seconds=+30).strftime('%Y-%m-%d %H:%m:%S')]

rho, phi = z2polar(noonperiod.u.mean(), noonperiod.v.mean())

print "INSERT INTO forecasts (day, group_id, min_temp, max_temp, total_rainfall, wind_direction, wind_speed) VALUES (%s, 10, %.1f, %.1f, %.1f, %d, %d) " % (start_obj.strftime('"%Y-%m-%d"'), round(FtoC(df.outTemp.min()) *2.0)/2.0, round(FtoC(df.outTemp.max())*2.0)/2.0, round(df.rain.sum()*25.4*2.0)/2.0, phi, rho)


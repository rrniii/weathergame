#!/usr/bin/env python
# vim: et : ts=4 : set fileencoding=utf-8 :
#probably needs to use virtualenv Python2.7, probably in /opt/venv/bin/

import pandas as pd
import numpy as np
from numpy import exp, abs, angle
import arrow
import pymysql

import sys

if len(sys.argv) >1:
    #date specified
    start_obj = arrow.get(sys.argv[1],'YYYY-MM-DD').replace(hour=18,minute=0,second=0)
else:
    #default to start yesterday
    start_obj = arrow.now().shift(days=-1).replace(hour=18,minute=0,second=0)


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


sqluser="harrogate"
sqlpass="scruples65"
sqldb="harrogatewx"

#sqlfile = "/home/lecjlg/harrogate-wx-station/sourcefile/weewx.sdb"

#conn = sqlite3.connect(sqlfile)
conn = pymysql.connect(
        host="localhost",
        user=sqluser,
        password=sqlpass,
        database=sqldb
    )

with conn:

    end_obj = start_obj.shift(hours=+24)

    start = start_obj.timestamp
    end = end_obj.timestamp
    noon = end_obj.replace(hour=12)

    df = pd.read_sql_query("SELECT * FROM archive WHERE dateTime > %d AND dateTime <= %d" % (start, end), conn, index_col='dateTime', parse_dates={'dateTime':'s'})

    #convert to components
    (df['u'], df['v']) = polar2z(df.windSpeed, df.windDir)

    noonperiod = df[noon.shift(minutes=-7, seconds=-30).strftime('%Y-%m-%d %H:%m:%S'):noon.shift(minutes=+7, seconds=+30).strftime('%Y-%m-%d %H:%m:%S')]

    rho, phi = z2polar(noonperiod.u.mean()*0.2778, noonperiod.v.mean()*0.2778)

    gameconn = pymysql.connect(
        host="localhost",
        user="measure",
        password="4measure",
        database="measurements"
    )

    with gameconn:
        sql = "INSERT INTO forecasts (day, group_id, min_temp, max_temp, total_rainfall, wind_direction, wind_speed) VALUES (%s, 10, %s, %s, %s, %s, %s) " 
        data = (start_obj.strftime('%Y-%m-%d'), round(df.outTemp.min() *2.0)/2.0, round(df.outTemp.max()*2.0)/2.0, round(df.rain.sum()*10.0*2.0)/2.0, phi, rho)
        print(data)
        with gameconn.cursor() as cursor:
            cursor.execute(sql, data)
            gameconn.commit()


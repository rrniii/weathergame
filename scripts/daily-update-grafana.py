#!/usr/bin/env python
# vim: et : ts=4 : set fileencoding=utf-8 :
#probably needs to use virtualenv Python2.7, probably in /opt/venv/bin/

import pandas as pd
import numpy as np
from numpy import exp, abs, angle
import arrow
import pymysql
import requests

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

end_obj = start_obj.shift(hours=+24)

start = start_obj.timestamp
end = end_obj.timestamp
noon = end_obj.replace(hour=12)

dataurl = "http://192.171.139.98:3000/api/tsdb/query"
dataheaders = {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer eyJrIjoiNUpuYWtGbEozdkFpYTZEaFlHdDJvYUJKYXpoV1NCcWIiLCJuIjoid2VhdGhlcmdhbWUiLCJpZCI6MX0='
              }
datapayload = '{"from":"%s","to":"%s","queries":[{"refId":"A","intervalMs":60000,"maxDataPoints":1031,"datasourceId":2,"rawSql":"select from_unixtime(dateTime), outHumidity, outTemp, rain, rainRate, windDir,windSpeed, windGustDir, windGust FROM archive  WHERE $__unixEpochFilter(dateTime) ORDER BY dateTime;","format":"table"}]}' % (start*1000, end*1000)

with requests.post(dataurl, headers=dataheaders, data=datapayload) as conn: 

    #df = pd.read_sql_query("SELECT * FROM archive WHERE dateTime > %d AND dateTime <= %d" % (start, end), conn, index_col='dateTime', parse_dates={'dateTime':'s'})
    data = conn.json()
    columns = []
    for each in data['results']['A']['tables'][0]['columns']:
      columns.append(each['text'])
    df = pd.DataFrame(data['results']['A']['tables'][0]['rows'], columns=columns)
    df['from_unixtime(dateTime)'].replace(to_replace="Z",value="UTC",inplace=True,regex=True)
    df['dateTime'] = pd.to_datetime(df['from_unixtime(dateTime)'], format="%Y-%m-%dT%H:%M:%S%Z")
    df.pop('from_unixtime(dateTime)')
    df.set_index('dateTime', inplace=True)

    #convert to components
    (df['u'], df['v']) = polar2z(df.windSpeed, df.windDir)

    noonperiod = df[noon.shift(minutes=-7, seconds=-30).strftime('%Y-%m-%d %H:%m:%S'):noon.shift(minutes=+7, seconds=+30).strftime('%Y-%m-%d %H:%m:%S')]

    rho, phi = z2polar(noonperiod.u.mean(), noonperiod.v.mean())

    gameconn = pymysql.connect(
        host="localhost",
        user="measure",
        password="4measure",
        database="measurements"
    )

    with gameconn:
        #print "INSERT INTO forecasts (day, group_id, min_temp, max_temp, total_rainfall, wind_direction, wind_speed) VALUES (%s, 10, %.1f, %.1f, %.1f, %d, %d) " % (start_obj.strftime('"%Y-%m-%d"'), round(FtoC(df.outTemp.min()) *2.0)/2.0, round(FtoC(df.outTemp.max())*2.0)/2.0, round(df.rain.sum()*25.4*2.0)/2.0, phi, rho)
        sql = "INSERT INTO forecasts (day, group_id, min_temp, max_temp, total_rainfall, wind_direction, wind_speed) VALUES (%s, 10, %s, %s, %s, %s, %s) " 
        data = (start_obj.strftime('%Y-%m-%d'), round(FtoC(df.outTemp.min()) *2.0)/2.0, round(FtoC(df.outTemp.max())*2.0)/2.0, round(df.rain.sum()*25.4*2.0)/2.0, phi, rho)
        print(sql, data)
        with gameconn.cursor() as cursor:
            cursor.execute(sql, data)
            gameconn.commit()


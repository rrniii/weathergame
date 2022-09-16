#!/usr/bin/env python
# vim: et : ts=4 : set fileencoding=utf-8 :
#probably needs to use virtualenv Python2.7, probably in /opt/venv/bin/
#Using python 3.8 from miniconda; RN 2021-03-04

import pandas as pd
from pandas import DataFrame
import numpy as np
from numpy import exp, abs, angle
import arrow
import pymysql
import requests

import sys

### Test Data
test=False


if len(sys.argv) >1:
    #date specified
    start_obj = arrow.get(sys.argv[1],'YYYY-MM-DD').replace(hour=17,minute=30,second=0)
    verf_obj = arrow.get(sys.argv[1],'YYYY-MM-DD').shift(days=-1).replace(hour=17,minute=30,second=0)
    day_before_obj = arrow.get(sys.argv[1],'YYYY-MM-DD').shift(days=-2).replace(hour=17,minute=30,second=0)

else:
    #default to start yesterday
    start_obj = arrow.now().shift(days=-1).replace(hour=17,minute=30,second=0)
    verf_obj = arrow.now().shift(days=-2).replace(hour=17,minute=30,second=0)
    day_before_obj = arrow.now().shift(days=-3).replace(hour=17,minute=30,second=0)

def FtoC(Ftemp):
    '''converts absolute temp in °F to °C'''
    return (5.0/9.0)*(Ftemp-32)

def polar2z(rho,phideg):
    if phideg==None:
        x = 0.0
        y = 0.0
    else:
        phi = np.deg2rad(phideg)
        x = rho * np.cos(phi)
        y = rho * np.sin(phi)
    return(x, y)

def z2polar(x, y):
    rho = np.sqrt(x**2 + y**2)
    phi = np.arctan2(y, x)
    return(rho, np.rad2deg(phi))

end_obj = start_obj.shift(hours=+24)
day_before_end_obj = day_before_obj.shift(hours=+24)

#########  Get Verf Data
start = start_obj.timestamp()
end = end_obj.timestamp()
noon = end_obj.shift(hours=-5, minutes=-30)


#Change Data Source Depending on what you want to set up as Verification

dataurl = "http://192.171.139.98:3000/api/ds/query"
dataheaders = {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer eyJrIjoiQUJHU3lXTnVHSGZ3eWJmcG1WZjZIaUo0MTcwWWJFTWYiLCJuIjoiMjAyMndlYXRoZXJnYW1lIiwiaWQiOjF9'
              }
datapayload = '{"from":"%i","to":"%i","queries":[{"refId":"A","intervalMs":60000,"maxDataPoints":1031,"datasourceId":8,"rawSql":"select from_unixtime(dateTime), outHumidity, outTemp, rain, rainRate, windDir,windSpeed, windGustDir, windGust FROM archive  WHERE $__unixEpochFilter(dateTime) ORDER BY dateTime;","format":"table"}]}' % (start*1000, end*1000)
with requests.post(dataurl, headers=dataheaders, data=datapayload) as conn:
    data = conn.json()
    columns = []
    for each in data['results']['A']['frames'][0]['schema']['fields']:
        columns.append(each['name'])
    df = pd.DataFrame(np.transpose(data['results']['A']['frames'][0]['data']['values'][0:9]), columns=columns)
    #df['from_unixtime(dateTime)'].replace(to_replace="Z",value="UTC",inplace=True,regex=True)
    df['dateTime'] = pd.to_datetime(df['from_unixtime(dateTime)'], unit='ms')
    df.pop('from_unixtime(dateTime)')
    df.set_index('dateTime', inplace=True)

    #convert to components
    for ind in df.index:
        (df['u'], df['v']) = polar2z(df.windSpeed[ind], df.windDir[ind])

    noonperiod = df[noon.shift(minutes=-7, seconds=-30).strftime('%Y-%m-%d %H:%M:%S'):noon.shift(minutes=+7, seconds=+30).strftime('%Y-%m-%d %H:%M:%S')]
    print('verf noon period is',noonperiod)
    rho, phi = z2polar(noonperiod.u.mean(), noonperiod.v.mean())
######

#########  Get Percy Date
day_before_start = day_before_obj.timestamp()
day_before_end = day_before_end_obj.timestamp()
day_before_noon = day_before_end_obj.shift(hours=-5, minutes=-30)

#Change Data Source Depending on what you want to set up as Verification

dataurl = "http://192.171.139.98:3000/api/ds/query"
dataheaders = {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer eyJrIjoiQUJHU3lXTnVHSGZ3eWJmcG1WZjZIaUo0MTcwWWJFTWYiLCJuIjoiMjAyMndlYXRoZXJnYW1lIiwiaWQiOjF9'
              }
day_before_datapayload = '{"from":"%i","to":"%i","queries":[{"refId":"A","intervalMs":60000,"maxDataPoints":1031,"datasourceId":8,"rawSql":"select from_unixtime(dateTime), outHumidity, outTemp, rain, rainRate, windDir,windSpeed, windGustDir, windGust FROM archive  WHERE $__unixEpochFilter(dateTime) ORDER BY dateTime;","format":"table"}]}' % (day_before_start*1000, day_before_end*1000)

with requests.post(dataurl, headers=dataheaders, data=day_before_datapayload) as day_before_conn:
    day_before_data = day_before_conn.json()
    day_before_columns = []
    for each in day_before_data['results']['A']['frames'][0]['schema']['fields']:
        day_before_columns.append(each['name'])
    day_before_df = pd.DataFrame(np.transpose(day_before_data['results']['A']['frames'][0]['data']['values'][0:9]), columns=day_before_columns)
    day_before_df['dateTime'] = pd.to_datetime(day_before_df['from_unixtime(dateTime)'], unit='ms')
    day_before_df.pop('from_unixtime(dateTime)')
    day_before_df.set_index('dateTime', inplace=True)

    #convert to components
    for ind in day_before_df.index:
        (day_before_df['u'], day_before_df['v']) = polar2z(day_before_df.windSpeed[ind], day_before_df.windDir[ind])

    day_before_noonperiod = day_before_df[day_before_noon.shift(minutes=-7, seconds=-30).strftime('%Y-%m-%d %H:%M:%S'):day_before_noon.shift(minutes=+7, seconds=+30).strftime('%Y-%m-%d %H:%m:%S')]
    print('day_before_noon period is',day_before_noon)
    day_before_rho, day_before_phi = z2polar(day_before_noonperiod.u.mean(), day_before_noonperiod.v.mean())
######

##### Weather Game DB Stuff
    gameconn = pymysql.connect(
        host="localhost",
        user="measure",
        password="4measure",
        database="measurements"
    )
    with gameconn:
       # if test==True:
            #Insert Test Data
            #groups=[1,2,3,4,5,6,7,8,9,12,15]
            #for g in groups:
            #    sql = "INSERT INTO forecasts (day, group_id, min_temp, max_temp, total_rainfall, wind_direction, wind_speed) VALUES (%s, %s, %s, %s, %s, %s, %s) "
            #    data = (start_obj.strftime('%Y-%m-%d'),g,g,g,g,g,g)
            #    print("Insert verification data with:", sql, data)
            #    with gameconn.cursor() as cursor:
            #        cursor.execute(sql, data)
            #        gameconn.commit()

        #Retrieve All Forecasts For Today
        sql = "SELECT * from forecasts WHERE day=%s"
        data = (start_obj.strftime('%Y-%m-%d'),)
        print("Get Forecasts with:",sql, data)
        with gameconn.cursor() as cursor:
            cursor.execute(sql, data)
            df_today_forecast = DataFrame(cursor.fetchall())
        print("Data for Emily")
#        print(df_today_forecast)

#        #Insert Emily
#        sql = "INSERT INTO forecasts (day, group_id, min_temp, max_temp, total_rainfall, wind_direction, wind_speed) VALUES (%s, 14, %s, %s, %s, %s, %s) "
#        if np.isnan(df_today_forecast[6].mean())==True:
#            wind_direction=None
#        else:
#            wind_direction=round(df_today_forecast[6].mean())
#        if np.isnan(df_today_forecast[7].mean())==True:
#            wind_speed=0
#        else:
#            wind_speed=round(df_today_forecast[7].mean())
#        
#        data = (start_obj.strftime('%Y-%m-%d'),round(df_today_forecast[3].mean(),1),round(df_today_forecast[4].mean(),1),round(df_today_forecast[5].mean(),1),wind_direction,wind_speed)
#        print("Insert Emily data with:",sql, data)
#        with gameconn.cursor() as cursor:
#            cursor.execute(sql, data)
#            gameconn.commit()
#        
#        #Insert Percy
#        sql = "INSERT INTO forecasts (day, group_id, min_temp, max_temp, total_rainfall, wind_direction, wind_speed) VALUES (%s, 13, %s, %s, %s, %s, %s) "
        print(type(day_before_phi),day_before_rho)
#        if np.isnan(day_before_phi)==True:
#            wind_direction=None
#        else:
#            wind_direction=round(day_before_phi+360)
#        if np.isnan(day_before_rho)==True:
#            wind_speed=0
#        else:
#            wind_speed=round(day_before_rho)

#        data = (start_obj.strftime('%Y-%m-%d'), round(FtoC(day_before_df.outTemp.min()) *2.0,1)/2.0, round(FtoC(day_before_df.outTemp.max())*2.0,1)/2.0, round(day_before_df.rain.sum()*25.4*2.0,1)/2.0, wind_direction,wind_speed)
#        print("Insert Percy data with:", sql, data)
#        with gameconn.cursor() as cursor:
#            cursor.execute(sql, data)
#            gameconn.commit()

#        #Retrieve Verification For Yesterday
#        sql = "SELECT * from forecasts WHERE day=%s AND group_id=10"
#        data = (verf_obj.strftime('%Y-%m-%d'),)
        print("Get Yesterday Verification Data with:",sql, data)
#        with gameconn.cursor() as cursor:
#            cursor.execute(sql, data)
#            df_yesterday_ver = DataFrame(cursor.fetchall())
        print("Yesterday's Verfication Data:", df_yesterday_ver)

#        #Insert Verification   
#        sql = "INSERT INTO forecasts (day, group_id, min_temp, max_temp, total_rainfall, wind_direction, wind_speed) VALUES (%s, 10, %s, %s, %s, %s, %s) " 
#        if np.isnan(phi)==True:
#            wind_direction=None
#        else:
#            wind_direction=round(phi+360)
#        if np.isnan(rho)==True:
#            wind_speed=0
#        else:
#            wind_speed=round(rho)
#        data = (start_obj.strftime('%Y-%m-%d'), round(FtoC(df.outTemp.min()) *2.0)/2.0, round(FtoC(df.outTemp.max())*2.0)/2.0, round(df.rain.sum()*25.4*2.0)/2.0, wind_direction,wind_speed)
        print("Insert verification data with:", sql, data)
#        with gameconn.cursor() as cursor:
#            cursor.execute(sql, data)
#            gameconn.commit()


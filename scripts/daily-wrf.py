#!/opt/venv/bin/python

import pandas as pd
from datetime import datetime, timedelta
import sys
from urllib import urlopen

#infile= http://homepages.see.leeds.ac.uk/~lecrrb/ARRAN17/DAILY_FORECASTS/2017051512/tim/Timeseries_D03_2017-05-15_12_LL.txt
if len(sys.argv) >1:
    #date of command line
    indate = datetime.strptime(sys.argv[1], '%Y-%m-%d')
else:
    indate = datetime.utcnow()
infile = urlopen('http://homepages.see.leeds.ac.uk/~lecrrb/ARRAN17/DAILY_FORECASTS/' + indate.strftime('%Y%m%d') + '12/tim/Timeseries_D03_' + indate.strftime('%Y-%m-%d') +'_12_LL.txt')

df = pd.read_table(infile, sep="\s+", index_col='Date_Time', parse_dates=[[0,1]], nrows=73, skiprows=range(0,11)+[12], header=0)

start_date=datetime.strptime(df.index[0].date().strftime('%Y-%m-%d') + '18','%Y-%m-%d%H')

#print start_date


forecast = df.loc[ start_date.isoformat() : (start_date + timedelta(hours=24)).isoformat()]
noon =  forecast.loc[(start_date + timedelta(hours=18)).strftime('%Y-%m-%d %H:%M:%S')]
minTemp =  round(forecast.T2m.min()*2.0)/2.0
maxTemp = round(forecast.T2m.max()*2.0)/2.0
rain =  round(forecast.PRCIP.sum()*2.0)/2.0
windSpeed =  noon.TWSP * 0.51444
windDir = noon.TWD
print "INSERT INTO forecasts (day, group_id, min_temp, max_temp, total_rainfall, wind_direction, wind_speed) VALUES (%s, 7, %.1f, %.1f, %.1f, %d, %d) " % (start_date.strftime('"%Y-%m-%d"'), minTemp, maxTemp, rain, windDir, windSpeed)

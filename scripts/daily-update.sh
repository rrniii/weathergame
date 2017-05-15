#!/bin/bash
#DAVISDBFILE=/home/shareddata/met/dbfile/wview-archive.sdb
DAVISDBFILE=/var/www/html/weather/sql/weewx.sdb

DAY=${1:-'yesterday'}

#Only works correctly after 1800GMT.
START=`date +%Y-%m-%d -d "${DAY}"`
END=`date +%Y-%m-%d -d "${DAY} +1 days"`


SQL1="SELECT ROUND(Min((OutTemp - 32.0) * (5.0/9.0)),1) AS MinTemp, ROUND(MAX((OutTemp - 32.0) * (5.0/9.0)),1) AS MaxTemp, CAST(ROUND(SUM((rain))*25.4) AS integer) AS rainfall FROM archive WHERE DATETIME(dateTime, 'unixepoch') > '${START} 18:59:59' AND DATETIME(dateTime, 'unixepoch') < '${END} 18:00:00';"

#SQL2="SELECT CAST(ROUND(windDir,0) AS integer), CAST(ROUND(windSpeed * 0.447027) AS integer) FROM archive WHERE DATETIME(dateTime,'unixepoch') = '${END} 12:00:00';"
PROCTOWERFILE="/data/shareddata/tower/Proc/001w/wind-temp-rh-001-${END}.csv"
WIND=( $(cat $PROCTOWERFILE | grep "$END 12:00:00" | awk -F ',' '{print "/var/www/html/measurements/scripts/polar.py " $2" " $3}' | bash) )
sqlite3 $DAVISDBFILE "${SQL1}" | tr '\n' '|' | awk -F '|' '{print "INSERT INTO forecasts (day, group_id, min_temp, max_temp, total_rainfall, wind_direction, wind_speed) VALUES (\"'${START}'\", 10, "$1", "$2", "$3", '${WIND[1]}', '${WIND[0]}' );"}' #| mysql -umeasure -p4measure measurements

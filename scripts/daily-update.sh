#!/bin/sh
DAVISDBFILE=/var/lib/wview/archive/wview-archive.sdb


#Only works correctly after 1800GMT.
START=`date +%Y-%m-%d -d 'yesterday'`
END=`date +%Y-%m-%d `

SQL1="SELECT ROUND(Min((OutTemp - 32.0) * (5.0/9.0)),1) AS MinTemp, ROUND(MAX((OutTemp - 32.0) * (5.0/9.0)),1) AS MaxTemp, CAST(ROUND(SUM((rainRate/12))*25.4) AS integer) AS rainfall FROM archive WHERE DATETIME(dateTime, 'unixepoch') > '${START} 17:59:59' AND DATETIME(dateTime, 'unixepoch') < '${END} 18:00:00';"
SQL2="SELECT DATETIME(dateTime, 'unixepoch'), CAST(ROUND(windDir,0) AS integer), CAST(ROUND(windSpeed * 0.447027) AS integer) FROM archive WHERE DATETIME(dateTime,'unixepoch') = '${END} 12:00:00';"
echo $SQL1
sqlite3 $DAVISDBFILE "$SQL1"
echo $SQL2
sqlite3 $DAVISDBFILE "$SQL2"

#!/bin/bash

log_file="mbscanner.log";
reports="reports";
default_scan_path=`pwd`;
receiver="miha98@gmail.com";
server_name="localhost";
report_file_name="mb/mbreports/mb_cure_report.txt"

function log () {
    #echo "action: " ${*}
    now=`date`
    echo ${*}
    echo $now "\t" ${*} >> $log_file;
}

echo '#########' `date` '##########' > $log_file;
log "Starting scanner execution";
log "Current directory " pwd
php=`which php`;
log "PHP interpreter location: " $php
if [ "" != "$1" ] && [ -e "$1" ]; then
    echo "Setting scan path to $1"
    default_scan_path=$1;
fi

log "Scanning $default_scan_path";
echo > $report_file_name;
$php ./mb.php match $default_scan_path >> $log_file;

mkdir -p $reports;
today=`date '+%Y_%m_%d_%H_%M_%S'`;
grep "file\s" $report_file_name | sort -u > $reports/$today.infected.log
cp $report_file_name $reports/$today.full.log
log "Scanner is done. Generated reports $reports/$today.infected.log and $reports/$today.full.log";




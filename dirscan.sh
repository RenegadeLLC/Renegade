#!/bin/bash

PHP=php

usage(){
    echo "$0 scan directories from provided input up to provided deep level";
    echo "$0 <path> <depth>";
}

if [ $# != 2 ]
then 
    usage
    exit -1;
fi

if ! [[ -d $1 ]]
then 
    echo "Provided input is not directory";
    usage;
    exit -1;
fi

re='^[0-9]+$'
if ! [[ $2 =~ $re ]] ; then
    echo "error: depth is not a number" >&2;
    usage
    exit -1;
fi

echo "Listing directories until level $2";
find $1 -mindepth $2 -maxdepth $2 -type d > /tmp/qtr_dir_list.tmp

while read directory; do 
     echo "Matching directory $directory"
     $PHP ./mb.php match $directory
     cat ./mb/mbreports/mb_cure_report.txt >> ./match_report.txt
done < /tmp/qtr_dir_list.tmp 

echo "Full match report stored into ./match_report.txt";

# echo $dir_list;


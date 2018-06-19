#!/bin/bash

while (( "$#" )); do 
    if [ -e $1 ]; then 
        mv $1 $1.__qtr__
    fi
    shift 
done

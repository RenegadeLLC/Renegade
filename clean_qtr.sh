#!/bin/sh
find $1 | grep __qtr__ | xargs rm -rf

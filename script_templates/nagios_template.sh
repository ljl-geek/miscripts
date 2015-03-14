#!/bin/bash

# explain script here

# default thresholds go here
warnd=_____
critd=_____

# describe your check for output and perf
description=" _____ _____ "
itemname="____"

function usage () {
cat <<-USAGE
    Usage: $0 -w <warn> -c <crit> -h
    Nagios/Icinga check for $description 
    Performance data for $itemname is also generated
    To change default thresholds, edit the variables, otherwise pass them in as arguments
USAGE
}

# getops define them here, and put in usage
while getopts "w:c:h" OPT; do
    case "$OPT" in
        w) warn="$OPTARG" ;;
        c) crit="$OPTARG" ;;
        h) usage
           exit 3                                     ;;
        *) echo "Unrecognized option: $OPT" >&2
           echo >&2
           usage
           exit 3                                   ;;
    esac
done

## use defaults if we didn't pass in thresholds
if [[ x"$warn" == x"" ]]; then
    	warn="$warnd"
fi

if [[ x"$crit" == x"" ]]; then
    	crit="$critd"
fi

# data grab and parse goes here
result=$( _____  )

# check to see if we have a value at all
if [[ x"$result" == x"" ]]; then
	echo "UNKNOWN: _____________ doesn't return a value"
	exit 3
fi 

# now do the return, order matters here, note the exits
if [ $result -ge $crit ] ; then
	echo "CRITICAL: $result $description | $itemname=$result;$warn;$crit;0"
	exit 2
elif [ $result -ge $warn ] ; then
        echo "WARNING: $result $description | $itemname=$result;$warn;$crit;0"
        exit 1
elif [ $result -lt $warn ] ; then
        echo "OK: $result $description | $itemname=$result;$warn;$crit;0"
        exit 0
else
	echo "UNKNOWN: ______ doesn't return a valid value for $description, or something else is wrong"
	exit 3
fi

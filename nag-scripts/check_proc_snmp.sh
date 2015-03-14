#!/bin/bash

# this script looks for an arbitrary process name and uses snmp to get the count

# default thresholds go here
dmin=1
dmax=100
dport=161
graph=""

function usage () {
cat <<-USAGE
    Usage: $0 -H <host> -p <port> -C <community> -P <process> -m <min> -M <max> -g -h
    -H <host => required
    -p <port> => default = 161
    -C <community> => required
    -P <process> => required
    -m <min> => default = 1
    -M <max> => default = 100
    -g => add performance data for graphing (optional)
    -h => show usage and exit
    Nagios check for an arbitrary process via SNMP MIB 1.3.6.1.2.1.25.4.2.1.4
    To change default thresholds, edit the variables, otherwise pass them in as arguments.
    The process needs to be the first part of the process call, not the arguments.
USAGE
}

# getops define them here, and put in usage
while getopts "H:p:C:P:m:M:gh" OPT; do
    case "$OPT" in
        m) min="$OPTARG" ;;
        M) max="$OPTARG" ;;
        H) host="$OPTARG" ;;
        p) port="$OPTARG" ;;
        P) process="$OPTARG" ;;
        C) community="$OPTARG" ;;
        g) graph=1  ;;
        h) usage
           exit 3                                     ;;
        *) echo "Unrecognized option: $OPT" >&2
           echo >&2
           usage
           exit 3                                   ;;
    esac
done

# check the inputs here
if [ x"$host" == "x" ]
then
	echo "UNKNOWN: host not specified"
	exit 3
fi 

if [ x"$community" == "x" ]
then
	echo "UNKNOWN: community string not specified"
	exit 3
fi 

## default partition is /
if [ x"$process" == "x" ]
then
	echo "UNKNOWN: process not specified"
fi 

if [ x"$port" == "x" ]
then
	port=$dport
fi 

## use default thresholds if not defined
if [ x"$min" == "x" ]
then
	min=$dmin
fi 
if [ x"$max" == "x" ]
then
	max=$dmax
fi 

# data grab and parse goes here

n=$(snmpwalk -v2c -c $community -m ALL $host:$port -Ov  1.3.6.1.2.1.25.4.2.1.4 | grep $process | wc -l)

# check to see if we have a value at all
if [ x"$n" == "x" ]
then
	echo "UNKNOWN: nothing back, check snmpd and the port"
	exit 3
fi 

if [ $graph ]
then 
	perf="| procs=$n;$min;$max;0;"
else
	perf=""
fi


if [ $n -lt $min ]
then
	echo "CRITICAL: $n $process instance(s) < $min running $perf"
	exit 2
fi

if [ $n	-gt $max ]
then
        echo "CRITICAL:	$n $process instance(s) > $max running $perf"
        exit 2
fi

echo "OK: $n $process instance(s) running $perf"
exit 0

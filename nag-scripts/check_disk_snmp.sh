#!/bin/bash

# this script looks for an arbitrary partition name and uses snmp to get the disk usage


# default thresholds go here
dwarn=80
dcrit=90
dport=161

function usage () {
cat <<-USAGE
    Usage: $0 -H <host> -p <port> -C <community> -P <partition> -w <warn> -c <crit>  -h
    Nagios check for disk usage of a partition
    To change default thresholds, edit the variables, otherwise pass them in as arguments
USAGE
}

# getops define them here, and put in usage
while getopts "H:p:C:P:w:c:h" OPT; do
    case "$OPT" in
        w) warn="$OPTARG" ;;
        c) crit="$OPTARG" ;;
        H) host="$OPTARG" ;;
        p) port="$OPTARG" ;;
        P) part="$OPTARG" ;;
        C) community="$OPTARG" ;;
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
if [ x"$part" == "x" ]
then
	part="/"
fi 

if [ x"$port" == "x" ]
then
	port=$dport
fi 

## use default thresholds if not defined
if [ x"$warn" == "x" ]
then
	warn=$dwarn
fi 
if [ x"$crit" == "x" ]
then
	crit=$dcrit
fi 

# data grab and parse goes here

n=$(snmpwalk -v2c -c $community -m ALL $host:$port 1.3.6.1.2.1.25.2.3.1.3 -Onq | grep $part | awk '{ print $1 }' | awk -F. '{print $13 }')

# check to see if we have a value at all
if [ x"$n" == "x" ]
then
	echo "UNKNOWN: nothing back, check snmpd and the port"
	exit 3
fi 

num=$( snmpget -v2c -Onq -c $community $host:$port 1.3.6.1.2.1.25.2.3.1.6.$n | awk  '{ print $2 }')
den=$(snmpget -v2c -Onq -c $community $host:$port 1.3.6.1.2.1.25.2.3.1.5.$n | awk  '{ print $2 }')
block=$(snmpget -v2c -Onq -c $community $host:$port 1.3.6.1.2.1.25.2.3.1.4.$n | awk  '{ print 2 }')

raw=$(echo "scale=4;100 * $num / $den" | bc )
perc=$(echo "($raw + 0.5)/1" | bc)
used=$(echo "$num * $block" | bc )
tot=$(echo "$den * $block" | bc )

perf="$part="$raw"%;$warn;$crit;; used="$used"B;;;0;$tot"

##echo "percent = $perc, warn = $warn, crit = $crit"

# now do the return, order matters here, note the exits
if [ $perc -ge $crit ] 
then
	echo "CRITICAL: $part $perc % used > $crit | $perf"
	exit 2
fi

if [ $perc -ge $warn ] 
then
        echo "WARNING: $part $perc % used > $warn | $perf"
        exit 1
fi

if [ $perc -lt $warn ] 
then
        echo "OK: $part $perc % used | $perf"
        exit 0
fi

echo "UNKNOWN: snmp doesn't return a valid value for $part, or something else is wrong"
exit 3


#!/bin/bash

# this is a crude script to do bulk downtime in nagios
# it takes a hostgroup and a start and end time
# This is a shell script to the SCHEDULE_HOSTGROUP_SVC_DOWNTIME command
# to Nagios.
  
# $Date$
# $Author$ original by lindal
# $Revision$

commandfile='/usr/local/nagios/var/rw/nagios.cmd'

now=`date +%s`

function usage () {
cat <<-USAGE
    Usage: sudo -u nagios $0 -b "<quoted hosts seperated by commas>" -x "<quoted service>" -s "<start date/time>" -e "<end date/time>" -h
    Schedule downtime for one service on several hosts 
    (note, for shards use the cname "-master" or "-slave", not "a" or "b")    
USAGE
}

# getops define them here, and put in usage
while getopts b:x:s:e:h OPT; do
    case "$OPT" in
        h) usage
           exit 0                                     ;;
        b) boxen="$OPTARG"                   ;;
	x) service="$OPTARG"                   ;;
        s) start="$OPTARG"                   ;;
        e) end="$OPTARG"                   ;;
        *) echo "Unrecognized option: $OPT" >&2
           echo >&2
           usage
           exit 126                                   ;;
    esac
done

# check for presence of required optiond
if [ x$boxen == "x" ]
then
        usage
        echo; echo "host(s) required"
        exit 1
fi

# check for presence of required optiond
if [ x"$service" == "x" ]
then
        usage
        echo; echo "service required"
        exit 1
fi

if [ x"$start" == "x" ]
then
        usage
        echo; echo "start time required"
        exit 1
fi

if [ x"$end" == "x" ]
then
        usage
        echo; echo "end time required"
        exit 1
fi

who=`whoami`
comment="Downtime from $start until $end"


#$starts is start seconds
starts=$(date --date="$start" "+%s")

#$ends is end seconds
ends=$(date --date="$end" "+%s")

#$els is diff between end and start
els=$(expr $ends - $starts)


#$box is boxen from foreach loop
box_array=(`echo $boxen  | tr "," "\n"`)

for box in "${box_array[@]}"
do

 /usr/bin/printf "[%lu] SCHEDULE_SVC_DOWNTIME;$box;$service;$starts;$ends;1;0;$els;$who;$comment\n" $now >> $commandfile 
echo "$box in downtime for $service for $els seconds"
done

exit 0





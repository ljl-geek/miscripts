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
    Usage: sudo -u nagios $0 -b "<quoted hosts seperated by commas>" -s "<start date/time>" -e "<end date/time>" -h
    Schedule downtime for all services by host(s)
USAGE
}

# getops define them here, and put in usage
while getopts b:s:e:h OPT; do
    case "$OPT" in
        h) usage
           exit 0                                     ;;
        b) boxen="$OPTARG"                   ;;
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
 /usr/bin/printf "[%lu] SCHEDULE_HOST_SVC_DOWNTIME;$box;$starts;$ends;1;0;$els;$who;$comment\n" $now >> $commandfile 
# >> $commandfile
done

exit 0





#!/bin/bash

tstart=$(date)

function usage () {
cat <<-USAGE
    Usage: $0 -r "<range>" -h

USAGE
}

# getops define them here, and put in usage
while getopts r:h OPT; do
    case "$OPT" in
        h) usage
           exit 0                                     ;;
        r) range="$OPTARG"                   ;;
        *) echo "Unrecognized option: $OPT" >&2
           echo >&2
           usage
           exit 126                                   ;;
    esac
done

# check for presence of required optiond
if [ x$range == "x" ]
then
        usage
        echo; echo "range is required"
        exit 1
fi


# the commands are heeere
case "$foo" in
  cmd0)
echo "Echo partition and ls $newpath"
cmd="echo \"partition is $part\"; ls -l $newpath"
after="You will need these times to set the RIDs to >12 hours before"
  ;;
  *)
        echo "command not found"
        exit 127
  ;;
esac

tend=$(date)

echo "started at $tstart, ended at $tend"


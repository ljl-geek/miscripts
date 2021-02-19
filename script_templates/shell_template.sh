#!/bin/bash

tstart=$(date)

function usage () {
cat <<-USAGE
    Usage: $0 -r "<range>" -c <command> -h
    -r "range" list of stuff to do things to
    -c "command" is what to do to them
USAGE
}

# getops define them here, and put in usage
while getopts c:r:h OPT; do
    case "$OPT" in
        h) usage
           exit 0                                     ;;
        r) range="$OPTARG"                   ;;
        c) foo="$OPTARG"                   ;;
        *) echo "Unrecognized option: $OPT" >&2
           echo >&2
           usage
           exit 126                                   ;;
    esac
done

# check for presence of required options
if [ x$range == "x" ]
then
        usage
        echo; echo "range is required"
        exit 1
fi

if [ x$foo == "x" ]
then
        usage
        echo; echo "command is required"
        exit 1
fi




# the commands are heeere
case "$foo" in
  partition)
    ## example of a partial command set
    echo "Echo partition and ls $newpath"
    cmd="echo \"partition is $part\"; ls -l $newpath"
    result=$($cmd)
    after="You will need these times to set the RIDs to >12 hours before"
    echo "$result \n$after"
    ;;
  *)
        echo "command not found"
        exit 127
    ;;
esac

tend=$(date)

echo "started at $tstart, ended at $tend"

exit 0

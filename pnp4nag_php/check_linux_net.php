<?php

/*
* As mangled by Linda Laubenheimer - geek@laubenheimer.net 
*/

$red       = '#FF0000';
$teal      = '#1693A7';
$darkred   = '#990000';
$green     = '#60CC6f';
$yellow    = '#FFFF00';
$darkyellow    = '#FFCC00';
$purple    = '#774499';
$lightgrey = '#CCCCCC';
$huntergreen = '#487860';
$purplegrey = '#907790';
$orange    = '#FF9933';
$brown     = '#783030';
$blue      = '#6666EE';
$darkgrey  = '#555555';
$grey      = '#888888';
$paleblue  = '#80B4C1';
$darkbrown = '#543820';
$black     = '#000000';

/* 
Use with check_linux_net:
 ./check_linux_net -S DATA_IN,DATA_OUT,ERR_IN,ERR_OUT,DROP -D B -i eth0
'Incoming Data (bytes)'=68060B:::: 'Outgoing Data (bytes)'=43221B:::: 'Incoming Errors'=0:::: 'Outgoing Errors'=0:::: 'Dropped Packets'=0::::'

*/

/* Network Traffix */
$ds_name[1] = 'Network Traffic';
$opt[1] = "--title \"$hostname - Network Traffic (Bytes)\"";
$def[1]='';
$def[1] .= rrd::def('incoming', $RRDFILE[1], $DS[1], 'MAX');
$def[1] .= rrd::def('outgoing', $RRDFILE[1], $DS[2], 'MAX');
/* negate the bytes sent for graph purpose with cdef in reverse polish format */
$def[1] .= rrd::cdef('neg_outgoing','outgoing,-1,*');
$label = rrd::cut('Incoming Data',20);
$def[1] .= rrd::area('incoming',$purple,$label,0);
$def[1] .= rrd::gprint('incoming',array('LAST','AVERAGE','MAX'),"%.1lf%S");
$label = rrd::cut('Outgoing Data',20);
$def[1] .= rrd::area('neg_outgoing',$green,$label,0);
$def[1] .= rrd::gprint('outgoing',array('LAST','AVERAGE','MAX'),"%.1lf%S");

/* Errors/Drops */
$ds_name[2] = 'Errors';
$opt[2] = "--title  \"$hostname - Errors\" --lower-limit 0";
$def[2] = '';
$def[2] .= rrd::def('err_in', $RRDFILE[1], $DS[3], 'MAX');
$def[2] .= rrd::def('err_out', $RRDFILE[1], $DS[4], 'MAX');
$def[2] .= rrd::def('drops', $RRDFILE[1], $DS[5], 'MAX');
$def[2] .= rrd::area ('err_in',$blue, 'Incoming Errors', 'STACK');
$def[2] .= rrd::gprint ('err_in', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");
$def[2] .= rrd::area ('err_out',$grey, 'Outgoing Errors', 'STACK');
$def[2] .= rrd::gprint ('err_out', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");
$def[2] .= rrd::area ('drops',$red, 'Dropped Packets', 'STACK');
$def[2] .= rrd::gprint ('drops', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");


?>

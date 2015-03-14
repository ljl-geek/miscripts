<?php
/*

Check JVM SNMP
Icinga plugin to check JVM Statistics via snmp, and graph the performance Data
 by L J Laubenheimer, code@laubenheimer.net
- initial graph set

*/

$red       = '#FF0000';
$teal      = '#1693A7';
$darkred   = '#990000';
$green     = '#60CC6f';
$yellow    = '#FFF200';
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
$darkblue  = '#000044';
$lightgreen = '#00FF00';

$num = 1;

$ds_name[$num] = 'JVM Classes';
$opt[$num] = "--title  \"$hostname - JVM Classes Loaded\" --lower-limit 0";
$def[$num] = rrd::def('jCTlLCt', $RRDFILE[1], $DS[2], 'MAX');
$def[$num] .= rrd::def('jCLCt', $RRDFILE[1], $DS[1], 'AVERAGE');
$def[$num] .= rrd::def('jCUnLCt', $RRDFILE[1], $DS[3], 'AVERAGE');
$def[$num] .= rrd::area ('jCLCt',$green, 'LoadedCount', 'STACK');
$def[$num] .= rrd::gprint ('jCLCt', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");
$def[$num] .= rrd::area ('jCUnLCt',$yellow, 'UnloadedCount', 'STACK');
$def[$num] .= rrd::gprint ('jCUnLCt', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");
$def[$num] .= rrd::line1 ('jCTlLCt', $black, 'TotalLoadedCount' );
$def[$num] .= rrd::gprint ('jCTlLCt', array('LAST','MAX','AVERAGE'), "%4.0lf\\t"); 

++$num;

$ds_name[$num] = 'JVM Heap Utilization';
$opt[$num] = "--title  \"$hostname - JVM Heap Utilization\" ";
$def[$num] = rrd::def('jMHMxSz', $RRDFILE[1], $DS[8], 'AVERAGE');
$def[$num] .= rrd::def('jMHCom', $RRDFILE[1], $DS[7], 'AVERAGE');
$def[$num] .= rrd::def('jMHU', $RRDFILE[1], $DS[6], 'AVERAGE');
$def[$num] .= rrd::def('jMHInSz', $RRDFILE[1], $DS[5], 'AVERAGE');
$def[$num] .= rrd::area ('jMHMxSz',$red, 'Max', 'STACK');
$def[$num] .= rrd::gprint ('jMHMxSz', array('LAST','MAX','AVERAGE'), "%4.3lf %S\\t");
$def[$num] .= rrd::line3 ('jMHCom', $lightgreen, 'Committed' );
$def[$num] .= rrd::gprint ('jMHCom', array('LAST','MAX','AVERAGE'), "%4.3lf %S\\t");
$def[$num] .= rrd::area ('jMHU',$teal, 'Used');
$def[$num] .= rrd::gprint ('jMHU', array('LAST','MAX','AVERAGE'), "%4.3lf %S\\t");
$def[$num] .= rrd::line1 ('jMHMxSz', $red );
$def[$num] .= rrd::line1 ('jMHU', $blue );

++$num;

$ds_name[$num] = 'JVM Non-Heap Utilization';
$opt[$num] = "--title  \"$hostname - JVM Non-Heap Utilization\" ";
$def[$num] = rrd::def('jMNHMxSz', $RRDFILE[1], $DS[12], 'AVERAGE');
$def[$num] .= rrd::def('jMNHCom', $RRDFILE[1], $DS[11], 'AVERAGE');
$def[$num] .= rrd::def('jMNHU', $RRDFILE[1], $DS[10], 'AVERAGE');
$def[$num] .= rrd::def('jMNHInSz', $RRDFILE[1], $DS[9], 'AVERAGE');
$def[$num] .= rrd::area ('jMNHMxSz',$teal, 'Max', 'STACK');
$def[$num] .= rrd::gprint ('jMNHMxSz', array('LAST','MAX','AVERAGE'), "%4.3lf %S\\t");
$def[$num] .= rrd::line3 ('jMNHCom', $yellow, 'Committed' );
$def[$num] .= rrd::gprint ('jMNHCom', array('LAST','MAX','AVERAGE'), "%4.3lf %S\\t");
$def[$num] .= rrd::area ('jMNHU',$red, 'Used');
$def[$num] .= rrd::gprint ('jMNHU', array('LAST','MAX','AVERAGE'), "%4.3lf %S\\t");
$def[$num] .= rrd::line1 ('jMNHMxSz', $teal );

++$num;

$ds_name[$num] = 'JVM GC Stats';
$opt[$num] = "--title  \"$hostname - JVM GC Stats\" ";
$def[$num] = rrd::def('jMGCCt2', $RRDFILE[1], $DS[13], 'AVERAGE');
$def[$num] .= rrd::def('jMGCCt3', $RRDFILE[1], $DS[14], 'AVERAGE');
$def[$num] .= rrd::def('jMGCTmMs2', $RRDFILE[1], $DS[15], 'AVERAGE');
/*$def[$num] .= rrd::cdef('jMGCTmSec2','jMGCTmMs2,1000,/');*/
$def[$num] .= rrd::def('jMGCTmMs3', $RRDFILE[1], $DS[16], 'AVERAGE');
/*$def[$num] .= rrd::cdef('jMGCTmSec3','jMGCTmMs3,1000,/');*/
$def[$num] .= rrd::line1 ('jMGCCt2', $red, 'New Gen GC Count' );
$def[$num] .= rrd::gprint ('jMGCCt2', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");
$def[$num] .= rrd::line1 ('jMGCTmMs2', $blue, 'New Gen GC Time Ms' );
$def[$num] .= rrd::gprint ('jMGCTmMs2', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");
$def[$num] .= rrd::line1 ('jMGCCt3', $darkred, 'Old Gen GC Count' );
$def[$num] .= rrd::gprint ('jMGCCt3', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");
$def[$num] .= rrd::line1 ('jMGCTmMs3', $darkblue, 'Old Gen GC Time Ms' );
$def[$num] .= rrd::gprint ('jMGCTmMs3', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");

++$num;

$ds_name[$num] = 'JVM Pool Code Cache';
$opt[$num] = "--title  \"$hostname - JVM Pool Code Cache\" ";
$def[$num] = rrd::def('jMPInSz1', $RRDFILE[1], $DS[22], 'AVERAGE');
$def[$num] .= rrd::def('jMPU1', $RRDFILE[1], $DS[23], 'AVERAGE');
$def[$num] .= rrd::def('jMPCom1', $RRDFILE[1], $DS[32], 'AVERAGE');
$def[$num] .= rrd::def('jMPMxSz1', $RRDFILE[1], $DS[37], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkU1', $RRDFILE[1], $DS[42], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkCom1', $RRDFILE[1], $DS[47], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkMxSz1', $RRDFILE[1], $DS[52], 'AVERAGE');
$def[$num] .= rrd::def('jMPCU1', $RRDFILE[1], $DS[57], 'AVERAGE');
$def[$num] .= rrd::def('jMPCCom1', $RRDFILE[1], $DS[62], 'AVERAGE');
$def[$num] .= rrd::def('jMPCMxSz1', $RRDFILE[1], $DS[67], 'AVERAGE');
$def[$num] .= rrd::line2 ('jMPMxSz1', $darkblue, 'Pool Max Size' );
$def[$num] .= rrd::gprint ('jMPMxSz1', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPInSz1', $blue, 'Pool Initial Size' );
$def[$num] .= rrd::gprint ('jMPInSz1', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPU1', $green, 'Pool Used' );
$def[$num] .= rrd::gprint ('jMPU1', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCom1', $teal, 'Pool Committed' );
$def[$num] .= rrd::gprint ('jMPCom1', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkMxSz1', $orange, 'Peak Max Pool' );
$def[$num] .= rrd::gprint ('jMPPkMxSz1', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkU1', $red, 'Peak Used Pool' );
$def[$num] .= rrd::gprint ('jMPPkU1', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkCom1', $yellow, 'Peak Commited Pool' );
$def[$num] .= rrd::gprint ('jMPPkCom1', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCMxSz1', $huntergreen, 'Collect Max Pool' );
$def[$num] .= rrd::gprint ('jMPCMxSz1', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCU1', $grey, 'Collect Used Pool' );
$def[$num] .= rrd::gprint ('jMPCU1', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCCom1', $purple, 'Collect Committed Pool' );
$def[$num] .= rrd::gprint ('jMPCCom1', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");

++$num;
$ds_name[$num] = 'JVM Pool Par Eden Space';
$opt[$num] = "--title  \"$hostname - JVM Pool Par Eden Space\" ";
$def[$num] = rrd::def('jMPInSz2', $RRDFILE[1], $DS[23], 'AVERAGE');
$def[$num] .= rrd::def('jMPU2', $RRDFILE[1], $DS[28], 'AVERAGE');
$def[$num] .= rrd::def('jMPCom2', $RRDFILE[1], $DS[33], 'AVERAGE');
$def[$num] .= rrd::def('jMPMxSz2', $RRDFILE[1], $DS[38], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkU2', $RRDFILE[1], $DS[43], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkCom2', $RRDFILE[1], $DS[48], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkMxSz2', $RRDFILE[1], $DS[53], 'AVERAGE');
$def[$num] .= rrd::def('jMPCU2', $RRDFILE[1], $DS[58], 'AVERAGE');
$def[$num] .= rrd::def('jMPCCom2', $RRDFILE[1], $DS[63], 'AVERAGE');
$def[$num] .= rrd::def('jMPCMxSz2', $RRDFILE[1], $DS[68], 'AVERAGE');
$def[$num] .= rrd::line2 ('jMPMxSz2', $darkblue, 'Pool Max Size' );
$def[$num] .= rrd::gprint ('jMPMxSz2', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPInSz2', $blue, 'Pool Initial Size' );
$def[$num] .= rrd::gprint ('jMPInSz2', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPU2', $green, 'Pool Used' );
$def[$num] .= rrd::gprint ('jMPU2', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCom2', $teal, 'Pool Committed' );
$def[$num] .= rrd::gprint ('jMPCom2', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkMxSz2', $orange, 'Peak Max Pool' );
$def[$num] .= rrd::gprint ('jMPPkMxSz2', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkU2', $red, 'Peak Used Pool' );
$def[$num] .= rrd::gprint ('jMPPkU2', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkCom2', $yellow, 'Peak Commited Pool' );
$def[$num] .= rrd::gprint ('jMPPkCom2', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCMxSz2', $huntergreen, 'Collect Max Pool' );
$def[$num] .= rrd::gprint ('jMPCMxSz2', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCU2', $grey, 'Collect Used Pool' );
$def[$num] .= rrd::gprint ('jMPCU2', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCCom2', $purple, 'Collect Committed Pool' );
$def[$num] .= rrd::gprint ('jMPCCom2', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");

++$num;
$ds_name[$num] = 'JVM Pool Par Survivor Space';
$opt[$num] = "--title  \"$hostname - JVM Pool Par Survivor Space\" ";
$def[$num] = rrd::def('jMPInSz3', $RRDFILE[1], $DS[24], 'AVERAGE');
$def[$num] .= rrd::def('jMPU3', $RRDFILE[1], $DS[29], 'AVERAGE');
$def[$num] .= rrd::def('jMPCom3', $RRDFILE[1], $DS[34], 'AVERAGE');
$def[$num] .= rrd::def('jMPMxSz3', $RRDFILE[1], $DS[39], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkU3', $RRDFILE[1], $DS[44], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkCom3', $RRDFILE[1], $DS[49], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkMxSz3', $RRDFILE[1], $DS[54], 'AVERAGE');
$def[$num] .= rrd::def('jMPCU3', $RRDFILE[1], $DS[59], 'AVERAGE');
$def[$num] .= rrd::def('jMPCCom3', $RRDFILE[1], $DS[64], 'AVERAGE');
$def[$num] .= rrd::def('jMPCMxSz3', $RRDFILE[1], $DS[69], 'AVERAGE');
$def[$num] .= rrd::line2 ('jMPMxSz3', $darkblue, 'Pool Max Size' );
$def[$num] .= rrd::gprint ('jMPMxSz3', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPInSz3', $blue, 'Pool Initial Size' );
$def[$num] .= rrd::gprint ('jMPInSz3', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPU3', $green, 'Pool Used' );
$def[$num] .= rrd::gprint ('jMPU3', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCom3', $teal, 'Pool Committed' );
$def[$num] .= rrd::gprint ('jMPCom3', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkMxSz3', $orange, 'Peak Max Pool' );
$def[$num] .= rrd::gprint ('jMPPkMxSz3', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkU3', $red, 'Peak Used Pool' );
$def[$num] .= rrd::gprint ('jMPPkU3', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkCom3', $yellow, 'Peak Commited Pool' );
$def[$num] .= rrd::gprint ('jMPPkCom3', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCMxSz3', $huntergreen, 'Collect Max Pool' );
$def[$num] .= rrd::gprint ('jMPCMxSz3', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCU3', $grey, 'Collect Used Pool' );
$def[$num] .= rrd::gprint ('jMPCU3', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCCom3', $purple, 'Collect Committed Pool' );
$def[$num] .= rrd::gprint ('jMPCCom3', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");

++$num;
$ds_name[$num] = 'JVM Pool CMS Old Gen';
$opt[$num] = "--title  \"$hostname - JVM Pool CMS Old Gen\" ";
$def[$num] = rrd::def('jMPInSz4', $RRDFILE[1], $DS[25], 'AVERAGE');
$def[$num] .= rrd::def('jMPU4', $RRDFILE[1], $DS[30], 'AVERAGE');
$def[$num] .= rrd::def('jMPCom4', $RRDFILE[1], $DS[35], 'AVERAGE');
$def[$num] .= rrd::def('jMPMxSz4', $RRDFILE[1], $DS[40], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkU4', $RRDFILE[1], $DS[45], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkCom4', $RRDFILE[1], $DS[50], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkMxSz4', $RRDFILE[1], $DS[55], 'AVERAGE');
$def[$num] .= rrd::def('jMPCU4', $RRDFILE[1], $DS[60], 'AVERAGE');
$def[$num] .= rrd::def('jMPCCom4', $RRDFILE[1], $DS[65], 'AVERAGE');
$def[$num] .= rrd::def('jMPCMxSz4', $RRDFILE[1], $DS[70], 'AVERAGE');
$def[$num] .= rrd::line2 ('jMPMxSz4', $darkblue, 'Pool Max Size' );
$def[$num] .= rrd::gprint ('jMPMxSz4', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPInSz4', $blue, 'Pool Initial Size' );
$def[$num] .= rrd::gprint ('jMPInSz4', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPU4', $green, 'Pool Used' );
$def[$num] .= rrd::gprint ('jMPU4', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCom4', $teal, 'Pool Committed' );
$def[$num] .= rrd::gprint ('jMPCom4', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkMxSz4', $orange, 'Peak Max Pool' );
$def[$num] .= rrd::gprint ('jMPPkMxSz4', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkU4', $red, 'Peak Used Pool' );
$def[$num] .= rrd::gprint ('jMPPkU4', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkCom4', $yellow, 'Peak Commited Pool' );
$def[$num] .= rrd::gprint ('jMPPkCom4', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCMxSz4', $huntergreen, 'Collect Max Pool' );
$def[$num] .= rrd::gprint ('jMPCMxSz4', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCU4', $grey, 'Collect Used Pool' );
$def[$num] .= rrd::gprint ('jMPCU4', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCCom4', $purple, 'Collect Committed Pool' );
$def[$num] .= rrd::gprint ('jMPCCom4', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");

++$num;
$ds_name[$num] = 'JVM Pool CMS Perm Gen';
$opt[$num] = "--title  \"$hostname - JVM Pool CMS Perm Gen\" ";
$def[$num] = rrd::def('jMPInSz5', $RRDFILE[1], $DS[26], 'AVERAGE');
$def[$num] .= rrd::def('jMPU5', $RRDFILE[1], $DS[31], 'AVERAGE');
$def[$num] .= rrd::def('jMPCom5', $RRDFILE[1], $DS[36], 'AVERAGE');
$def[$num] .= rrd::def('jMPMxSz5', $RRDFILE[1], $DS[41], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkU5', $RRDFILE[1], $DS[46], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkCom5', $RRDFILE[1], $DS[51], 'AVERAGE');
$def[$num] .= rrd::def('jMPPkMxSz5', $RRDFILE[1], $DS[56], 'AVERAGE');
$def[$num] .= rrd::def('jMPCU5', $RRDFILE[1], $DS[61], 'AVERAGE');
$def[$num] .= rrd::def('jMPCCom5', $RRDFILE[1], $DS[66], 'AVERAGE');
$def[$num] .= rrd::def('jMPCMxSz5', $RRDFILE[1], $DS[71], 'AVERAGE');
$def[$num] .= rrd::line2 ('jMPMxSz5', $darkblue, 'Pool Max Size' );
$def[$num] .= rrd::gprint ('jMPMxSz5', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPInSz5', $blue, 'Pool Initial Size' );
$def[$num] .= rrd::gprint ('jMPInSz5', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPU5', $green, 'Pool Used' );
$def[$num] .= rrd::gprint ('jMPU5', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCom5', $teal, 'Pool Committed' );
$def[$num] .= rrd::gprint ('jMPCom5', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkMxSz5', $orange, 'Peak Max Pool' );
$def[$num] .= rrd::gprint ('jMPPkMxSz5', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkU5', $red, 'Peak Used Pool' );
$def[$num] .= rrd::gprint ('jMPPkU5', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPPkCom5', $yellow, 'Peak Commited Pool' );
$def[$num] .= rrd::gprint ('jMPPkCom5', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCMxSz5', $huntergreen, 'Collect Max Pool' );
$def[$num] .= rrd::gprint ('jMPCMxSz5', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCU5', $grey, 'Collect Used Pool' );
$def[$num] .= rrd::gprint ('jMPCU5', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");
$def[$num] .= rrd::line2 ('jMPCCom5', $purple, 'Collect Committed Pool' );
$def[$num] .= rrd::gprint ('jMPCCom5', array('LAST','MAX','AVERAGE'), "%4.0lf %S\\t");

++$num;
$ds_name[$num] = 'JVM Thread Count';
$opt[$num] = "--title  \"$hostname - JVM Thread Count\" --lower-limit 0";
$def[$num] = rrd::def('jThCt', $RRDFILE[1], $DS[92], 'AVERAGE');
$def[$num] .= rrd::def('jThDCt', $RRDFILE[1], $DS[93], 'AVERAGE');
$def[$num] .= rrd::def('jThPkCt', $RRDFILE[1], $DS[94], 'AVERAGE');
$def[$num] .= rrd::def('jThTlStCt', $RRDFILE[1], $DS[95], 'AVERAGE');
$def[$num] .= rrd::area ('jThTlStCt', $yellow, 'Thread Total Since Start' );
$def[$num] .= rrd::gprint ('jThTlStCt', array('LAST'), "%4.0lf\\t");
$def[$num] .= rrd::line1 ('jThCt', $blue, 'Thread Count' );
$def[$num] .= rrd::gprint ('jThCt', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");
$def[$num] .= rrd::line3 ('jThDCt', $red, 'Thread Daemon Count' );
$def[$num] .= rrd::gprint ('jThDCt', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");
$def[$num] .= rrd::line3 ('jThPkCt', $purple, 'Thread Peak Count' );
$def[$num] .= rrd::gprint ('jThPkCt', array('LAST','MAX','AVERAGE'), "%4.0lf\\t");
$def[$num] .= rrd::line1 ('jThTlStCt', $teal );

++$num;
$ds_name[$num] = 'JVM Uptime';
$opt[$num] = "--title  \"$hostname - JVM Uptime\" ";
$def[$num] = rrd::def('jRTUpMs', $RRDFILE[1], $DS[98], 'AVERAGE');
$def[$num] .= rrd::cdef('jRTUpSec','jRTUpMs,1000,/');
$def[$num] .= rrd::area ('jRTUpSec', $huntergreen, 'Uptime' );
$def[$num] .= rrd::gprint ('jRTUpSec', array('LAST'), "%4.3lf %S\\t");


?>

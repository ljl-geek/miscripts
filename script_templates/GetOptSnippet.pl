#!/usr/bin/perl

$Version="1.0";

# get option snippet - gets opts, spits them back
# declare module
use Getopt::Long;

# declare vars
our($opt_h, $opt_V, $opt_v, @opt_a, $opt_t, $opt_w, $opt_c, $opt_D);

$opt_v = '';
$opt_D = '';

Getopt::Long::Configure("bundling");
$res=GetOptions(
"h"   => \$opt_h, "help"    => \$opt_h,
"V"   => \$opt_V, "VERSION"    => \$opt_V,
"v!"   => \$opt_v, "verbose!" => \$opt_v,
"a=s" => \@opt_a, "argument=s" => \@opt_a,
"t=i" => \$opt_t, "timeout=i" => \$opt_t,
"w=s" => \$opt_w, "warning=s" => \$opt_w,
"c=s" => \$opt_c, "critical=s" => \$opt_c,
"D!"   => \$opt_D, "Debug!" => \$opt_D
);

# Sanity checks
if ( ! $res ) {
        print "bad juju, no options\n";
        exit 3;
}

# print 'em
print "-V: $0 Version: $Version\n" if $opt_V;

print "-h: This just takes vars and spits them back\n" if $opt_h;

print "-v: Blah, blah, vlah, and more blah\n" if $opt_v;

print "-D: Print debugging items if Debug is there\n" if $opt_D;

 @opt_a = split(/,/,join(',',@opt_a)) if @opt_a;

print "-a: arguments are (".join(',',@opt_a).")\n" if @opt_a;

print "-w, -c: warning=$opt_w critical=$opt_c\n" if($opt_w && $opt_c);

exit 0;

1;


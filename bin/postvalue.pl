#!/usr/bin/perl
use strict;
use LWP::UserAgent;

my $macaddr = `./getmac.sh`;
# my $value = `./getenv.py`;
my $value = `./getsensor.py`;

my $ua = LWP::UserAgent->new;
my %param=(
	"ma"=>$macaddr,
	"val"=>$value
);
my $res=$ua->post("http://192.168.1.140/api/v1/saveValue.php",\%param);
print $res->as_string;


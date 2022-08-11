#!/usr/bin/perl
use strict;
use Getopt::Std;
use DBI;

my $dbhost='localhost';
my $dbport=3306;
my $dbname="sensordb";
my $dbuser="sensoradmin";
my $dbpass="sensor2289";
my $dsn = "DBI:mysql:database=$dbname;host=$dbhost;port=$dbport";

our( $opt_a, $opt_d, $opt_n, $opt_m );
getopts('adm:n:');

my $ctl=0;
if( defined $opt_a ){
  $ctl=1;
}elsif( defined $opt_d ){
  $ctl=2;
}else{
  usage();
  print "Operation type not found.\n";
  exit;
}
my $node="unknown";
if( defined $opt_a and !defined $opt_n ){
  usage();
  exit;
}
if( defined $opt_a and $opt_n !~ /^[a-zA-Z0-9]+$/ ){
  usage();
  exit;
}
my $node = $opt_n;

if( !defined $opt_m ){
  usage();
  print "MAC Address not found.\n";
  exit;
}
if( $opt_m !~ /^[a-fA-F0-9:]{17}$/ ){
  usage();
  print "MAC Address mismatch.\n";
  exit;
}
my $macaddr = lc $opt_m;

print "MAC Address : ". $macaddr ."\n";

#$dbh = DBI->connect($dsn, $user, $password);
#if( $ctl==1){
#  # Add node.
#  $sth = $dbh->prepare("insert into table01(user_id, nickname, ago) values(?, ?, ?)" );
#  $sth->execute('P004', 'sample4', 50);
#  $sth->finish();
#}elsif( $ctl==2 ){
#  # Delete node.
#  $sth = $dbh->prepare("insert into table01(user_id, nickname, ago) values(?, ?, ?)" );
#  $sth->execute('P004', 'sample4', 50);
#  $sth->finish();
#}
#$dbh->disconnect();

exit;

sub usage{
  print "$0 (-a | -d ) -m [macaddr]\n";
  print "    -a           : Add sensor node mac address(wlan0)\n";
  print "    -d           : Delete sensor node mac address(wlan0)\n";
  print "    -m [macaddr] : Connect MAC Address(IPv4) with ':'\n\n";
}

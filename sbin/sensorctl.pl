#!/usr/bin/perl
use strict;
use Getopt::Std;
use DBI;
use Config::Tiny;

my $config = Config::Tiny->read( 'sensorctl.ini' );

my $dbhost=$config->{sensordb}->{dbhost};
my $dbport=$config->{sensordb}->{dbport};

my $dbname=$config->{sensordb}->{dbname};
my $dbuser=$config->{sensordb}->{dbuser};
my $dbpass=$config->{sensordb}->{dbpass};
my $dsn = "DBI:mysql:database=$dbname;host=$dbhost;port=$dbport";

our( $opt_a, $opt_d, $opt_l, $opt_n, $opt_m );
getopts('adlm:n:');

my $ctl=0;
if( defined $opt_a ){
  $ctl=1;
}elsif( defined $opt_d ){
  $ctl=2;
}elsif( defined $opt_l ){
  $ctl=3;
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
my $macaddr = "00:00:00:00:00:00";
if( defined $opt_a or defined $opt_d ){
  if( !defined $opt_m or !defined $opt_l ){
    usage();
    print "MAC Address not found.\n";
    exit;
  }
  if( $opt_m !~ /^[a-fA-F0-9:]{17}$/ ){
    usage();
    print "MAC Address mismatch.\n";
    exit;
  }
  $macaddr = lc $opt_m;
  print "MAC Address : ". $macaddr ."\n";
}

my $dbh = DBI->connect($dsn, $dbuser, $dbpass );
if( $ctl==1){
  # Add node.
  my $sth = $dbh->prepare("Insert into Node(nid,uid,nodename,macaddr,effectivedate,idstatus) values ('0', '1', ?, ?, now(), '1')" );
  $sth->execute( $node, $macaddr );
  $sth->finish();
}elsif( $ctl==2 ){
  # Delete node.
  my $sth = $dbh->prepare("Delete from Node Where macaddr=? and nid != 0");
  $sth->execute( $macaddr );
  $sth->finish();
}elsif( $ctl==3 ){
  # List node
  my $sth = $dbh->prepare("Select nodename as Nodename, macaddr as MACaddress from Node where idstatus='1'");
  $sth->execute();
  while(my $ref = $sth->fetchrow_arrayref ){
    my( $nodename, $macaddr ) = @$ref;
    print "$macaddr \t : $nodename\n";
  }
  $sth->finish();
}
$dbh->disconnect();

exit;

sub usage{
  print "$0 (-a | -d ) -m [macaddr]\n";
  print "    -a            : Add sensor node mac address(wlan0)\n";
  print "    -d            : Delete sensor node mac address(wlan0)\n";
  print "    -l            : List Node\n";
  print "    -n [nodename] : Node name ( -a )\n\n";
  print "    -m [macaddr]  : Connect MAC Address(IPv4) with ':'\n\n";
}

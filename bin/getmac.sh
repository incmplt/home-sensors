#!/bin/bash

ip addr show | awk '
BEGIN{
	getmac = ""
}

{
	if ($2 == "wlan0:") 
	{
		getmac = "wlan0"
#		print $0
	}
else if ((getmac == "wlan0") && ($1 == "link/ether"))
	{
#		print $0
		macaddr = $2
#		print macaddr
		getmac = ""
		exit
	}
}

END {
	print macaddr
}
'


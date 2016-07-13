**unRAID DVB Edition**

This plugin from linuxserver.io allows you to easily install a modified unRAID version with DVB drivers compiled.  
Remember to add --device=/dev/dvb to the extra parameters in the Satip/MythTV/TVHeadEnd docker.

There are four versions available:  
		LibreELEC for most DVB cards.  
		TBS for TBS DVB-S/T(2) cards.
		TBS DVB-C for TBS DVB-C cards
		Digital Devices Github for Digital Devices cards.
		
Once installed you can then use the Satip Docker, MythTV Docker or a TVHeadEnd docker/plugin to use unRAID as a PVR backend.

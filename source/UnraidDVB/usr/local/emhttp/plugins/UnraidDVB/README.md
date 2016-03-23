**unRAID DVB**

This plugin from linuxserver.io allows you to easily install a modified unRAID version with DVB drivers compiled.  
Remember to add --device=/dev/dvb to the extra parameters in the MythTV/TVHeadEnd docker.

There are three versions available:  
		OpenElec for most DVB cards.  
		TBS for TBS cards.                                   
		Digital Devices Experimental for Digital Devices cards.
		
Once installed you can then use the MythTV Docker or a TVHeadEnd docker/plugin to use unRAID as a PVR backend.

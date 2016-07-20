![https://linuxserver.io](https://www.linuxserver.io/wp-content/uploads/2015/06/linuxserver_medium.png)

The [LinuxServer.io](https://linuxserver.io) team brings you an unRAID plugin release enabling you to easily turn you unRAID server into a PVR. 

Find us for support at:
* [forum.linuxserver.io](https://forum.linuxserver.io)
* [IRC](https://www.linuxserver.io/index.php/irc/) on freenode at `#linuxserver.io`
* [Podcast](https://www.linuxserver.io/index.php/category/podcast/) covers everything to do with getting the most from your Linux Server plus a focus on all things Docker and containerisation!


**unRAID DVB Edition**

This plugin from linuxserver.io allows you to easily install a modified unRAID version with DVB drivers compiled.  
Remember to add --device=/dev/dvb to the extra parameters in the MythTV/TVHeadEnd docker.(Already present for Sat-ip)

There are four versions available:  
		LibreELEC for most DVB cards.  
		TBS for TBS DVB-S/T(2) cards.  
		TBS DVB-C for TBS DVB-C cards.  
		Digital Devices Github for Digital Devices cards.  
		
Once installed you can then use the Sat-ip Docker, MythTV Docker or a TVHeadEnd docker/plugin to use unRAID as a PVR backend.

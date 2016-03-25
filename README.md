![https://linuxserver.io](https://www.linuxserver.io/wp-content/uploads/2015/06/linuxserver_medium.png)

The [LinuxServer.io](https://linuxserver.io) team brings you an unRAID plugin release enabling you to easily turn you unRAID server into a PVR. 

Find us for support at:
* [forum.linuxserver.io](https://forum.linuxserver.io)
* [IRC](https://www.linuxserver.io/index.php/irc/) on freenode at `#linuxserver.io`
* [Podcast](https://www.linuxserver.io/index.php/category/podcast/) covers everything to do with getting the most from your Linux Server plus a focus on all things Docker and containerisation!


**unRAID DVB**

This plugin allows you to easily install a modified unRAID version with DVB drivers compiled.  
Remember to add --device=/dev/dvb to the extra parameters in the MythTV/TVHeadEnd docker.

There are three versions available:  
		OpenElec for most DVB cards.  
		TBS for TBS cards.                                   
		Digital Devices Experimental for Digital Devices cards.
		
Once installed you can then use the MythTV Docker or a TVHeadEnd docker/plugin to use unRAID as a PVR backend.

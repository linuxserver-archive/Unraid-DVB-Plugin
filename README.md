![https://linuxserver.io](https://raw.githubusercontent.com/linuxserver/docker-templates/master/linuxserver.io/img/linuxserver_medium.png)

The [LinuxServer.io](https://linuxserver.io) team brings you an unRAID plugin release enabling you to easily turn you unRAID server into a PVR. 

Find us for support at:
* [forum.linuxserver.io](https://forum.linuxserver.io)
* [IRC](https://www.linuxserver.io/irc/) on freenode at `#linuxserver.io`
* [Podcast](https://www.linuxserver.io/podcast/) covers everything to do with getting the most from your Linux Server plus a focus on all things Docker and containerisation!


**unRAID DVB Edition**

This plugin from linuxserver.io allows you to easily install a modified unRAID version with DVB drivers compiled.  
Remember to add `--device=/dev/dvb` to the extra parameters in the MythTV/TVHeadEnd docker.  (Already present for minisatip)

There are three versions available:  
* LibreELEC for most DVB cards.  
* TBS Opensource drivers for TBS cards with extra firmware from LibreELEC.
* TBS CrazyCat drivers for TBS cards with extra firmware.
		
Once installed you can then use the Sat-IP Docker, MythTV Docker or a TVHeadEnd docker/plugin to use unRAID as a PVR backend.

Borhan Media Server   
==========================
---
This project is a wrapper for media streaming servers that integrates to streaming servers with the [Borhan Server](https://github.com/borhan/server). 
The Borhan Media Server is an application built to run over the Streaming Engines (such as Wowza, AMS, Harmonic, Elemental, Red5, custom etc.) infrastructure. Currently the most deeply integrated engine is Wowza, it is compiled with a Borhan Java client, allowing it access to the Borhan API. The application utilizes the WSE dynamic streaming capabilities, combined with the Borhan API for purposes of authentication and tracking.  
By default, the Borhan Streaming application is called **kLive**.
---

Borhan API Integration
---
---
**API Usage**  
The Borhan media server can use API client in one of two configurable ways:
1.	Opposite built-in partner (-5), which impersonates the handled partner for all API calls.
2.	As an eCDN installation- in this case the streaming server (e.g. Wowza) is installed on the client's machine while the partner continues working opposite the SaaS installation (as opposed to on-prem installations). The streaming server thus installed works only opposite the partnerId it belongs to and does not use impersonation.  
The KS is regenerated periodically according to the KS expiry time.  

---

**Broadcast URL**  
Example URL to kLive application: rtmp://domain/kLive/?p=102&e=0_rkij47dr&i=0&t=dj94kfit  
The broadcast URL consists of the following arguments:
*	p – partner id.
*	e – entry id.
*	i – index (0 for primary and 1 for backup).
*	t – token.

Stream name example: 0_rkij47dr_1  
The stream name consists of entry id, underscore and stream index (between 1 to 3).
The stream index could be used for multiple bitrate streams ingestion, if only one bitrate is streamed the index should be 1.  

---

**Integration points**  
* Connection – **liveStream.authenticate** action is called to validate the entry id with the supplied token.
The action should return a BorhanLiveStreamEntry object, or an exception in case the authentication failed.
The returned entry object could be used later to determine if DVR and recording are enabled for this entry.
* Publish – **liveStream.registerMediaServer** action is called to inform the server that this entry is live.
This API call is repeated every 60 seconds, otherwise a server-side batch process will remove the flag and mark the entry as non-live.
* Transcoding - **wowza_liveStreamConversionProfile.serve** is called for each published entry. This action returns an XML formatted according to the Wowza required structure, indicating the transcoding that the stream should undergo.
* Unpublish – **liveStream.unregisterMediaServer** action is called to inform the server that this entry is not live anymore.
* Recorded segment end – **liveStream.appendRecording** action is called to ingest the recorded media file.
*  Server status report- the SaaS Wowza servers are logged as entries into the DB, and periodically report their status using the mediaServer.reportStatus action.

----

**Configuration**  
* DVR – set BorhanLiveStreamEntry::dvrStatus to determine if DVR should be enabled for the live stream, and use BorhanLiveStreamEntry::dvrWindow to get/set the configured DVR duration in minutes.
* Recording – set KallturaLiveStreamEntry::recordStatus to determine if VOD recording should be enabled.
* Transcoding – set BorhanLiveStreamEntry::conversionProfileId. The required flavors are fetched using conversionProfileAssetParams.list and flavorParams.getByConversionProfileId actions.

--

Media Server Installation
--

Instructions to install a Wowza SaaS server can be found here:
https://github.com/borhan/media-server/blob/3.0.8/Installation.md

Media Server Build Instructions
--

**Gradle Installation**

* Install Gradle: http://gradle.org/installation
* Invoke the task: **gradle wrapper**. This task will download the suitable Gradle wrapper to your project. Read more at: https://gradle.org/docs/current/userguide/gradle_wrapper.html

**IntelliJ Integration**

IntelliJ users can skip the installation and import the gradle project with IntelliJ (choose "Use customizable gradle wrapper"). IntelliJ will automatically download the Gradle wrapper.


**Building The Project**

* In gradle.properties, set the path to Wowza home directory
* Use the following tasks
  * **gradle build** compiles the code, builds artifacts and copy them to Wowza lib directory
  * **gradle prepareRelease** builds the distribution (a zip archive with all needed jars)
  * **gradle release -Dusername=your_git_username -Dpassword=your_git_password** prepares the release and uploads it to github
* If you're using the gradle wrapper use **gradlew** instead of **gradle**
* IntelliJ/Eclipse uses are advised to build from the IDE and not from command line
* Mac and Linux users:
  * The task copyJarsToWowzaLibDir will fail if you don't have permissions to write to Wowza home directory
  
## Commercial Editions and Paid Support

The Open Source Borhan Platform is provided under the [AGPLv3 license](http://www.gnu.org/licenses/agpl-3.0.html) and with no
commercial support or liability.  

[Borhan Inc.](http://corp.borhan.com) also provides commercial solutions and services including pro-active platform monitoring,
applications, SLA, 24/7 support and professional services. If you're looking for a commercially supported video platform  with
integrations to commercial encoders, streaming servers, eCDN, DRM and more - Start a [Free Trial of the Borhan.com Hosted
Platform](http://corp.borhan.com/free-trial) or learn more about [Borhan' Commercial OnPrem
Edition™](http://corp.borhan.com/Deployment-Options/Borhan-On-Prem-Edition). For existing RPM based users, Borhan offers
commercial upgrade options.


## License and Copyright Information
All code in this project is released under the [AGPLv3 license](http://www.gnu.org/licenses/agpl-3.0.html) unless a different license for a particular library is specified in the applicable library path. 

Copyright © Borhan Inc. All rights reserved.


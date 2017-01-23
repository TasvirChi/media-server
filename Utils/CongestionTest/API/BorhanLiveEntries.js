var $q = require('q');
var request = require('request');
var config = require('config');
var _ = require('underscore');
var url= require('url');
var borhanAPI=require('./BorhanAPI.js').BorhanAPI;


function BorhanLiveEntries() {

}
/**
 *
 * @param liveValue
 */
BorhanLiveEntries.prototype.getEntries=function(liveValue){

    var obj={
        service: "liveStream",
        action: "list",
        "filter:orderBy": "-createdAt",

    };

    if (liveValue!==undefined) {
        obj["filter:isLive"]=liveValue;
    }
    return borhanAPI.call(obj).then(function (res) {
        return $q.resolve(res.objects);
    }, function (error) {
        return $q.reject(error);
    });
}

/**
 *
 * @param liveValue
 */
BorhanLiveEntries.prototype.getEntry=function(entryId , serverIndex){

    var obj={
        serverIndex : serverIndex,
        service: "liveStream",
        action: "list",
        "filter:idEqual": entryId

    };

    return borhanAPI.call(obj).then(function (res) {
        return $q.resolve(res.objects[0]);
    }, function (error) {
        return $q.reject(error);
    });
}

BorhanLiveEntries.prototype.createEntry=function(name,description,conversionProfileId,recording,dvr){
    return borhanAPI.call({
        service: "liveStream",
        action: "add",
        "liveStreamEntry:objectType": "BorhanLiveStreamEntry",
        "sourceType": "32",
        "liveStreamEntry:name": name,
        "liveStreamEntry:description": description,
        "liveStreamEntry:conversionProfileId": conversionProfileId,
        "liveStreamEntry:recordStatus": recording ? 1 : 0,
        "liveStreamEntry:dvrStatus": dvr ? 1 : 0,
        "liveStreamEntry:dvrWindow": 120,
        "liveStreamEntry:mediaType": 201
    }).then(function (res) {
        return $q.resolve(res);
    }, function (error) {
        return $q.reject(error);
    });
}

BorhanLiveEntries.prototype.deleteEntry=function(id){
    return borhanAPI.call({
        service: "liveStream",
        action: "delete",
        "entryId": id
    }).then(function (res) {
        return $q.resolve(res);
    }, function (error) {
        return $q.reject(error);
    });
}

BorhanLiveEntries.prototype.getConversionProfiles=function(){
    return borhanAPI.call({  service: "conversionProfile",
        "filter:typeEqual": 2,
        action: "list"}).then(function (res) {
        return $q.resolve(res.objects);
    }, function (error) {
        return $q.reject(error);
    });
}


BorhanLiveEntries.prototype.getBroadcastingUrls=function(){

    return this.getEntries().then(function(res) {
        return $q.resolve(_.map(res,function(entry) { return entry.primaryBroadcastingUrl+"/"+entry.streamName; }));
    });
}




BorhanLiveEntries.prototype.parseMasterM3U8=function(logger,masterUrl,failOnError) {
    return $q.Promise( function(resolve,reject) {
        request.get({
            url: masterUrl,
            followAllRedirects: true
        }, function (error, response, result) {

            logger.debug("parseMasterM3U8: Got response from",masterUrl,":",result);

            var re = /BANDWIDTH=([\d.]*)(?:,RESOLUTION=([\d]*))?.*\n(.*.m3u8)/gm;

            var res = [];
            var m;

            while ((m = re.exec(result)) !== null) {
                if (m.index === re.lastIndex) {
                    re.lastIndex++;
                }

                res.push({
                    bitrate: m[1],
                    resolution: m[2],
                    m3u8: url.resolve(response.request.href, m[3])
                });
            }

            if (failOnError && (error || response.statusCode!==200 || res.length==0)) {
                reject("Empty master manifest");
            } else {
                resolve(res);
            }
        });
    });
}


BorhanLiveEntries.prototype.parseChunkListM3U8=function(logger,chunksUrl) {
    return $q.Promise( function(resolve,reject) {
        request.get({
            url: chunksUrl
        }, function (error, response, result) {

            try {
                logger.debug("Got response from",chunksUrl,":",result);
                var re = /EXTINF:([\d.]*),\n(.*.ts)/gm;

                var res = [];
                var m;

                while ((m = re.exec(result)) !== null) {
                    if (m.index === re.lastIndex) {
                        re.lastIndex++;
                    }

                    res.push({
                        duration: parseFloat(m[1]),
                        ts: url.resolve(chunksUrl, m[2])
                    });
                }


                resolve(res);
            } catch(err) {
                reject(err);
            }
        });
    });
}

BorhanLiveEntries.prototype.getTS=function(chunkUrl) {
    return $q.Promise( function(resolve,reject) {
        request.head({
            url: chunkUrl
        }, function (error, response, result) {
            if (error || response.statusCode!==200 ||
                parseInt(response.headers["content-length"])===0) {
                reject(error);
                return;
            }
            resolve(true);
        });
    });
}
var ks=module.exports.BorhanLiveEntries=new BorhanLiveEntries();
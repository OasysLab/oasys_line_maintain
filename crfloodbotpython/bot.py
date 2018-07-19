import time
import datetime
import json
import urllib2
from pymongo import MongoClient
client = MongoClient('mongodb://qqbot:qqbot123@ds247410.mlab.com:47410/qqbot')
db = client.get_database("qqbot")
col = db.crfloodmornitor
def pushRECORD(record):
    col.insert_one(record)
def updateRecord(updates):
    col.update_one({'id': "1"},{'$set': updates}, upsert=False)
def getRECORD(id):
    records = col.find_one({"id":id})
    return records
while(True):
    print("CheckData At "+str(datetime.datetime.now()))
    data = json.load(urllib2.urlopen("http://128.199.91.90/crflood/van/backupwebcrf/scripts/jsonfile/get-by-station-noti.php"))
    data_old = getRECORD("1")['data']
    try:
        for i in range(len(data_old)):
            if(data[i]['mode']!=data_old[i]['mode']):
                masg = "station : "+str(data[i]['station_id'])+" change mode from "+str(data_old[i]['mode'])+" to "+str(data[i]['mode'])
                print(masg)
                urllib2.urlopen("http://128.199.91.90/crflood/boat/maintain_botpush/botpush.php?stationid="+str(data[i]['station_name'])+"&modeold="+str(data_old[i]['mode'])+"&modenew="+str(data[i]['mode']))
    except:
        print("new data")
    if(data !=""):
        dicdata = {"id":"1","date":str(datetime.datetime.now()),"data":data}
        updateRecord(dicdata)
    time.sleep(300)


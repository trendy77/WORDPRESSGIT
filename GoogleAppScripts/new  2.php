var ORGBIZ = 1;
var FAKENEWS = 0;
var CATEGORYSLUG = '#contentFeed';

var EMAIL_SENT = "EMAIL_SENT";
var DUP = "DUP_CHECKED";
var NUM_SENT = 0;
// need to set orgbiz or fakeNews variable for html output!
var ss = SpreadsheetApp.getActiveSpreadsheet(); 
var sheet = SpreadsheetApp.getActiveSheet();
  var data = sheet.getDataRange().getValues();            
var newData = new Array();                           
var dataSheet = ss.getSheets()[0]; 
  var dataRange = ss.getRange(2, 1, ss.getMaxRows() - 1, 7);
  var objects = getRowsData(ss.dataRange);   // For every row object, create a personalized email

function dupCheck(){
  for(i in data){
    var row = data[i];
    var duplicate = false;                             //      for loop iterates over each row in the data 2-dimensional array. 
    for(j in newData){                       //     For each row, the second loop tests if another row with matching data already exists in 
      if(row[0] == newData[j][0]){
  duplicate = true;
}
    }  
    if(!duplicate){
      newData.push(row);
     }
	 }
  sheet.clearContents();                            //      the script deletes the existing content of the sheet and inserts the content of the newData array.
  sheet.getRange(1, 1, newData.length, newData[0].length).setValues(newData);
  	  var runDup = sheet.getRange(2, 8, i).setValue(DUP); 
SpreadsheetApp.flush(); 
  }

function send10Emails(){
  for (var i = 0; i < objects.length; ++i) {
 var rowData = objects[i];   
 //var emailAddress = 'autopost@organisemybiz.com';
   // var row = data[i];
var title = rowData[0];
 var desc = rowData[1];
  var articleUrl = rowData[2];
   var categories = rowData[3];
    var sourceTitle = rowData[4];
      var sourceUrl = rowData[5];
       var image = rowData[6]; 
        var dupcheck =rowData[7];
         var emailSent = rowData[8];      
    if (emailSent != EMAIL_SENT) {
     
//	 if (image != null){
Logger.log("rowData[1]");  Logger.log(rowData[1]);   
 
 var data = {
				value1: rowData[0],
                value2: rowData[1],
				value3: rowData[2]
			}
  
  var payload= (JSON.stringify(data));
        Logger.log("data JSON:");
 Logger.log(data);
Logger.log("data JSONed is:");
 Logger.log(payload);
triggerContentfeed(payload);
	} else {
 var data = {
				value1: rowData[1],
                value2: rowData[2],
				value3: rowData[3]
			};
 var payload= JSON.stringify(data);
            Logger.log("data JSON:");
 Logger.log(data);
Logger.log("data JSONed is:");
 Logger.log(payload);
triggerContentfeed(payload);
    }
}
}

function triggerContentfeed(payload){
 var url = "https://maker.ifttt.com/trigger/contentfeed/with/key/bOUQFldukbvX4Zosu-wsmT";
 var options = {
    'method': 'post',
    'payload': payload
            };
Logger.log(options);
  //var request =  UrlFetchApp.fetch(url,options);
//Logger.log(request);
  
  }


  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  /* });
    }else{
    MailApp.sendEmail({
     to: emailAddress,
     subject: emailSubject,
     htmlBody: embed+emailText,
     attachments:
       {
         imageThumb: imageBlob,
         }
   });
 }
  */
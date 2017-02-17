var emailtoPost = "yija387veko@post.wordpress.com";
	
function dupCheck(){
   var ss = SpreadsheetApp.getActiveSpreadsheet();
 var sheet = ss.getSheets()[0];
   var data = sheet.getDataRange().getValues();            //we do a single call to the spreadsheet to retrieve all the data.
  var newData = new Array();                           // newData is an empty array where we will put all rows which are not duplicates.
  for(i in data){
    var row = data[i];    var duplicate = false;                             //      for loop iterates over each row in the data 2-dimensional array. 
    for(j in newData){                                 //     For each row, the second loop tests if another row with matching data already exists in 
  if(row[0] == newData[j][0] || row[1] == newData[j][1]){
  duplicate = true;
}
    }
    if(!duplicate){
      newData.push(row);
      }
  }
  sheet.clearContents();                            //      the script deletes the existing content of the sheet and inserts the content of the newData array.
 sheet.getRange(1, 1, newData.length, newData[0].length).setValues(newData);
  if (data.length != newData.length){
 var l= sheet.getRange("A1");l.setValue("old length: ");l= sheet.getRange("B1");l.setValue(data.length);
l= sheet.getRange("C1");l.setValue("new length: ");l= sheet.getRange("D1");l.setValue(newData.length);  
  }
SpreadsheetApp.flush();
}

function sendxml(){
var ss = SpreadsheetApp.getActiveSpreadsheet();
var sheet = ss.getSheetByName("Sheet1");
 var range = sheet.getRange(2, 1, 1, 7); var data = range.getValues();
for (var i = 0; i < data.length; i++){ 
  var rowData = data[i];
  var post_title = rowData[0]
  var desc = rowData[1];
  var articleUrl = rowData[2];
  var category = rowData[3]    // category
  var sourceTitle= rowData[4];
  var image = rowData[5];
           //DATA 6 IS CREATED TIME & DATE  //DATA 7 IS PERSONAL BOARDS  //DATA 8 IS TEAM BOARDS  //DATA 9 IS FIRST HIGHLIGHTS?
  var post_excerpt = "New article posted by " + sourceTitle + " entitled: " + post_title + "... Read it here on the Custom Kits Worldwide Blog.";
if (!desc){
  desc = "[embedlyt] "+articleUrl+" [/embedlyt]";
} else {
  var html = ('<!DOCTYPE html><html><head><base target="_top"><meta charset="UTF-8"><title>' + post_title + '</title></head><body>' + desc + '<a href="http://adf.ly/15466373/' + articleUrl + '">Read Original Article HERE</a><br></body></html><br><a href="http://customkitsworldwide.com/contentfeed">View More #contentFeed HERE</a><br><a href="http://customkitsworldwide.com/tag/' +sourceTitle+ '">View More' + sourceTitle + ' HERE</a><br></body></html>');
  var post_content = html;   
}
  if (image){
  var imageSet = "[embed width='123' height='456']" + image + "[/embed]";
 try {
   var fileBlob = image.getBlob();
  var payload = {
    'title'       : post_title,
    'post_content': post_content,
    'post_excerpt': post_excerpt,
     'fileAttachment': fileBlob
  };
  } catch(e) { 
    var payload = {
    'title'       : post_title,
    'post_content': post_content,
    'post_excerpt': post_excerpt,
    };   
    
  }     //var payload= (JSON.stringify(stuff));    
} else {
 var payload = {
    'title'       : post_title,
    'post_content': post_content,
    'post_excerpt': post_excerpt,
     'fileAttachment': fileBlob
     };
  }
  var options = {
        'method' : 'post',
      'payload' : payload
            };   
  var url="http://customkitsworldwide.com/t/why.php";
var response = UrlFetchApp.fetch(url, options);
 Logger.log(response);
var destination = ss.getSheetByName("Sheet2");
  ezTranslate(post_title, post_content, post_excerpt);  
destination.appendRow([rowData[0], response]);
//SpreadsheetApp.flush();
    sheet.deleteRow(2); 
}
}
  
function ezTranslate(post_title, post_content, post_excerpt) {
var spanishHtml = LanguageApp.translate(post_content,'en', 'es', {contentType: 'html'});
var spanishTit = LanguageApp.translate(post_title, 'en', 'es', {contentType: 'text'});
var spanishExc = LanguageApp.translate(post_excerpt, 'en', 'es', {contentType: 'text'});
var ss =  SpreadsheetApp.getActiveSpreadsheet();
var espSheet =ss.getSheetByName("Sheet3");
espSheet.appendRow([spanishTit, spanishHtml, spanishExc]);
    var stuffio = { 
   'post_title': spanishTit,
    'post_content': spanishHtml,
   };
 var esPayload= (JSON.stringify(stuffio));    
 var eLoptions = {
    'method': 'POST',
   'payload': esPayload,
     "muteHttpExceptions": true
    };   
  var elUrl = "http://customkitsworldwide.com/es/new2.php";
  var rethponse = UrlFetchApp.fetch(elUrl, eLoptions);
 
  var destination = ss.getSheetByName("Sheet2");
  var spot = destination.getRange("C2");
  spot.copyValuesToCell(rethponse);
}

// GOOGLE APP SCRIPT TO PARSE SPREADSHEET LINES...
// TAKE INFO AND ... POST ... ? TO IFTTT AND WORDPRESS BLOG... 


function createSpreadsheetEditTrigger() {
  var ss = SpreadsheetApp.openById();
  ScriptApp.newTrigger('logArticleInfo')
      .forSpreadsheet(sheet)
      .onOpen()
      .create();
}


function logArticleInfo() {
  var sheet = SpreadsheetApp.getActiveSheet();
  var data = sheet.getDataRange().getValues();
  for (var i = 0; i < data.length; i++) {
    for (var j = 0; j < data.length[i]; j++) {
	Logger.log('Article Title: ' + data[i][1]);
	Logger.log('Article Content: ' + data[i][2]);
    Logger.log('Article URL: ' + data[i][3]);
	Logger.log('Article Categories: ' + data[i][5]);
	Logger.log('Source Title: ' + data[i][6]);
    Logger.log('SourceURL: ' + data[i][7]);
	Logger.log('ArticleFirstImageURL: ' + data[i][10]);
  }
}

function respondToFormSubmit(e) {
  var addonTitle = 'My Add-on Title';
  var props = PropertiesService.getDocumentProperties();
  var authInfo = ScriptApp.getAuthorizationInfo(ScriptApp.AuthMode.FULL);
  // Check if the actions of the trigger requires authorization that has not
  // been granted yet; if so, warn the user via email. This check is required
  // when using triggers with add-ons to maintain functional triggers.
  if (authInfo.getAuthorizationStatus() ==
      ScriptApp.AuthorizationStatus.REQUIRED) {
    // Re-authorization is required. In this case, the user needs to be alerted
    // that they need to re-authorize; the normal trigger action is not
    // conducted, since it requires authorization first. Send at most one
    // "Authorization Required" email per day to avoid spamming users.
    var lastAuthEmailDate = props.getProperty('lastAuthEmailDate');
    var today = new Date().toDateString();
    if (lastAuthEmailDate != today) {
      if (MailApp.getRemainingDailyQuota() > 0) {
        var html = HtmlService.createTemplateFromFile('AuthorizationEmail');
        html.url = authInfo.getAuthorizationUrl();
        html.addonTitle = addonTitle;
        var message = html.evaluate();
        MailApp.sendEmail(Session.getEffectiveUser().getEmail(),
            'Authorization Required',
            message.getContent(), {
                name: addonTitle,
                htmlBody: message.getContent()
            }
        );
      }
      props.setProperty('lastAuthEmailDate', today);
    }
  } else {
    // Authorization has been granted, so continue to respond to the trigger.
    // Main trigger logic here.
  }
}








"<!DOCTYPE html>
<html>
<head>
<base target=""_top"">
<meta charset=""UTF-8"">
<title><? rowData[0] ?> </title>
</head>
<body>
<? if (image != null) { ?>     // IF THERE IS A URL IMAGE LINK
//!! THEN ADD ATTACHEMENT OR REFERENCE TO THUMBNAIL HERE
 <?! var 'post_thumbnail' = image; ?>
<? } if ((rowData != '') && (rowData != null )) { ?>   // IF THERE'S BODY, PRINT IT, ELSE IF IT'S NOT THERE THEN PRINT THE (HOPEFULLY) EMBEDDED URL
<?! rowData[1] ?> <br>
<? } else { ?>                  // THEN IT'S PROB EMPTY...
<?! rowData[2] ?> <br> 
<a href="http://adf.ly/1546637/<?! rowData[4] ?>"">View original HERE</a>

// choose your site... & category slug

<? if (ORGBIZ == 1) { ?>    // ** USE ORG BIZ LINKS
<a href=""http://organisemybiz.com/<?!CATEGORYSLUG?>"">View More <?!CATEGORYSLUG ?>HERE</a>
<br><a href=""http://organisemybiz.com/tag/<?!rowData[5]?>"">View More <?!rowData[6]?> HERE</a><br>
<br><a href=""http://adf.ly/15466373/<?!rowData[4]?>"">Original HERE via<?!rowData[5]?></a><br>

<? } else if (FAKENEWS == 1){ ?>
<a href=""http://fakenewsregistry.org/<?!CATEGORYSLUG?>"">View More <?!CATEGORYSLUG ?> HERE</a><br>
<a href=""http://adf.ly/15466373/http://fakenewsregistry.org/tag/<?!rowData[5]?>"">View More <?!rowData[6]?>HERE</a><br>
<br><a href=""http://adf.ly/15466373/<?!rowData[4]?>"">Original HERE via<?!rowData[5]?> </a><br>
<?! } ?>
</body>
</html>

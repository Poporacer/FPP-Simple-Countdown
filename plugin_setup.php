<?php


include_once "/opt/fpp/www/common.php";
include_once 'functions.inc.php';
include_once 'version.inc';

$pluginName = basename(dirname(__FILE__));


$logFile = $settings['logDirectory']."/".$pluginName.".log";

$showScrollDiv="display:none";
if (isset($pluginSettings['SCROLL_SPEED'])){
	$scrollSpeed= $pluginSettings['SCROLL_SPEED'];
	if ($scrollSpeed==0){
		$showScrollDiv	="display:block";
	}else{
		$showScrollDiv ="display:none";
	}
	
}

$showCountUpDiv="display:none";
$showCompleteDiv= "display:block";
if (isset($pluginSettings['COUNT_UP'])){
	$countUp= $pluginSettings['COUNT_UP'];
	if ($countUp=="ON"){
		$showCountUpDiv	="display:block";
		$showCompleteDiv= "display:none";
	}else{
		$showCountUpDiv ="display:none";
	}
	
}

$gitURL = "https://github.com/FalconChristmas/FPP-Simple-Countdown.git";


?>

<html>
<head>
<style>
.matrix-tool-bottom-panel {
	padding-top: 0px !important;
}

.red {
	background: #ff0000;
}

.green {
	background: #00ff00;
}

.blue {
	background: #0000ff;
}

.white {
	background: #ffffff;
}

.black {
	background: #000000;
}

.colorButton {
	-moz-transition: border-color 250ms ease-in-out 0s;
	background-clip: padding-box;
	border: 2px solid rgba(0, 0, 0, 0.25);
	border-radius: 50% 50% 50% 50%;
	cursor: pointer;
	display: inline-block;
	height: 20px;
	margin: 1px 2px;
	width: 20px;
}

#currentColor {
    border: 2px solid #000000;
}
#scroll-container {
  border: 3px solid black;
  border-radius: 5px;
  overflow: hidden;
}

#scroll-text {
	
	font-weight: bold; 
	font-size: 30px;
	
  /* animation properties */
  -moz-transform: translateX(100%);
  -webkit-transform: translateX(100%);
  transform: translateX(100%);
  
  -moz-animation: my-animation 15s linear infinite;
  -webkit-animation: my-animation 15s linear infinite;
  animation: my-animation 15s linear infinite;
}

/* for Firefox */
@-moz-keyframes my-animation {
  from { -moz-transform: translateX(100%); }
  to { -moz-transform: translateX(-100%); }
}

/* for Chrome */
@-webkit-keyframes my-animation {
  from { -webkit-transform: translateX(100%); }
  to { -webkit-transform: translateX(-100%); }
}

@keyframes my-animation {
  from {
    -moz-transform: translateX(100%);
    -webkit-transform: translateX(100%);
    transform: translateX(100%);
  }
  to {
    -moz-transform: translateX(-50%);
    -webkit-transform: translateX(-50%);
    transform: translateX(-50%);
  }
}

</style>
<script type="text/javascript">

    function ShowColorPicker() {
		if ($('#ShowColorPicker').is(':checked')) {
            $('#colpicker').show();
        } else {
            $('#colpicker').hide();
        }
    }

	function setColor(color, updateColpicker = true) {
		if (color.substring(0,1) != '#')
			color = '#' + color;

        pluginSettings['COLOR'] = color;
        SetPluginSetting('<?php echo $pluginName; ?>', 'COLOR', color, 0, 0);
        $('#currentColor').css('background-color', color);

		currentColor = color;

        if (updateColpicker)
		    $('#colpicker').colpickSetColor(color);
		
	}

</script>

</head>

    	<div id="EventDate" class="settings">
			<fieldset>
				<legend><?php echo $pluginName . " Version: ". $pluginVersion;?> Installation Instructions</legend>
				<p><b>This plugin requires ACCURATE date and time for its calculation.</b></p>
				Configuration:
				<ul>
				<li>Configure the date and time of your event</li>
				<li>Enter in the Pre Text and Post Text that will appear in your countdown</li>
				<li>Enter the name of your Target date</li>
				<li>Make sure you have your Pixel Overlay Model Selected (usually your Matrix)</li>
				<li>The Countdown will display immediatly when activated by an FPP Command or Command Preset</li>
				<li>If the remaining time is less than a day, the plugin will automatically display the hours and minutes remaining.</li>
				<li>You can configure the plugin to display a message once the target date/time has been reached or</li>
				<li>have the plugin start counting up from the target date/time.
				</ul>
			</fieldset>
		</div>
	<div>
		
		<p>Target Date: <? PrintSettingSelect("MONTH", "MONTH", 0, 0, $defaultValue= "1", getMonths(), $pluginName, $callbackName = "updateOutputText", $changedFunction = ""); ?> 
		<? PrintSettingSelect("DAY", "DAY", 0, 0, $defaultValue= "1", getDaysOfMonth(), $pluginName, $callbackName = "updateOutputText", $changedFunction = ""); ?>
		<? PrintSettingSelect("YEAR", "YEAR", 0, 0, $defaultValue= date("Y")+1, getYears(), $pluginName, $callbackName = "updateOutputText", $changedFunction = ""); ?>
		Hour: <? PrintSettingSelect("HOUR", "HOUR", 0, 0, $defaultValue= "0", getHours(), $pluginName, $callbackName = "updateOutputText", $changedFunction = ""); ?>
		Min: <? PrintSettingSelect("MIN", "MIN", 0, 0, $defaultValue= "0", getMinutes(), $pluginName, $callbackName = "updateOutputText", $changedFunction = ""); ?></p>
		<p>Pre Text: <?  PrintSettingTextSaved("PRE_TEXT", 0, 0, $maxlength = 32, $size = 32, $pluginName, $defaultValue = "It is", $callbackName = "updateOutputText", $changedFunction = "", $inputType = "text", $sData = array());?> </p>
		<p>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbspxx days xx hours</p>
		<p>Post Text <?  PrintSettingTextSaved("POST_TEXT", 0, 0, $maxlength = 32, $size = 32, $pluginName, $defaultValue = "until", $callbackName = "updateOutputText", $changedFunction = "", $inputType = "text", $sData = array());?> </p>
		<p>Target Title: <?  PrintSettingTextSaved("EVENT_NAME", 0, 0, $maxlength = 32, $size = 32, $pluginName, $defaultValue = "The Event!", $callbackName = "updateOutputText", $changedFunction = "", $inputType = "text", $sData = array());?> </p>
		<div id ="showCompleted" style= "<? echo $showCompleteDiv; ?>">
			<p>Countdown Completed Text: <?  PrintSettingTextSaved("COMPLETED_MESSAGE", 0, 0, $maxlength = 32, $size = 32, $pluginName, $defaultValue = "Countdown Completed!", $callbackName = "updateOutputText", $changedFunction = "", $inputType = "text", $sData = array());?> </p>
		</div>
		<div id = "showCountUp" style= "<? echo $showCountUpDiv; ?>">
			<p>Count Up Pre Text: <?  PrintSettingTextSaved("COUNTUP_PRE_TEXT", 0, 0, $maxlength = 32, $size = 32, $pluginName, $defaultValue = "It has been", $callbackName = "updateOutputText", $changedFunction = "", $inputType = "text", $sData = array());?> </p>
			<p>Count Up Post Text: <?  PrintSettingTextSaved("COUNTUP_POST_TEXT", 0, 0, $maxlength = 32, $size = 32, $pluginName, $defaultValue = "since", $callbackName = "updateOutputText", $changedFunction = "", $inputType = "text", $sData = array());?> </p>
		</div>
		<p><h3>If the remaining time is more than a day then you can select to include the hours and/or minutes.</br>
		</h3></p>
		<p>Include Hours: <?PrintSettingCheckbox("INCLUDE_HOURS", "INCLUDE_HOURS", 0, 0, "ON", "OFF", $pluginName ,$callbackName = "updateOutputTextHours", $changedFunction = ""); ?> </p>
		<p>Include Minutes: <?PrintSettingCheckbox("INCLUDE_MINUTES", "INCLUDE_MINUTES", 0, 0, "ON", "OFF", $pluginName ,$callbackName = "updateOutputTextMinutes", $changedFunction = ""); ?> </p>
		<p>Count up once target date has been reached: <?PrintSettingCheckbox("COUNT_UP", "COUNT_UP", 0, 0, "ON", "OFF", $pluginName ,$callbackName = "ShowCountUp", $changedFunction = ""); ?> 
		With this set, when the target date/time is reached, the counter will count up using the Count Up text. If not, it will use the Completed Text.</p>
		<p>Your message will appear as:</p>
		<div class= "marquee" id="scroll-container" >
			<p id="scroll-text">Countdown </p>
		</div>
		<br /><p>Font: <? PrintSettingSelect("FONT", "FONT", 0, 0, $defaultValue="", getFontsInstalled(), $pluginName, $callbackName = "", $changedFunction = ""); ?>
		Font Size: <? PrintSettingSelect("FONT_SIZE", "FONT_SIZE", 0, 0, $defaultValue="20", getFontSizes(), $pluginName, $callbackName = "", $changedFunction = ""); ?>
		Anti-Aliased: <?PrintSettingCheckbox("FONT_ANTIALIAS", "FONT_ANTIALIAS", 0, 0, "1", "", $pluginName , ""); ?></p> 
		
		<div id= "divCanvas" class='ui-tabs-panel matrix-tool-bottom-panel'>
			<table border=0>
				<tr><td valign='top'>
				<div>
					<table border=0>
						<tr><td valign='top'>Pallette:</td>
							<td><div class='colorButton red' onClick='setColor("#ff0000");'></div>
								<div class='colorButton green' onClick='setColor("#00ff00");'></div>
								<div class='colorButton blue' onClick='setColor("#0000ff");'></div>
								<div class='colorButton white' onClick='setColor("#ffffff");'></div>
								<div class='colorButton black' onClick='setColor("#000000");'></div>
							</td>
						</tr>
						<tr><td>Current Color:</td><td><span id='currentColor'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td></tr>
						<tr><td colspan='2'>Show Color Picker: <? PrintSettingCheckbox("Show Color Picker", "ShowColorPicker", 0, 0, "1", "0", $pluginName, "ShowColorPicker"); ?></td></tr>
						<tr><td valign='top' colspan='2'>
						<div id="colpicker"></div>
						</td></tr>
					</table>
				</div>
				</td></tr>
			</table>
		</div>
		<p><b>If you set the scroll speed to 0, then the message will display on the center of the matrix <br/>
		for the number of seconds set in the Duration</b></p> 
		Scroll Speed: <? PrintSettingSelect("SCROLL_SPEED", "SCROLL_SPEED", 0, 0, $defaultValue="20", getScrollSpeed(), $pluginName, $callbackName = "ShowDuration", $changedFunction = ""); ?> </p>
		<div id="showDuration" style= "<? echo $showScrollDiv; ?>">
			Duration: <? PrintSettingSelect("DURATION", "DURATION", 0, 0, $defaultValue="10", getDuration(), $pluginName, $callbackName = "", $changedFunction = ""); ?> </p>
		</div>
		
		<p>Matrix Name: <? PrintSettingSelect("OVERLAY_MODEL", "OVERLAY_MODEL", 0, 0, $defaultValue="", $values = GetOverlayList(), $pluginName, $callbackName = "", $changedFunction = ""); ?>
		If this is blank, then you need to configure the correct Pixel Overlay Model</p>
		<p>Overlay Mode: <? PrintSettingSelect("OVERLAY_MODE", "OVERLAY_MODE", 0, 0, "", Array("Full Overlay" => "1", "Transparent" => "2", "Transparent RGB" => "3"), $pluginName, $callbackName = "", $changedFunction = ""); ?> </p>
		<p><h3>The Overlay mode determines how you want your message to display.</h3>
		<ul>
			<li>Full Overlay- This will blank out the model and only display your message</li>
			<li>Transparent- This will display your message over the top of whatever is displaying on your matrix <br/>
			but the colors will blend slightly with what is currently being displayed</li>
			<li>Transparent RGB- This will display your message over the top of whatever is displaying on your matrix <br/>
			the colors will override what is currently being displayed</li> 
		</ul>
		
		
		
		
		<p>ENABLE PLUGIN: <?PrintSettingCheckbox("Event Date Plugin", "ENABLED", 0, 0, "ON", "OFF", $pluginName ,$callbackName = "", $changedFunction=""); ?> </p>
		<p>To report a bug, please file it against Simple Countdown plugin project on Git:<? echo $gitURL;?> 
		<p>Host Location: <?  PrintSettingTextSaved("HOST_LOCATION", 0, 0, $maxlength = 16, $size = 16, $pluginName, $defaultValue = "127.0.0.1", $callbackName = "", $changedFunction = "", $inputType = "text", $sData = array());?> </p>
		<p>The default location of 127.0.0.1 is used if you want to display your Countdown on an Overlay Model directly connected to this device. <br />
		You can send the Countdown text to another FPP device by entering that IP address for the Host Location. The Host location will need <br />
		to have the Pixel Overlay Model defined and this FPP will need to have the Pixel Overlay Model defined exactly as the Host FPP Device</p>
	</div>
  
</div>
</div>
	


<script>
updateOutputText();

//$("#matrixTabs").tabs({active: 0, cache: true, spinner: "", fx: { opacity: 'toggle', height: 'toggle' } });

    var colpickTimer = null;
	$('#colpicker').colpick({
		flat: true,
		layout: 'rgbhex',
		color: '#ff0000',
		submit: false,
		onChange: function(hsb,hex,rgb,el,bySetColor) {
            if (colpickTimer != null)
                clearTimeout(colpickTimer);

            colpickTimer = setTimeout(function() { setColor('#'+hex, false); }, 500);
		}
	});

    if (pluginSettings.hasOwnProperty('COLOR') && pluginSettings['COLOR'] != '') {
        currentColor = pluginSettings['COLOR'];
        $('#currentColor').css('background-color', currentColor);
    }
function updateOutputTextHours(updateOutput){
updateOutputText();	
}

function updateOutputTextMinutes(updateOutput){
updateOutputText();	
}
function updateOutputText(){
	
	var messageText= getMessageText();
	document.getElementById("scroll-text").innerHTML = messageText;
}
function getMessageText(){
	var elapsed = false; 
	var eventName = document.getElementById("EVENT_NAME").value;
	var eventMonth = parseInt(document.getElementById("MONTH").value)-1;
	var eventDay = document.getElementById("DAY").value;
	var eventYear = document.getElementById("YEAR").value;
	var eventHour = document.getElementById("HOUR").value;
	var eventMin = document.getElementById("MIN").value;
	var preText = document.getElementById("PRE_TEXT").value;
	var postText = document.getElementById("POST_TEXT").value;
	var postText = document.getElementById("POST_TEXT").value;
	var CountUpPreText = document.getElementById("COUNTUP_PRE_TEXT").value;
	var CountUpPostText = document.getElementById("COUNTUP_POST_TEXT").value;
	var completedText = document.getElementById("COMPLETED_MESSAGE").value;
	var incHours = document.getElementById("INCLUDE_HOURS").checked;
	var incMin = document.getElementById("INCLUDE_MINUTES").checked;
	var countup = document.getElementById("COUNT_UP").checked;
	var eventDate = new Date(eventYear, eventMonth, eventDay, eventHour, eventMin  );
	var currentDate= new Date();
	var rawTimeDiff = (eventDate - currentDate)/1000; 
	var yearsToDate = rawTimeDiff/(60*60*24*365);
	var daysToDate = (rawTimeDiff/(60*60*24))%365;
	var hoursToDate = (rawTimeDiff/(60*60))%24;
	var minutesToDate = (rawTimeDiff/60)%60 +1;
	var messageText;
	var messagePreText;
	var messagePostText;
	if (rawTimeDiff<0){
		elapsed= true;
	}

	if (elapsed && countup){
		messagePreText= CountUpPreText;
		messagePostText= CountUpPostText;
	}else{
		messagePreText= preText;
		messagePostText= postText;	
	}

			
	yearsToDate= Math.floor(Math.abs(yearsToDate));
	daysToDate= Math.floor(Math.abs(daysToDate));
	hoursToDate =Math.floor(Math.abs(hoursToDate));
	minutesToDate= Math.floor(Math.abs(minutesToDate));
	if (elapsed && countup){
		minutesToDate+= 1;
	}

	messageText = messagePreText;

	if (yearsToDate >= 1){
		if (yearsToDate >=2){
			messageText += " " + yearsToDate + " years ";
		}else {
			messageText += " " + yearsToDate + " year ";
		}

	}else{
		messageText += " ";
	}

	if (daysToDate >= 1){
		if (daysToDate >=2){
			messageText += daysToDate + " days ";
		} else {
			messageText += daysToDate + " day ";			
		}

		if(incHours == true){			
			if (hoursToDate >=2) {
				messageText += hoursToDate + " hours ";
			} else {
				if (hoursToDate >= 1) {
					messageText += hoursToDate + " hour ";
				}
			}
		}
		
		if(incMin == true){
			if(incHours == false){
				minutesToDate += hoursToDate*60;
			}
			if (minutesToDate >=2) {
				messageText += minutesToDate + " minutes ";
			} else {
				messageText += minutesToDate + " minute ";
			}	
		}	
	}else {
			
		if (hoursToDate >=2) {
			messageText += hoursToDate + " hours ";
		} else {
			if (hoursToDate >= 1) {
					messageText += hoursToDate + " hour ";
			}
		}
		
		if (minutesToDate >=2) {
			messageText += minutesToDate + " minutes ";
		} else {
			messageText += minutesToDate + " minute ";
		}	
	}           
        
	if (elapsed && !countup){
		messageText= completedText;
	}else{
		messageText += messagePostText + " " + eventName;
	}
	
	
	
	return messageText;
	
	
}
function ShowDuration(){
	var scrollSpeed = document.getElementById('SCROLL_SPEED').value;
	if (scrollSpeed ==0){
		document.getElementById('showDuration').style.display = "block";
	}else{
		document.getElementById('showDuration').style.display = "none";
	}
}
function ShowCountUp(){
	if (document.getElementById('COUNT_UP').checked == true){
		document.getElementById('showCountUp').style.display = "block";
		document.getElementById('showCompleted').style.display = "none";
	}else{
		document.getElementById('showCountUp').style.display = "none";
		document.getElementById('showCompleted').style.display = "block";
	}	
}
ShowColorPicker();
</script>

</html>
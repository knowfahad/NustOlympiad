<?php 

use App\OlMail;
require("bootstrap.php");
	$heading = "Welcome to NUST OLYMPIAD!";
	$link = "http://".$_SERVER['SERVER_NAME']."/register/verify/?username=";

$htmlmessage = 
<<<emailmessage
<html>
<body>
<h2>$heading</h2>
Dear Ambassador,
<p>
Congratulations on becoming a part of the NUST Olympiad'17. We hope that you perform to the best of your abilities and help us make this event a success!
</p>
<p>
Ambassador ID: khizercc64 
Name: khizer rao 
CNIC: 3120278953300 
Phone Number: 03126221952 
Institution: PAC
</p>
<p>
Please use the Ambassador ID above for future references. 
In case of any query or ambiguity, please contact er@nustolympiad.com.
</p>

The following link is the Facebook Group for the Ambassadors. Please Join this group and we will brief you about the next step. 
<a href="https://www.facebook.com/groups/1619115995060964/">https://www.facebook.com/groups/1619115995060964/</a>
<br>
Regards, External Relations Team NUST Olympiad 2017  
<hr />
</body>
</html>
emailmessage;

$txtmessage = "Dear Ambassador,\n\n
Congratulations on becoming a part of the NUST Olympiad'17. We hope that you perform to the best of your abilities and help us make this event a success!
\n\n
Ambassador ID: khizercc64 
Name: khizer rao 
CNIC: 3120278953300 
Phone Number: 03126221952 
Institution: PAC
\n\n
Please use the Ambassador ID above for future references. 
In case of any query or ambiguity, please contact er@nustolympiad.com.
\n\n
The following link is the Facebook Group for the Ambassadors. Please Join this group and we will brief you about the next step. \n\n
https://www.facebook.com/groups/1619115995060964/
\n
Regards, External Relations Team NUST Olympiad 2017  ";
	
	$mail = new OlMail(['name'=>"suchal riaz", 'email'=>"mriaz.bscs15seecs@seecs.edu.pk"], 'Verify your account | NUST OLYMPIAD 17', $htmlmessage, $txtmessage );
	$mail->send();
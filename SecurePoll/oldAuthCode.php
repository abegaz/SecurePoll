
<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
function incorrectLogin(){
	
	echo "incorrect login information";
}
//random string generator
function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
if(isset( $_POST['confirmed'])){
	$_SESSION['USERID'] = $_POST['USERID'];
	$randomString = generateRandomString();
	$_SESSION['random'] = hash('sha512', $randomString);
	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = '465';
	$mail->isHTML();
	$mail->Username = 'CSCI3300SecurePoll@gmail.com';
	$mail->Password = 'SecurePollCSCI3300';
	$mail->SetFrom('no-reply@SecurePoll.com');
	$mail->Subject = 'Hello World';
	$mail->Body = 'Your authentification password is '.$randomString ;
	$mail->AddAddress($_SESSION['email']);
	echo($randomString);
	//$mail->Send();
	echo("
<p>Enter authentication code sent to your email</p>
<form method=\"post\" action=\"authenticate.php\" id=\"verify\">
<p><input name=\"auth\" type=\"text\" placeholder=\"Authentication Number\" required></p>
<p><button  name=\"VerifyButton\" type=\"submit\" onclick=\"action\">Verify</button></p></form>
");
}else{
	
//this IF occurs after the user enters the auth code from email
if(isset($_POST['auth'])){
	$authHash = hash('sha512', $_POST['auth']);
	
	//if entered code is correct to the one sent to email
	if ($authHash==$_SESSION['random']){
	$_SESSION['authComplete']=true;
	
	echo("<script LANGUAGE='JavaScript'>
    window.location.href='http://localhost/SecurePoll/vote.php';
    </script>");

	}else{
				echo ("<script LANGUAGE='JavaScript'>
    window.alert('Incorrect Authentication Code');
    window.location.href='http://localhost/SecurePoll/login.php';
    </script>");
	}
	
	
}
else
	//This occurs when the user presses login
{


   
	$Email = $_POST['email'];
	$_SESSION['email'] = $Email;
	$ssn = $_POST['ssn'];
	$Password = $_POST['Password'];
	
echo("
<html>
<head>
<title>SecurePoll</title>
<meta charset=\"UTF8\">
 <script src=\"js/sha.js\"></script>
</head>
	<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
	<script>
//timeout after 5 minutes
attachEvent(window,'load',function(){
  var idleSeconds =300;
  var idleTimer;
  function resetTimer(){
    clearTimeout(idleTimer);
    idleTimer = setTimeout(whenUserIdle,idleSeconds*1000);
  }
  attachEvent(document.body,'mousemove',resetTimer);
  attachEvent(document.body,'keydown',resetTimer);
  attachEvent(document.body,'click',resetTimer);	
  resetTimer(); // Start the timer when the page loads
});
function whenUserIdle(){
alert(\"You have been idle for 5 minutes, returning to home page.\");
document.location.href = \"http://localhost/SecurePoll/index.php\";
}
function attachEvent(obj,evt,fnc,useCapture){
  if (obj.addEventListener){
    obj.addEventListener(evt,fnc,!!useCapture);
    return true;
  } else if (obj.attachEvent){
    return obj.attachEvent(\"on\"+evt,fnc);
  }
} 
</script>
<body onload=\"Checker()\">
<div class=\"centered_div\">
	<script src=\"https://www.gstatic.com/firebasejs/4.3.0/firebase.js\"></script>");
	
	
	//checks firebase for correct information
	echo("<script>");
	echo("
	function Checker(){
  // Initialize Firebase
  var config = {
    apiKey: \"AIzaSyBmfCylApkwRJlyzjH2e8KBP1SaFUuGMYY\",
    authDomain: \"polldatabase-52fc4.firebaseapp.com\",
    databaseURL: \"https://polldatabase-52fc4.firebaseio.com\",
    projectId: \"polldatabase-52fc4\",
    storageBucket: \"polldatabase-52fc4.appspot.com\",
    messagingSenderId: \"346839933651\"
  };
  firebase.initializeApp(config);
  
  
//create firebase references
  var Auth = firebase.auth(); 
  var dbRef = firebase.database();
  var UserData = dbRef.ref('UserData')
  var auth = null;
  var messagesRef = firebase.database().ref('UserData');
	var verify=\"true\";
");
echo("UserData.orderByChild('Email').equalTo('$Email').on(\"value\", function(snapshot) {
	if(snapshot.exists()){
    console.log(snapshot.val());
//takes data from email and sends it to PHP
var json = snapshot.val();
for (key in json) {
  if (!json.hasOwnProperty(key)) continue;
  
  
  Password = '$Password';
  PassSalt = json[key].PassSalt;
  var shaObj = new jsSHA(\"SHA-512\", \"TEXT\");
  shaObj.update(Password + PassSalt);
  
  //hashed user entered password
  var hash = shaObj.getHash(\"HEX\");
	if(hash != json[key].Password){
		verify = false;
	}
  var userID = json[key].UserID;
  var status = json[key].Status;
  var SSN = '$ssn';
  var SSNSalt = json[key].SSNSalt;
  var shaObj = new jsSHA(\"SHA-512\", \"TEXT\");
  shaObj.update(SSN + SSNSalt);
  var hash2 = shaObj.getHash(\"HEX\");
  
  var isActive = true;
  if(status == \"na\"){
  	isActive = false;
  }
	//alert(hash);
	//alert(json[key].Password);
	if(hash2 != json[key].SSN){
		verify = false;
	}
}
	}else{
		alert(\"Sorry, that user does not exist\");
	}
		if(verify == false){
		alert(\"Incorrect Login Information\");
		document.location.href = \"http://localhost/SecurePoll/login.php\";
		}
		else if(isActive == false){
			alert(\"Account has been deactivated. Please contact an administrator for reinstatement.\");
			document.location.href = \"http://localhost/SecurePoll/login.php\";
		}
		else{
			
			$.ajax({
     url: 'authenticate.php', //This is the current doc
     type: \"POST\",
     data: ({confirmed: true, USERID: userID }),
     success: function(data){
         document.body.innerHTML =(data);
     }
});
			//document.write(\"<h1>Successfully Logged in</h1><p>You will be redirected automatically.</p>\");
			//document.location.href = \"http://localhost/SecurePoll/authenticate.php\";
		}
});
}
</script>
</body>
</html>
	");
	

	
}
}

?>
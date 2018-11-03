<!--//production ready-->
<html>
<head>
<title>SecurePoll</title>
<meta charset="UTF8">
<link rel="stylesheet" href="securePoll.css">
</head>
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
alert("You have been idle for 5 minutes, returning to home page.");
document.location.href = "http://localhost/SecurePoll/index.php";
}
function attachEvent(obj,evt,fnc,useCapture){
  if (obj.addEventListener){
    obj.addEventListener(evt,fnc,!!useCapture);
    return true;
  } else if (obj.attachEvent){
    return obj.attachEvent("on"+evt,fnc);
  }
} 
</script>
<body onload="save()">
<div class="centered_div">
	<script src="https://www.gstatic.com/firebasejs/4.3.0/firebase.js"></script>
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

//this IF occurs after the user enters the auth code from email
if(isset($_POST['auth'])){
	$authHash = hash('sha512', $_POST['auth']);
	
	//if entered code is correct to the one sent to email
	if ($authHash==$_SESSION['random']){

	ob_end_clean();

	echo("<br>");

echo("
	<html>
	<head>
	<title>SecurePoll</title>
	<meta charset=\"UTF8\">
	<link rel=\"stylesheet\" href=\"style.css\">
	</head>
	<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
	<script type=\"text/javascript\">
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

$( document ).ready(function() {
$(\"#table tr\").click(function(){
   $(this).addClass('selected').siblings().removeClass('selected');    
   var value=$(this).find('td:first').html();
   alert(value);    
});

$('.ok').on('click', function(e){
    alert($(\"#table tr.selected td:first\").html());
});
});
</script>
	<body>
	<div class=\"centered_div\">
	<h2>Welcome ");echo $_SESSION['firstName'];
	echo("</h2><p>Here's a list of the different votes you can do</p>");
	echo "<table style='border: solid 1px black; background-color:#ADD8E6;' id=\"table\">";
	echo "<tr><th>Position</th><th>state</th><th>type</th></tr>";
	class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 


	echo "</table>";
	echo("<input type=\"button\" name=\"OK\" class=\"ok\" value=\"OK\"/>");
	/*
	echo ("<table width=\"100%;\"><tr>
	<th>Firstname</th>
    <th>Lastname</th> 
    <th>date of birth</th>
	<th>social</th>
	<th>voter number</th>
	</tr>
	<tr>
    <td>");
	echo $_SESSION['firstName']; echo "</td>
    <td>";echo $_SESSION['lastName']; echo "</td>
    <td>";echo $_SESSION['dateofbirth'];echo "</td>
	<td>";echo $_SESSION['social'];echo "</td>
    <td>";echo $_SESSION['voternumber'];echo "</td>
  </tr>

</table>";*/
	}else{
				echo ("<script LANGUAGE='JavaScript'>
    window.alert('Incorrect Authentication Code');
    window.location.href='http://google.com';
    </script>");
	}
	
	
}

else

	//This occurs when the users goes to login
{



$logoutCounter = 0;


$randomString = generateRandomString();

$_SESSION['random'] = hash('sha512', $randomString);


echo $randomString;

   
    echo "Connected successfully";
	$Email = $_POST['email'];
	$ssn = $_POST['ssn'];
	$Password = $_POST['Password'];
try {
	
	echo("<script>");
	echo("
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


");

echo("UserData.orderByChild('Email').equalTo($Email).on(\"value\", function(snapshot) {

	if(snapshot.exists()){
    console.log(snapshot.val());

//takes data from email and sends it to PHP
var json = snapshot.val();
for (key in json) {
  if (!json.hasOwnProperty(key)) continue;

  Password = json[key].Password;
  PassSalt = json[key].PassSalt;
  var SSN = json[key].SSN;
  var SSNSalt = json[key].SSNSalt;

}
	}else{
		alert("Sorry, that user does not exist");
	}

});

	
	//compares entered password to database 
	$stmt1 = $conn->prepare("SELECT Salt, password FROM userdata WHERE ssn=:ssn AND VoterIDNum=:VoterIDNum LIMIT 1");
	$stmt1->bindParam(":ssn", $ssn);
	$stmt1->bindParam(":VoterIDNum", $VoterIDNum);
	$stmt1->execute();
	
	$row = $stmt1->fetch();
	$salt = $row[0];
	$passwordDatabase = $row[1];
	
	$input_password_hash = hash('sha512', $Password.$salt);
	if($input_password_hash == $passwordDatabase){

		echo "correct password";

	}else{
		incorrectLogin();
		exit();
		//reverts user back to login...kinda, gotta set up a server for that, but google is fine for now.
		//echo ("<script LANGUAGE='JavaScript'>
    //window.alert('Incorrect Password');
    //window.location.href='http://google.com';
    //</script>");
	}

	$stmt1 =null;
	
	//retrieves all relevant information

	$stmt = $conn->prepare("SELECT Fname, Lname, ssn, VoterIDNum,state , email FROM Userdata WHERE Fname=:Fname AND Lname=:Lname AND ssn=:ssn AND VoterIDNum = :VoterIDNum AND Password = :Password LIMIT 1");

    $stmt->bindParam(':Fname', $Name);
    $stmt->bindParam(':Lname', $lname);
    $stmt->bindParam(':ssn', $ssn);
    $stmt->bindParam(':VoterIDNum', $VoterIDNum);
	$stmt->bindParam(':Password', $input_password_hash);
if($stmt->execute()){
		//all of the users' information is available here
	$userRow = $stmt->fetch();
	$_SESSION['firstName'] = $userRow[0];
	$_SESSION['lastName'] = $userRow[1];
	$_SESSION['social'] = $userRow[2];
	$_SESSION['voternumber'] = $userRow[3];
	$_SESSION['state'] = $userRow[4];
	$_SESSION['email'] = $userRow[5];
	$stmt = null;
	
	

	
	
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

	//$mail->Send();
	

echo("
<html>
<head>
<title>SecurePoll</title>
<meta charset=\"UTF8\">
<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js\"></script>
<link rel=\"stylesheet\" href=\"style.css\">
<script type=\"text/javascript\" src=\"script.js\"></script>
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
</head>
<body><p>Enter authentication code sent to your email</p>
<form method=\"post\" action=\"authenticate.php\" id=\"verify\">
<p><input name=\"auth\" type=\"text\" placeholder=\"Authentication Number\" required></p>
<p><button  name=\"VerifyButton\" type=\"submit\" onclick=\"action\">Verify</button></p></form>
</body>
</html>");

}else{
	echo "please use login page";
};
	
	

	
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }


	
	

}

?>

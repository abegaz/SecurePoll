<!--//production ready-->
<html>
<head>
<title>SecurePoll</title>
<meta charset="UTF8">
<link rel="stylesheet" href="css/style.css">
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
$emailRegEx = "/([a-z]+|[1-9]+)+\@([a-z]+|[1-9]+)+\.[a-z]+/";
$passwordRegEx = "/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/";
$valid = True;
//Makes sure both email address fields match
if($_POST['email'] != $_POST['verifyemail']){
	$message = "Please make sure your email address is correct";
    echo "<SCRIPT type='text/javascript'>alert('$message');</SCRIPT>";
	$valid = False;
}
//Checks if email is in proper format
elseif(!preg_match($emailRegEx, $_POST['email'])){
	$message = "Please enter a valid email address";
    echo "<SCRIPT type='text/javascript'>alert('$message');</SCRIPT>";
	$valid = False;
}
//Checks if password meets requirements
elseif(!preg_match($passwordRegEx, $_POST['Password'])){
	$message = "Password must be 8 characters and contain at least one uppercase letter, one lowercase letter, one number, and one special character";
    echo "<SCRIPT type='text/javascript'>alert('$message');</SCRIPT>";
	$valid = False;
}
//Checks if ssn has 4 characters
elseif(strlen($_POST['ssn'])!=4){
	$message = "Please only include the last 4 digits of your Social Security Number";
    echo "<SCRIPT type='text/javascript'>alert('$message');</SCRIPT>";
	$valid = False;
}
//checks for valid date of birth
elseif(strlen($_POST['DoB'])!=10){
	$message = "Date of Birth not valid";
    echo "<SCRIPT type='text/javascript'>alert('$message');</SCRIPT>";
	$valid = False;
}
elseif($_POST['DoB'] > date('Y-m-d', strtotime('-18 years'))){
	$message = "You must be at least 18 years old to vote.";
	echo "<script type='text/javascript'>alert('$message');</script>";
	$valid = False;
}
if ($valid == False){
	echo "<SCRIPT type='text/javascript'> window.location.replace(\"register.php\");</SCRIPT>";
}
//this adds to database SANITIZE MORE!
else{
try {
	$Name = $_POST['fName'];
	$lname = $_POST['Lname'];
	$Dob = $_POST['DoB'];
	$ssn = $_POST['ssn'];
	$email = $_POST['email'];
	$VoterIDNum = $_POST['VoterIDNum'];
	$Password = $_POST['Password'];
	$salt = uniqId('1234567890qwertyuiop');
	$SSNsalt = uniqId('1234567890qwertyuiop');
	$salted = $Password.$salt;
	$SSNsalted = $ssn.$SSNsalt;
	$SSNhashed = hash('sha512', $SSNsalted);
	$hashed = hash('sha512', $salted);
	$state = $_POST['state'];
	$UserID = $Name[0].$lname.rand(1000,9999);
	$Status = "a";
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
	
echo("
function saveUser(DoB, Email, FName, LName, PassSalt, Password, SSN, SSNSalt, State, UserID, VoterIDNum, Status){

  var newMessageRef = firebase.database().ref().child('UserData').child(UserID).set({
    Dob: DoB,
    Email:Email,
    FName:FName,
    LName:LName,
    PassSalt:PassSalt,
	Password:Password,
    SSN:SSN,
	SSNSalt:SSNSalt,
    State:State,
	UserID:UserID,
    VoterIDNum:VoterIDNum,
    Status:Status,
  });
}
");
echo("function save(){saveUser('$Dob', '$email', '$Name', '$lname', '$salt', '$hashed', '$SSNhashed', '$SSNsalt', '$state', '$UserID', '$VoterIDNum', '$Status')}");
	echo("</script>");
    echo("<h2>You have successfully registered </h2>");
echo("<p><a href=\"login.php\">Click here to login</a></p>");
    }
	
catch(PDOException $e)
    {
    echo "failed";
	
    }
	
}
?>



</div>
</body>
</html>

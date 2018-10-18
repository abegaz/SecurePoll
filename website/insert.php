<?php
$servername = "localhost";
$username = "root";
$password = "cromer678";
$myDB = "securepoll";
$emailRegEx = "/([a-Z]+|[1-9]+)+\@([a=Z]+|[1-9]+)+\.[a-Z]+/";
$passwordRegEx = "/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/";

$valid = True;
//Makes sure both email address fields match
if($_POST['email'] != $_POST['verifyemail']){
	$message = "Please make sure your email address is correct";
    echo "<SCRIPT type='text/javascript'>alert('$message');</SCRIPT>";
	$valid = False;
}
//Checks if email is in proper format
if(!preg_match($emailRegEx, $_POST['email'])){
	$message = "Please enter a valid password";
    echo "<SCRIPT type='text/javascript'>alert('$message');</SCRIPT>";
	$valid = False;
}
//Checks if password meets requirements
if(!preg_match($passwordRegEx, $_POST['Password'])){
	$message = "Password must be 8 characters and contain at least one uppercase letter, one lowercase letter, one number, and one special character";
    echo "<SCRIPT type='text/javascript'>alert('$message');</SCRIPT>";
	$valid = False;
}

//Checks if ssn has 4 characters
if(strlen($_POST['ssn'])!=4){
	$message = "Please only include the last 4 digits of your Social Security Number";
    echo "<SCRIPT type='text/javascript'>alert('$message');</SCRIPT>";
	$valid = False;
}

//checks for valid date of birth
if(strlen($_POST['DoB'])!=10){
	$message = "Date of Birth not valid";
    echo "<SCRIPT type='text/javascript'>alert('$message');</SCRIPT>";
	$valid = False;
}



if ($valid == False){
	echo "<SCRIPT type='text/javascript'> window.location.replace(\"http://localhost/SecurePoll/register.php\");</SCRIPT>";
}

//this adds to database SANITIZE MORE!
else
{
	
try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
	
	$Name = $_POST['fName'];
	$lname = $_POST['Lname'];
	$Dob = $_POST['DoB'];
	$ssn = $_POST['ssn'];
	$email = $_POST['email'];
	$VoterIDNum = $_POST['VoterIDNum'];
	$Password = $_POST['Password'];
	$salt = uniqId('1234567890qwertyuiop');
	$salted = $Password.$salt;
	$hashed = hash('sha512', $salted);
	$state = $_POST['State'];
	$UserID = uniqId('id');
	$Admin = "false";
	$stmt = $conn->prepare("INSERT INTO userdata (UserID, Fname, Lname,DoB,ssn,VoterIDNum,Password,Salt,State,email,Admin) VALUES (:UserID,:Fname,:Lname,:DoB,:ssn,:VoterIDNum,:Password,:Salt,:State,:email,:Admin)");
	
	$stmt->bindParam(':UserID', $UserID);
    $stmt->bindParam(':Fname', $Name);
    $stmt->bindParam(':Lname', $lname);
	$stmt->bindParam(':DoB', $Dob);
    $stmt->bindParam(':ssn', $ssn);
    $stmt->bindParam(':VoterIDNum', $VoterIDNum);
	$stmt->bindParam(':Password', $hashed);
	$stmt->bindParam(':Salt', $salt);
	$stmt->bindParam(':State', $state);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':Admin', $Admin);
	$stmt->execute();
    echo "New records created successfully";
	$stmt = null;
	$conn = null;
	
    
    }
	
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
	
}
?>

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
<body>
<div class="centered_div">
<h2>You have successfully registered <?php echo $_POST["fName"]; ?></h2>
<p><a href="login.php">Click here to login</a></p>


</div>
</body>
</html>

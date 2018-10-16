<?php
$servername = "localhost";
$username = "root";
$password = "cromer678";
$myDB = "securepoll";


if($_POST['email'] != $_POST['verifyemail']){
	$message = "Please make sure your email address is correct";
	echo "<script type='text/javascript'>alert('$message');</script>";
	header("location: register.php");
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
<body>
<div class="centered_div">
<h2>You have successfully registered <?php echo $_POST["fName"]; ?></h2>
<p><a href="login.php">Click here to login</a></p>


</div>
</body>
</html>
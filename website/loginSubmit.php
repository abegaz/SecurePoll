<?php
$servername = "localhost";
$username = "root";
$password = "cromer678";
$myDB = "securepoll";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
	
	$Name = $_POST['fName'];
	$lname = $_POST['Lname'];
	$Dob = $_POST['DoB'];
	$ssn = $_POST['ssn'];
	$VoterIDNum = $_POST['VoterIDNum'];
	$Password = $_POST['Password'];
	$salted = "4hd820dhcj34890xk".$Password."sjik38910hjska";
	$hashed = hash('sha512', $salted);
	$state = $_POST['State'];
	$UserID = uniqId('id');
	$Salt = "1";
	$Admin = "false";
	$stmt = $conn->prepare("INSERT INTO userdata (UserID, Fname, Lname,DoB,ssn,VoterIDNum,Password,Salt,State,Admin) VALUES (:UserID,:Fname,:Lname,:DoB,:ssn,:VoterIDNum,:Password,:Salt,:State,:Admin)");
	
	$stmt->bindParam(':UserID', $UserID);
    $stmt->bindParam(':Fname', $Name);
    $stmt->bindParam(':Lname', $lname);
	$stmt->bindParam(':DoB', $Dob);
    $stmt->bindParam(':ssn', $ssn);
    $stmt->bindParam(':VoterIDNum', $VoterIDNum);
	$stmt->bindParam(':Password', $hashed);
	$stmt->bindParam(':Salt', $Salt);
	$stmt->bindParam(':State', $state);
	$stmt->bindParam(':Admin', $Admin);
	$stmt->execute();

    echo "New records created successfully";

	$stmt = null;
	$conn = null;

	
    		<p><input  name="fName" type="text" placeholder="Enter First Name" required></p>
			<p><input  name="Lname" type="text" placeholder="Enter Last Name" required></p>
			<p>Date of Birth <input  name="DoB" type="date" placeholder="Date of Birth" required></p>
			<p><input  name="ssn" type="number" placeholder="Last 4 digits of your Social Security Number" required></p>
			<p><input  name="Password" type="password" placeholder="Password" required></p>
			<p><button type="Submit" name="RegisterButton">Register</button></p>
    }
	

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
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
<h2>Welcome <?php echo $_POST["fName"]; ?></h2>




</div>
</body>
</html>
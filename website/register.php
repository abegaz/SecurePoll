<html>
<head>
<title>SecurePoll</title>
<meta charset="UTF8">
<link rel="stylesheet" href="securePoll.css">
</head>
<script>
function checkform(){
    var form1 = document.getElementById('myForm');
    if(form1.email.value != form1.verifyemail.value)
    {
        alert("Passwords must be the same");
        form1.email.focus();
        return false;
    }
    return true;
}
</script>
<body>
	<div id="login">
	<br>
		<form id="login" action="insert.php" method="POST" id="myForm">
			<h2>Welcome to SecurePoll</h2>

			<p><input  name="fName" type="text" placeholder="Enter First Name" required></p>
			<p><input  name="Lname" type="text" placeholder="Enter Last Name" required></p>
			<p><input  name="email" type="text" placeholder="Enter Email" required></p>
			<p><input  name="verifyemail" type="text" placeholder="Verify Email" required></p>
			<p>Date of Birth <input  name="DoB" type="date" placeholder="Date of Birth" required></p>
			<p><input  name="ssn" type="number" placeholder="Last 4 digits of your Social Security Number" required></p>
			<p><input  name="VoterIDNum" type="number" placeholder="Voter ID Number" required></p>
			<p><input  name="Password" type="password" placeholder="Password" required></p>
			<p><input  name="State" type="text" placeholder="State" required></p>
			<p><button type="Submit" name="RegisterButton" onsubmit="return checkform();">Register</button></p>

		<form>
		</div>


</body>
<html>

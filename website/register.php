<html>
<head>
<title>SecurePoll</title>
<meta charset="UTF8">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<script type="text/javascript">
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

<div class="header">
  	<h2>Register</h2>
  </div>

		<form id="login" action="insert.php" method="POST" id="myForm" >

			<div class="input-group"><label>First Name</label><input  name="fName" type="text" placeholder="Enter First Name" required></div>
			<div class="input-group"><label>Last Name</label><input  name="Lname" type="text" placeholder="Enter Last Name" required></div>
			<div class="input-group">Email<input  name="email" type="text" placeholder="Enter Email" required></div>
			<div class="input-group">Re-enter Email<input  name="verifyemail" type="text" placeholder="Verify Email" required></div>
			<div class="input-group">Date of Birth <input  name="DoB" type="date" placeholder="Date of Birth" required></div>
			<div class="input-group"><label>Last 4 Digits of Social Security Number</label><input  name="ssn" type="number" placeholder="Last 4 digits of SSN" required></div>
			<div class="input-group"><label>VoterID Number</label><input  name="VoterIDNum" type="number" placeholder="Voter ID Number" required></div>
			<div class="input-group"><label>Password</label><input  name="Password" type="password" placeholder="Password" required></div>
			<div class="input-group"><label>State</label><input  name="State" type="text" placeholder="State" required></div>
			<div class="input-group"><button type="Submit" name="RegisterButton" class="btn" onsubmit="return checkform();">Register</button></div>

		<form>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
</body>
<html>


<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<script type="text/javascript">
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
  	<h2>Login</h2>
  </div>
		<form id="login" action="authenticate.php" method="POST">
			<div class="input-group"><label>First Name</label><input  name="fName" type="text" placeholder="Enter First Name" required></div>
			<div class="input-group"><label>Last name</label><input  name="Lname" type="text" placeholder="Enter Last Name" required></div>
			<div class="input-group"><label>Social Security Number</label><input  name="ssn" type="number" placeholder="Last 4 digits of your Social Security Number" required></div>
			<div class="input-group"><label>Voter ID Number</label><input  name="VoterIDNum" type="text" placeholder="Enter Last Name" required></div>
			<div class="input-group"><label>Password</label><input  name="password" type="password" placeholder="Password" required></div>
			<div class="input-group"><button type="Submit" class="btn" name="RegisterButton">Login</button></div>
  	<p>
  		Not a member? <a href="register.php">Sign up</a>
  	</p>
	<p>
		Delete Account? <a href="deletephp.php">Delete</a>

		</form>


</body>
<html>

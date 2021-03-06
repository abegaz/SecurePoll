
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
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
		<form id="loginForm" name="loginForm" action="authenticate.php" method="post">
			<div class="input-group">Email<input  id="email" name="email" type="text" placeholder="Enter Email" required></div>
			<div class="input-group"><label>Social Security Number</label><input  name="ssn" id="ssn" type="number" placeholder="Last 4 digits of your Social Security Number" required></div>
			<div class="input-group"><label>Password</label><input  name="Password" id="Password" type="password" placeholder="Enter Password" required></div>
			<div class="input-group"><button type="submit" class="btn" name="RegisterButton">Login</button></div>
			
	<div style="text-align:center">	
  	<p>Change Password <a href="passwordChange.html">Here</a></br>Not a member? <a href="register.php">Sign up</a></br>Deactivate Account <a href="deactivate.html">Here</a></p>
  	</p>
	</div>

		</form>

	
<script src="https://www.gstatic.com/firebasejs/4.3.0/firebase.js"></script>
</body>
<html>
<html>

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
  	<h2>Edit Your Account</h2>
  </div>
		<form id="login" action="authenticate.php" method="POST">
			<div class="input-group"><label>Current First Name: FName </label><input  name="fName" type="text" placeholder="Enter New First Name" required></div>
			<div class="input-group"><label>Current Last name: LName</label><input  name="Lname" type="text" placeholder="Enter New Last Name" required></div>
			<div class="input-group"><label>Current Email: Email</label><input  name="email" type="text" placeholder="Enter New Email Adddress" required></div>
			<div class="input-group"><label>Re-enter Email</label><input  name="verifyemail" type="text" placeholder="Verify New Email Adddress" required></div>
			<div class="input-group"><label>Current Social Security Number: SSN</label><input  name="ssn" type="number" placeholder="New Last 4 digits of your Social Security Number" required></div>
			<div class="input-group"><label>Current Voter ID: VoterIDNum</label><input  name="VoterIDNum" type="text" placeholder="Enter New Voter ID Number" required></div>
			
			<div class="input-group"><label>Current Password: Password</label><input  name="password" type="password" placeholder="Enter Current Password" required></div>
			<div class="input-group"><label>New Password</label><input  name="password" type="password" placeholder="Enter New Password" required></div>
			<div class="input-group"><label>Verify New Password</label><input  name="password" type="password" placeholder="Re-Enter New Password" required></div>
			<label>Current Date of Birth: Dob</label>
			<div class="input-group">New Date of Birth <input  name="DoB" type="date" placeholder="Date of Birth" required></div>
			<label>Current State: State</label>
			<div class="input-group"><label>New State</label><select name="state" required>
				<option value="Alabama">Alabama</option>
				<option value="Alaska">Alaska</option>
				<option value="Arizona">Arizona</option>
				<option value="Arkansas">Arkansas</option>
				<option value="California">California</option>
				<option value="Colorado">Colorado</option>
				<option value="Connecticut">Connecticut</option>
				<option value="Delaware">Delaware</option>
				<option value="District Of Columbia">District Of Columbia</option>
				<option value="Florida">Florida</option>
				<option value="Georgia">Georgia</option>
				<option value="Hawaii">Hawaii</option>
				<option value="Idaho">Idaho</option>
				<option value="Illinois">Illinois</option>
				<option value="Indiana">Indiana</option>
				<option value="Iowa">Iowa</option>
				<option value="Kansas">Kansas</option>
				<option value="Kentucky">Kentucky</option>
				<option value="Louisiana">Louisiana</option>
				<option value="Maine">Maine</option>
				<option value="Maryland">Maryland</option>
				<option value="Massachusetts">Massachusetts</option>
				<option value="Michigan">Michigan</option>
				<option value="Minnesota">Minnesota</option>
				<option value="Mississippi">Mississippi</option>
				<option value="Missouri">Missouri</option>
				<option value="Montana">Montana</option>
				<option value="Nebraska">Nebraska</option>
				<option value="Nevada">Nevada</option>
				<option value="New Hampshire">New Hampshire</option>
				<option value="New Jersey">New Jersey</option>
				<option value="New Mexico">New Mexico</option>
				<option value="New York">New York</option>
				<option value="North Carolina">North Carolina</option>
				<option value="North Dakota">North Dakota</option>
				<option value="Ohio">Ohio</option>
				<option value="Oklahoma">Oklahoma</option>
				<option value="Oregon">Oregon</option>
				<option value="Pennsylvania">Pennsylvania</option>
				<option value="Rhode Island">Rhode Island</option>
				<option value="South Carolina">South Carolina</option>
				<option value="South Dakota">South Dakota</option>
				<option value="Tennessee">Tennessee</option>
				<option value="Texas">Texas</option>
				<option value="Utah">Utah</option>
				<option value="Vermont">Vermont</option>
				<option value="Virginia">Virginia</option>
				<option value="Washington">Washington</option>
				<option value="West Virginia">West Virginia</option>
				<option value="Wisconsin">Wisconsin</option>
				<option value="Wyoming">Wyoming</option>			
		</select></div>
				<div class="input-group"><button type="Submit" class="btn" name="RegisterButton">Submit Changes</button></div>
  	
		</form>


</body>
<html>

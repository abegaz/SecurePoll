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
<?php
echo("<script>");
	echo("
		function Checker(){
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

	var verify=\"true\";
");

echo("UserData.orderByChild('Email').equalTo('$Email').on(\"value\", function(snapshot) {

	if(snapshot.exists()){
    console.log(snapshot.val());

//takes data from email and sends it to PHP
var json = snapshot.val();
for (key in json) {
  if (!json.hasOwnProperty(key)) continue;

  
  
  Password = '$Password';
  PassSalt = json[key].PassSalt;
  var shaObj = new jsSHA(\"SHA-512\", \"TEXT\");
  shaObj.update(Password + PassSalt);
  
  //hashed user entered password
  var hash = shaObj.getHash(\"HEX\");

	if(hash != json[key].Password){
		verify = false;
	}
  
  var SSN = '$ssn';
  var SSNSalt = json[key].SSNSalt;
  var shaObj = new jsSHA(\"SHA-512\", \"TEXT\");
  shaObj.update(SSN + SSNSalt);
  var hash2 = shaObj.getHash(\"HEX\");
  
	alert(hash);
	alert(json[key].Password);
	if(hash2 != json[key].SSN){
		verify = false;
	}
}
	}else{
		alert(\"Sorry, that user does not exist\");
	}

		if(verify == false){
		alert(\"Incorrect Login Information\");
		document.location.href = \"http://localhost/SecurePoll/index.php\";
		}else{
			
			$.ajax({
     url: 'authenticate.php', //This is the current doc
     type: \"POST\",
     data: ({confirmed: true}),
     success: function(data){
         document.body.innerHTML =(data);
     }
});  
			//document.write(\"<h1>Successfully Logged in</h1><p>You will be redirected automatically.</p>\");
			//document.location.href = \"http://localhost/SecurePoll/authenticate.php\";
		}
});

}
</script>
</body>
</html>

	");
?>

<body>
  <div class="header">
  	<h2>Change Your Password</h2>
  </div>
		<form id="login" action="insert.php" method="POST">

			
		</select></div>
				<div class="input-group"><button type="Submit" class="btn" name="RegisterButton">Submit Changes</button></div>
  	
		</form>


</body>
<html>

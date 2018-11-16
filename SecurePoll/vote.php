<?php
session_start();
if(!isset($_SESSION['authComplete'])){

	echo("<script LANGUAGE='JavaScript'>
    window.location.href='http://localhost/SecurePoll/login.php';
    </script>");
}

?>

<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="css/styleVote.css">
   <script src="js/sha.js"></script>
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
<script src="https://www.gstatic.com/firebasejs/4.3.0/firebase.js"></script>
<body>

</div>
<script type="text/javascript">
var counter=0;
var counterDisplay = 0;
var verify=true;
var dropdown="";
var userEmail ="";
var tableString="<tr><th>Race</th><th>Candidate</th></tr>";
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyBmfCylApkwRJlyzjH2e8KBP1SaFUuGMYY",
    authDomain: "polldatabase-52fc4.firebaseapp.com",
    databaseURL: "https://polldatabase-52fc4.firebaseio.com",
    projectId: "polldatabase-52fc4",
    storageBucket: "polldatabase-52fc4.appspot.com",
    messagingSenderId: "346839933651"
  };
  firebase.initializeApp(config);
//create firebase references
  var Auth = firebase.auth(); 
  var dbRef = firebase.database();
  var CampaignData = dbRef.ref('CampaignData');
  var CandidateData = dbRef.ref('CandidateData');
  var UserData = dbRef.ref('UserData');
  var auth = null;
  var CampaignData2 ='';
  TableSetter();
  

 function getDatabase(){
 if(counter <2){
CampaignData.orderByChild('State').equalTo('Georgia').on("value", function(snapshot) {
    console.log(snapshot.val());
    snapshot.forEach(function(childSnapshot) {

	
		//returns parent
		CampaignData2 = childSnapshot.ref.key;

		
		//returns campaign state
		var State = childSnapshot.val().State;

		
		//change to match logged in user
		var user = childSnapshot.val().<?php echo $_SESSION['USERID']; ?>;

		if(typeof user == 'undefined'){
		
		buildDropdown();
		buildTable(CampaignData2);
		}
    });
getDatabaseNational();
});
counter++;
}
}

 function getDatabaseNational(){
  if(counter <2){
CampaignData.orderByChild('State').equalTo('National').on("value", function(snapshot) {
    console.log(snapshot.val());
    snapshot.forEach(function(childSnapshot) {
	
		//returns parent
		CampaignData2 = childSnapshot.ref.key;
		
		//returns campaign state
		var State = childSnapshot.val().State;

		//change to match logged in user
		console.log(childSnapshot.val().State);
		var user = childSnapshot.val().<?php echo $_SESSION['USERID']; ?>;

		if(typeof user == 'undefined'){
		dropdown = '';
		buildDropdown();
		buildTable(CampaignData2);
		}
    });
});
}
counter++;
}
function TableSetter(){


         getDatabase(function() {
        console.log('Completed');
    });    
    
}
function buildDropdown(){
		//adds a table row depending on number of counterDisplay
		counterDisplay++;
dropdown += '<label>'+CampaignData2+'</label>';
dropdown += "<select id='race"+counterDisplay+"' onchange='changeValue(this.id)'><option>Select...</option>";

CandidateData.orderByChild('CampaignID').equalTo(CampaignData2).on("value", function(snapshot) {

    snapshot.forEach(function(childSnapshot) {
	var Fname = childSnapshot.val().FName;
	var Lname = childSnapshot.val().LName;
dropdown += "<option value='"+Fname+' '+Lname+"'+>"+Fname+' '+Lname+'</option>';
});
dropdown += '</select><br>';
document.getElementById('campaign').innerHTML += dropdown;
document.getElementById('campaign').innerHTML += '<br>';
});

}


function buildTable(CampaignName){

	tableString+="<tr><td id='"+counterDisplay+"race'>"+CampaignName+"</td><td id='race"+counterDisplay+"candidate'>Select Candidate</td></tr>";
	document.getElementById('final').innerHTML = tableString;

}

function changeValue(id){
    var x = document.getElementById(id).value;
    document.getElementById(id+"candidate").innerHTML = x;
}


function submitBallot(){
alert("thank you for voting!");
	for(i=1; i<=counterDisplay;i++){
	var raceCandidate="race"+i+"candidate";
	var race=i+"race";
		vote(raceCandidate, race);

	}

}


function vote(raceCandidate, race){

	var vote=0;
	var candidate = document.getElementById(raceCandidate).innerHTML;
	document.getElementById(raceCandidate).innerHTML = "Select Candidate";
	var race = document.getElementById(race).innerHTML;
	var snapshotKey ="";
	//split the candidate's name ,0 first, 1 last
	var words = candidate.split(" ");
	var lastName = words[1];
	if (candidate !== "Select Candidate"){
		CandidateData.orderByChild('LName').equalTo(words[1]).on("value", function(snapshot) {
	var counter = 0;
	if(snapshot.exists()){

	
	CandidateData.once('value', function(snapshot) {
	snapshot.forEach(function(childSnapshot) {
	var childKey = childSnapshot.key;
	var childData = childSnapshot.val();
		if(childData.LName ==words[1]){
		vote = childData.VoteCount+1;

		CandidateData.child(childKey).update({ 'VoteCount': vote});
		CampaignData.child(race).update({ '<?php echo $_SESSION['USERID']; ?>': "<?php echo $_SESSION['email']; ?>"});
		location.reload();
		}else{
		console.log(childData.VoteCount);
		}

	});//childsnapshot to get key and vote amount
	});
	}//exists

});
}//if*/

}

</script>
	
<div class="split left">
  <div class="centered">
    <div class="ballotHeader">
 				 <h2>Select Your Candidates </h2>
			</div>
			
			<form class="contentVote" id="login" id="myForm" >
				<div class="input-groupVote">
				
<div id="campaign">
</form>
  </div>
</div>
</div>
<div class="split right">
  <div class="centered">
	 <div class="ballotHeaderFinal">
    <h2>Your Ballot</h2>
	  </div>
	  <div style="background-color:white">

	  <table id="final"><p> </p></table>
	  </div>
	  	  <div class="ballotFooterFinal">
	  <div class="input-group"><button type="Submit" name="RegisterButton" class="btn" onclick="submitBallot();">Cast Ballot</button></div>
	  </div>
	  </div>
</body>
<html>

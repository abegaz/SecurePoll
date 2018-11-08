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
	
	
	
<div class="split left">
  <div class="centered">
    <div class="ballotHeader">
 				 <h2>Select Your Candidates </h2>
			</div>
			
			<form class="contentVote" id="login" action="insert.php" method="POST" id="myForm" >
				<div class="input-groupVote">
					<label>President</label>
					<select name="PresCandidate" required>
						<option selected="Selected">Select...</option>
						<option value="candidateOne">Candidate 1</option>
						<option value="candidateTwo">Candidate 2</option>
						<option value="candidateThree">Candidate 3</option>
					</select>
						<br>
					<label>Governor</label>
					<select name="state" required>
						<option selected="Selected">Select...</option>
						<option value="candidateOne">Candidate 1</option>
						<option value="candidateTwo">Candidate 2</option>
						<option value="candidateThree">Candidate 3</option>
					</select>
					<label>Senator</label>
						<select name="state" required>
						<option selected="Selected">Select...</option>
						<option value="candidateOne">Candidate 1</option>
						<option value="candidateTwo">Candidate 2</option>
						<option value="candidateThree">Candidate 3</option>
					</select>
				</div>		
				
			<form>
				
  </div>
</div>

<div class="split right">
  <div class="centered">
	 <div class="ballotHeaderFinal">
    <h2>Your Ballot</h2>
	  </div>
<table>
  <tr>
    <th>Race</th>
    <th>Candidate</th>
  </tr>
  <tr>
    <td>President</td>
    <td>Candidate 1</td>
  </tr>
  <tr>
    <td>Governor</td>
    <td>Candidate 2</td>
  </tr>
  <tr>
    <td>Senator</td>
    <td>Candidate 3</td>
  </tr>
</table>
	  <div class="ballotFooterFinal">
	  <div class="input-group"><button type="Submit" name="RegisterButton" class="btn" onsubmit="return checkform();">Cast Ballot</button></div>
	  </div>
  </div>
</div>
</body>
<html>


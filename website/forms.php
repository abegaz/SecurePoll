<?php
session_start();
echo $_SESSION['hiya'];
if(isset($_POST['auth'])){
	ob_end_clean();
	echo $_POST['auth'];
	echo("<br>");
	//echo $randomString;
	if($_POST['auth'] == "4"){

echo("
	<html>
	<head>
	<title>SecurePoll</title>
	<meta charset=\"UTF8\">
	<link rel=\"stylesheet\" href=\"securePoll.css\">
	</head>
	<body>
	<div class=\"centered_div\">
	<h2>Welcome ");echo $_SESSION['state'];
	echo("</h2><p>Here's a list of Races</p>");
	
	
	//disgusting table with user's info
	
	echo ("<table width=\"100%;\"><tr>
	<th>Firstname</th>
    <th>Lastname</th> 
    <th>date of birth</th>
	<th>social</th>
	<th>voter number</th>
	</tr>
	<tr>
    <td>");
	echo $_SESSION['firstName']; echo "</td>
    <td>";echo $_SESSION['lastName']; echo "</td>
    <td>";echo $_SESSION['dateofbirth'];echo "</td>
	<td>";echo $_SESSION['social'];echo "</td>
    <td>";echo $_SESSION['voternumber'];echo "</td>
  </tr>

</table>";
	}
}
?>




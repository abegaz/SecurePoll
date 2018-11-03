<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<meta charset="UTF8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
  margin: 0;
  font-family: "Lato", sans-serif;
}

body {
  font-size: 120%;
  background-image:url("img/vote3.gif");
  
  background-size: cover;

}


.sidebar {
  margin: 0;
  padding: 0;
  width: 200px;
  background-color: #f1f1f1;
  position: fixed;
  height: 100%;
  overflow: auto;
}

.sidebar a {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
}
 
.sidebar a.active {
  background-color: #4CAF50;
  color: white;
}

.sidebar a:hover:not(.active) {
  background-color: #555;
  color: white;
}

div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}

@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}
</style>

</head>

<body>
<div class="sidebar">
  <a class="active" href="#home">Home</a>
  <a href="login.php">LOGIN</a>
  <a href="register.php">REGISTER</a>
 
</div>

<div class="content">
  <h2>WELCOME TO SECURE POLL</h2>
  <p>To navigate on this website simply click on the links on your left side of the screen</p>
  
  
</div>
</body>
<html>

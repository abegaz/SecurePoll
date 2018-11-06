
<!DOCTYPE HTML>
<html>
    <title>Delete Data Using PHP- Demo Preview</title>
    <meta name="robot" content="noindex, nofollow"/>
    <head>
        <link rel="stylesheet" type="text/css" href="style2.css">
    </head>
    <body>

        <div class="maindiv">
            <div class="divA">
                <div class="title"><h2>Delete Your Account</h2></div>
                <div class="divB">
                    <div class="divD">
                        <p>Your Information</p>
                        <hr/>


                        <?php
                        //Eastablishing Connection With Server.
                        $connection = mysql_connect("localhost", "root", "");
                        
                        //Selecting Database From Server.
                        $db = mysql_select_db("securepoll", $connection);

                        if (isset($_GET['del'])) {
                            $del = $_GET['del'];
                            //SQL query for deletion.
                            $query1 = mysql_query("delete from people where employee_id=$del", $connection);
                        }

                            //SQL query to fetch data for Display in menu.
                        $query = mysql_query("select * from people", $connection);
                        while ($row = mysql_fetch_array($query)) {
                            echo "<b><a href=\"deletephp.php?id={$row['employee_id']}\">{$row['fname']}</a></b>";
                            echo "<br />";
                        }
                        ?>

                    </div>
                    <?php
                    
                    
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        //SQL query to Display Details.
                        $query1 = mysql_query("select * from people where employee_id=$id", $connection);
                        while ($row1 = mysql_fetch_array($query1)) {
                            ?>
                            <form class="form">
                                <h2>---Details---</h2>
                                <hr/>
                                <br><br>
                                <span>First Name:</span> <?php echo $row1['fname']; ?>
                                <br><br>
                                <span>Last Name:</span> <?php echo $row1['Lname']; ?>
                                <br><br>
                                <span>Birthdate:</span> <?php echo $row1['Birthdate']; ?>
                                <br><br>
                                <span>Social Number:</span> <?php echo $row1['Socialnumb']; ?>
                                <br><br>
                                <?php echo "<b><a href=\"deletephp.php?del={$row1['employee_id']}\"><input type=\"button\" class=\"submit\" value=\"Delete\"/></a></b>"; ?>
                            </form>

                            <?php
                        }
                    }
                    //Closing Connection with Server.
                    mysql_close($connection);
                    ?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
           
        </div>
    </body>
</html>
<?php

    require_once 'header.php';
    
    if (isset($_SESSION['email']))
    {
        destroySession();
        echo "<div class='main'>You have been logged out. Please <a href='index.php'>click here</a> to refresh the screen.";
    }
    else echo "<div class='main'><br>You cannot log out because you are not logged in. Please <a href='index.php'>click here</a> to refresh the screen.";
?>

        <br><br></div>
    </body>
</html>
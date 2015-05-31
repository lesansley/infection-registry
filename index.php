<?php
        require_once 'header.php';
        
        echo "<br><span class="main">Welcome to the $appname,";
        
        if($loggedin)
                echo " $username, you are logged in.";
        else
                echo " please <a href='register.php'>register</a> or <a href='login.php'>log in</a> to enter.";
?>

        </span><br><br>
    </body>
</html>
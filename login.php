<?php
    require_once 'header.php';
    echo "<div class='main'><h3>Please enter your details to log in</h3>";
  
    $error = $email = $pass = "";
    
    //start a new session
    if (isset($_SESSION['email'])) destroySession();
    
    //IF THE FORM HAS BEEN SUBMITTED THEN PERFORM THE FOLLOWING:
    if (isset($_POST['email']))
    {
        //SANITISE THE STRINGS ENTERED
        $email = sanitiseString($_POST['email']);
        $pass = sanitiseString($_POST['pass']);
        
        //IF EITHER EMAIL OR PASSWORD ARE NOTHING THEN CREATE ERROR MESSAGE
        if ($email == "" || $pass == "")
            $error = "Not all fields were entered<br>";
        
        else
        {
            //ENCRYPT THE PASSWORD
            $pass = encryptString($pass);
            
            //SELECT THE RECORD WHERE EMAIL AND PASSWORD ARE THE SAME
            $result = queryMySQL("SELECT * FROM users WHERE email='$email' AND password='$pass'");
            
            //IF NO SUCH RECORD EXISTS CREATE THE ERROR MESSAGE
            if ($result->num_rows == 0)
            {
                $error = "<span class='error'>Email/Password
                          invalid</span><br><br>";
                
                //SET THE EMAIL AND PASSWORD BACK TO NOTHING
                $email = "";
                $pass = "";
            }
            else
            {
                $row = $result->fetch_array(MYSQLI_NUM);
                
                //SET SESSION VARIABLES
                $_SESSION['email'] = $email;
                $_SESSION['firstname'] = $row[2];
                $_SESSION['lastname'] = $row[3];
                
                die("$row[2] $row[3] you are now logged in. Please <a href='dashboard.php?view=$email'>" .
                    "click here</a> to continue.<br><br>");
              }
        }
    }

  echo <<<_END
    <form method='post' action='login.php'>$error
    <span class='fieldname'>Email</span><input type='text' maxlength='32' name='email' value='$email'><br>
    <span class='fieldname'>Password</span><input type='password' maxlength='45' name='pass' value='$pass'><br>
    
_END;

?>
            <br>
            <span class='fieldname'>&nbsp;</span>
            <input type='submit' value='Login'>
            </form><br>
        </div>
    </body>
</html>
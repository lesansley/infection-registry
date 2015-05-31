<?php
    require_once 'header.php';
    
    echo <<<_END
        <script>
            function checkUser(username)
            {
                if(username.value == '')
                {
                    O('info').innerHTML = ''
                    return
                }
                
                params = "username=" + username.value
                request = new ajaxRequest()
                request.open("POST", "checkUser.php", true)
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
                request.setRequestHeader("Content-length", params.length)
                request.setRequestHeader("Connection", "close")
                
                request.onreadystatechange = function()
                {
                    if (this.readystatechange == 4)
                        if (this.status == 200)
                            if (this.responseText != null)
                                O('info').innerHTML = this.responseText
                }
                request.send(params)
            }
            
            function ajaxRequest()
            {
                try {var request = new XMLHttpRequest()}
                catch(e1){
                    try { request = new ActiveXObject("Msxml2.XMLHTTP")}   
                    catch(e2){
                        try{ request = new ActiveXObject("Microsoft.XMLHTTP")}
                        catch(e3){
                        request = false
                        }
                    }
                }
                return request
            }
        </script>
        <div class='main'><h3>Please enter your details to sign up</h3>
_END;

    //reset errors, usernames and passwords from previous sessions
    $error = $username = $password = "";
    if (isset($_SESSION['username'])) destroySession();
    
    //
    if (isset($_POST['username']))
    {
        $username = sanitiseString($_POST['user']);
        $password = sanitiseString($_POST['password']);
        
        if ($username == "" || $password =="")
            $error = "Not all fields were entered<br><br>";
            
        else
        {
            $result = queryMysql("SELECT * FROM users WHERE username=$username");
            
            if($result->num_rows)
                $error = "That username already exits<br><br>";
            else
            {
                queryMysql("INSERT INTO users VALUES('$user', '$password')");
                die("<h4>Account created</h4>Please log in.<br><br>");
            }
        }
    }
    echo <<<_END
        
        <form method='post' action='signup.php'>$error
        <span class='fieldname'>Username</span>
        <input type='text' maxlength='16' name='username' value='$username' onBlur='checkUser(this)'></span><br>
        <span class='fieldname'>Password</span>
        <input type='text' maxlength='16' name='password' value='$password'><br>

_END;
?>

        <span class='fieldname'>&nbsp;</span>
        <input type='submit' value='Register'>
        </form></div><br>
    </body>
</html>

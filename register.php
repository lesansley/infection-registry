<?php

    require_once 'header.php';
    
    //THIS SCRIPT IS SUPPOSED TO CHECK WHETHER THE EMAIL HAS ALREADY BEEN REGISTERED BUT IT DOES NOT WORK
    echo<<<_END
     <script>
     function checkUser(user)
     {
	if (user.value == '')
	{
	  O('info').innerHTML = '';
	  return;
	}
	
	params = "user=" + user.value;
	request = new ajaxRequest();
	request.open("POST", "checkuser.php", true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.setRequestHeader("Content-length", "params.length);
	request.setRequestHeader("Connection", "close");
	
	request.onreadystatechange = function()
	{
	  if (this.readyState == 4)
	    if (this.status == 200)
	      if (this.responseText != null)
		O('info').innerHTML = this.responseText;
	}
	
	request.send(params);
      }
	
	function ajaxRequest()
	{
	  try {var request = new XMLHttpRequest()}
	  catch(e1) {
	    try {request = new ActveObject("Msxml2.XMLHTTP")}
	    catch(e2) {
	      try {request = new ActveObject("Microsoft.XMLHTTP")}
	      catch(e3) {
		request = false
	  }}}
	  return request
	}
     </script>
     <div class='main'><h3>Please enter your details to register</h3>
_END;
    
        //RESET VARIABLES
        $error = $pass = $checkpass = $firstname = $lastname = $email = "";
        $adduser = false;
      
        //START A NEW SESSION
        if (isset($_SESSION['user'])) destroySession();
        
        //SANITISE THE RETURNED VALUES
        if (isset($_POST['email']))
        {
            $pass = sanitiseString($_POST['pass']);
            $checkpass = sanitiseString($_POST['checkpass']);
            $firstname = sanitiseString($_POST['firstname']);
            $lastname = sanitiseString($_POST['lastname']);
            $email = sanitiseString($_POST['email']);
            
            $error = validate_firstname($firstname);
            $error .= validate_lastname($lastname);
            $error .= validate_password($pass);
            $error .= validate_email($email);
            $error .= check_password($pass, $checkpass);
            
            if ($error == "") $adduser = true;
            
        }
        
        //CHECK THAT THE USERNAME SELECTED IS AVAILABLE
        if ($adduser)
        {
         $result = addUser ($pass, $firstname, $lastname, $email);
         if (!$result)
            {
                $error = "That email address is already associated with a user account.";
                $adduser = false;
            }
         else
            die ("A user account has been created for $email. Please <a href='login.php'>log-in</a> to continue.");
            //NEED TO RUN A FUNCTION THAT EMAILS THE ADMINISTRATOR TO VALIDATE THE USER
	    //NEED TO CREATE A FUNCTION THAT EMAILS A NEW PASSWORD IF THE USER HAS FORGOTTEN THEIR PASSWORD
        }
       
    echo <<<_END
        <form method='post' action='register.php'>$error<br>
        <span class='fieldname'>First Name</span><input type='text' maxlength='32' name='firstname' value='$firstname'><br>
        <span class='fieldname'>Last Name</span><input type='text' maxlength='32' name='lastname' value='$lastname'><br>
        <span class='fieldname'>Email</span><input type='text' maxlength='32' name='email' value='$email' onBlur='checkUser(this)'><br>
        <br>
        <span class='fieldname'>Password</span><input type='password' maxlength='45' name='pass' value='$pass'><br>
        <span class='fieldname'>Retype Password</span><input type='password' maxlength='45' name='checkpass' value='$checkpass'><br>
_END;
?>
	  <span class='fieldname'>&nbsp;</span>
	  <input type='submit' value='Register'>
	</form>
      </div><br> 
    </body>
</html>

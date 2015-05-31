<?php

require_once 'functions.php';

if (isset($_POST['email']))
{
    $email = sanitiseString($_POST['email']);
    $result = queryMysql("SELECT * FROM users WHERE email = '$email'");
    
    if ($result->num_rows)
        echo "<span class= 'taken'>&nbsp;&#x2718; This email address is already registered";
}
?>
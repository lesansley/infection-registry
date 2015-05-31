<?php
    
    require_once 'functions.php';
    //BEGIN THE SESSION
    
    
    session_start();
    
    echo "<!DOCTYPE html>
            \n<html>
            <head>";
    
    
    
    $userstr = ' (Guest)';
    $url = 'http://localhost/outcomes/';
    
    if(isset($_SESSION['email']))
    {
        $user = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
        $loggedin = TRUE;
        $userstr = " ($user)";
    }
    else $loggedin = FALSE;
    
    echo    "<title>$appname $userstr</title>"                          .
            "<link rel='stylesheet' href='styles.css' type='text/css'>" .
            "</head><body><center>"                                     .
            "<div class='appname'>$appname<br></div>"                   .
            "<script src='osc.js'></script>";  
        
    if($loggedin)
        
       echo "<div class='loginname'>(logged in as $user)</div>"         .   
            "<br><ul class='menu'>"                                     .
            "<li><a href='dashboard.php'>Dashboard</a></li>"             .
            "<li><a href='patients.php'>Patients</a></li>"              .
            "<li><a href='events.php'>Events</a></li>"          .
            "<li><a href='settings.php'>Settings</a></li>"          .
            "<li><a href='logout.php'>Logout</a></li></ul><br>";
    else
        echo  "<div class='loginname'>(not logged in)</div>"        .
              "<br><ul class='menu'>"                               .
              "<li><a href='index.php'>Home</a></li>"               .
              "<li><a href='register.php'>Register</a></li>"        .
              "<li><a href='login.php'>Login</a></li></ul><br>"     .
              "<span class='info'>&#8658; You must be logged in to ".
              "view this page.</span><br><br>";
?>
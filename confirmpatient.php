<?php
    require_once 'header.php';
    
    if(!$loggedin) die();
    $firstname = $lastname = $dob = $ni = $passport = '';
    $editOrView = '';
    $error = '';
    
    if(isset($_POST['editorview']))
    {
        
        $error = $firstname = sanitiseString($_POST['firstname']);
        $error .= $lastname = sanitiseString($_POST['lastname']);
        $error .= $dob = sanitiseString($_POST['dob']);
        $error .= $ni = sanitiseString($_POST['ni']);
        $error .= $passport = sanitiseString($_POST['passport']);
        
        $editOrView = $_POST['editorview'];
        
        $patient =  getPatient($firstname, $lastname, $dob, $ni, $passport);
    }
    
        
        
    //IF ERROR IS NOTHING THEN NO FIELDS WERE ENTERED SO REDIRECT TO PATIENT PAGE
    if ($error == '') die ("No search fields were completed.");
    
    echo <<<_END
            <form method='post' action='addpatient.php'><br>
            <input type='hidden' name='editorview value='$editOrView'>
            <table border="1" cellpadding="10">
                <tr>
                    <th></th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>DoB</th>
                    <th>NHS No.</th>
                    <th>Passport No.</th>
                </tr>
    
_END;
    
    echo populateConfirmPatient($patient);
    
?>
        <br><br>
        
</body>
</html>
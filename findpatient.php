<?php
    require_once 'header.php';
    
    if(!$loggedin) die();
    
    
    //RESET VARIABLES
    $firstname = $lastname = $dob = $ni = $passport = $editOrView = "";
    
    $editOrView = $_POST['editorview'];
    
    echo "$editOrView";
    echo <<<_END
    <div class='main'><h3>Search for a patient using any of these fields</h3></div>
    
        <form method='post' action='confirmpatient.php'><br>
        <span class='fieldname'>First Name</span><input type='text' maxlength='32' name='firstname' value='$firstname'><br>
        <span class='fieldname'>Last Name</span><input type='text' maxlength='32' name='lastname' value='$lastname'><br>
        <span class='fieldname'>Date of Birth</span><input type='date' maxlength='32' name='dob' value='$dob'><br>
        <span class='fieldname'>NHS Number</span><input type='text' maxlength='10' name='ni' value='$ni'><br>
        <span class='fieldname'>Passport Number</span><input type='text' maxlength='20' name='passport' value='$passport'><br>
        
        <input type="hidden" name="editorview" value=$editOrView>
_END;
?>
</select>
        <br>
        <span class='fieldname'>&nbsp;</span><input type='submit' value='Find Patient'>
        
        <br><br>
    </body>
</html>
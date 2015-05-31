<?php
    require_once 'header.php';
    
    if(!$loggedin) die();
    
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
    
        $firstname = sanitiseString($_POST['firstname']);
        $lastname = sanitiseString($_POST['lastname']);
        $gender = sanitiseString($_POST['gender']);
        $dob = sanitiseString($_POST['dob']);
        $ni = sanitiseString($_POST['ni']);
        $passport = sanitiseString($_POST['passport']);
        $hospital = sanitiseString($_POST['hospital']);
        $nationality = sanitiseString($_POST['nationality']);
        $email = sanitiseString($_POST['email']);
        $mobile = sanitiseString($_POST['mobile']);
        $homephone = sanitiseString($_POST['homephone']);
        $workphone = sanitiseString($_POST['workphone']);
        $address1 = sanitiseString($_POST['address1']);
        $address2 = sanitiseString($_POST['address2']);
        $address3 = sanitiseString($_POST['address3']);
        $city = sanitiseString($_POST['city']);
        $postcode = sanitiseString($_POST['postcode']);
        $country = sanitiseString($_POST['country']);
    
    //RESET VARIABLES
    $firstname = $lastname = $dob = $ni = $passport = $editOrView = "";
    
    $editOrView = $_POST['editorview'];
    
    echo "$editOrView";
    echo <<<_END
    <div class='main'><h3>Search for a patient using any of these fields</h3></div>
    
        <form method='post' action='findpatient.php'><br>
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
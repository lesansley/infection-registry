<?php
    require_once 'header.php';
    
    if(!$loggedin) die();
    
    //RESET VARIABLES
    $error = $firstname = $lastname = $dob = $gender = '';
    $ni = $passport = $hospital = '';
    $nationality = $email = $mobile = $homephone = $workphone = '';
    $address1 = $address2 = $address3 = $city = $postcode = $country = '';
    $editpatient=false;
    $duplicate=true;
    
    $referrer = $_SERVER['HTTP_REFERER'];
    
    $patientid = sanitiseString($_POST['patient']);
    
    //IF THE FORM HAS BEEN POSTED THEN SET THE VARIABLES TO THE NEW VALUES AND VALIDATE
    if(isset($_POST['firstname']))
    {
        $patientid = sanitiseString($_POST['patient']);
        $firstname = sanitiseString($_POST['firstname']);
        $lastname = sanitiseString($_POST['lastname']);
        $gender = sanitiseString($_POST['gender']);
        $dob = sanitiseString($_POST['dob']);
        $ni = sanitiseString($_POST['ni']);
        $passport = sanitiseString($_POST['passport']);
        $hospital = sanitiseString($_POST['hospital']);
        $email = sanitiseString($_POST['email']);
        $mobile = sanitiseString($_POST['mobile']);
        $nationality = sanitiseString($_POST['nationality']);
        $homephone = sanitiseString($_POST['homephone']);
        $workphone = sanitiseString($_POST['workphone']);
        $address1 = sanitiseString($_POST['address1']);
        $address2 = sanitiseString($_POST['address2']);
        $address3 = sanitiseString($_POST['address3']);
        $city = sanitiseString($_POST['city']);
        $postcode = sanitiseString($_POST['postcode']);
        $country = sanitiseString($_POST['country']);
        
        $error = validate_firstname($firstname);
        $error .= validate_lastname($lastname);
        $error .= validate_dob($dob);
        
        if ($error == "") $editpatient = true;
    }
    else//IF THE FORM HAS NOT BEEN POSTED THEN POPULATE WITH DATA FROM THE PATIENT TABLE USING PATIENT ID
    {
        //SET VARIABLE $PATIENTID EQUAL TO THE PATIENT ID PASSED FROM CONFIRMPATIENT.PHP
       
        $result = getPatient($patientid,'','','','','','','');
        
        //if (!$result->num_row)
            //die ("Record not found");
        $result->data_seek(0);
        $rowinfo = $result->fetch_array(MYSQLI_NUM);
        
        $j = 0;
        
        $firstname = $rowinfo[++$j];
        $lastname = $rowinfo[++$j];
        $dob = $rowinfo[++$j];
        $ni = $rowinfo[++$j];
        $passport = $rowinfo[++$j];
        $hospital = $rowinfo[++$j];
        $email = $rowinfo[++$j];
        $mobile = $rowinfo[++$j];
        $nationality = $rowinfo[++$j];
        $gender = $rowinfo[++$j];
        $homephone = $rowinfo[++$j];
        $workphone = $rowinfo[++$j];
        $address1 = $rowinfo[++$j];
        $address2 = $rowinfo[++$j];
        $address3 = $rowinfo[++$j];
        $city = $rowinfo[++$j];
        $postcode = $rowinfo[++$j];
        $country = $rowinfo[++$j];
    }
    
    if ($editpatient)
    {
        $result = editPatient($patientid, $firstname, $lastname, $dob, $ni, $passport, $hospital, $email, $mobile, $nationality, $gender, 
                              $homephone, $workphone, $address1, $address2, $address3, $city, $postcode, $country);
         
        die ("The patient has been edited in the patient database");
    }
    
    echo "<form method='post' action='editpatient.php'>$referrer<br>
        <input type='hidden' name='patient' value='$patientid'>";
    
    echo populatePatientForm ($firstname, $lastname, $dob, $ni, $passport, $hospital, $email, $mobile, $nationality, $gender, 
                              $homephone, $workphone, $address1, $address2, $address3, $city, $postcode, $country)
?>
        </select>
        <br>
        <span class='fieldname'>&nbsp;</span><input type='submit' value='Edit Patient'>
        <br><br>
    </body>
</html>
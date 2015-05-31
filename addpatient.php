<?php
    require_once 'header.php';
    
    if(!$loggedin) die();
    
    //RESET VARIABLES
    $patientid = '';
    $error = $firstname = $lastname = $dob = $gender = "";
    $ni = $passport = $hospital = "";
    $email = $mobile = $homephone = $workphone = "";
    $address1 = $address2 = $address3 = $city = $postcode = "";
    $nationality = $country = "GB";
    
    if(!isset($editoradd)) $editoradd = 'add';
    
    if(isset($_POST['patient']))//RECEIVES VALUES FROM confirmpatient.php PAGE
    {
        $patientid = $_POST['patient'];
        $patientdetails = findPatient($patientid);
        
        $firstname = $patientdetails['firstname'];
        $lastname = $patientdetails['lastname'];
        $gender = $patientdetails['gender'];
        $dob = $patientdetails['dob'];
        $ni = $patientdetails['ni'];
        $passport = $patientdetails['passport'];
        $hospital = $patientdetails['hospital'];
        $nationality = $patientdetails['nationality'];
        $email = $patientdetails['email'];
        $mobile = $patientdetails['mobile'];
        $homephone = $patientdetails['homephone'];
        $workphone = $patientdetails['workphone'];
        $address1 = $patientdetails['address1'];
        $address2 = $patientdetails['address2'];
        $address3 = $patientdetails['address3'];
        $city = $patientdetails['city'];
        $postcode = $patientdetails['postcode'];
        $country = $patientdetails['country'];
        
        $editoradd='edit';
    }
    
    if(isset($_POST['proceed']))
    {
        $patientid = sanitiseString($_POST['patientid']);
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
        
        $editoradd = sanitiseString($_POST['editoradd']);
        
        $error = validate_firstname($firstname);
        $error .= validate_lastname($lastname);
        $error .= validate_dob($dob);
        
        if ($error == "")
        {
            if($editoradd == 'add')
                $result = addPatient($patientid,$firstname, $lastname, $dob, $gender, $ni, $passport, $hospital, $nationality, $email, $mobile,
                              $homephone, $workphone, $address1, $address2, $address3, $city, $postcode, $country);
            elseif($editoradd == 'edit')
                $result = editPatient($patientid, $firstname, $lastname, $dob, $ni, $passport, $hospital, $email, $mobile, $nationality, $gender, 
                              $homephone, $workphone, $address1, $address2, $address3, $city, $postcode, $country);
            if (!$result)
            {
                //POSSIBLE PATIENT MATCH EXISTS IN THE DATABASE, CONFIRM WHETHER USER WISHES TO CONTINUE WITH ADDING THIS PATIENT
                alert ("There is a possible duplicate record already in the database. Please check before adding this patient");
            }
            else
            die ("The patient database has been updated ". $editoradd);
            }
        else
        {
            $error = "Fields with * are required.";
        }    
    }
    
    
    echo "  <form method='post' action='addpatient.php'>$error$ || $firstname || $patientid || $editoradd<br>";
    
    echo populatePatientForm($patientid, $firstname, $lastname, $dob, $gender, $ni, $passport, $hospital, $nationality, $email, $mobile,
                              $homephone, $workphone, $address1, $address2, $address3, $city, $postcode, $country, $editoradd)
    
?>
        
        <br><br>
    </body>
</html>
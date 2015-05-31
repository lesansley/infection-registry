<?php
    //database login details
    $dbhost = 'localhost';
    $database = 'outcomes';
    $dbusername = 'projectoutcome';
    $dbpassword = 'pX5Gnenb6RQcBbQH';
    $appname = 'Outcomes Project';
    
    $dbhost2 = 'localhost';
    $database2 = 'patient';
    $dbusername2 = 'patientoutcome';
    $dbpassword2 = 'hYQpYGKJ6vbNNp38';
    $appname2 = 'Outcomes Project';
    
    //CREATES A CONNECTION TO THE OUTCOMES DATABASE
    $connOutcome = new mysqli($dbhost, $dbusername, $dbpassword, $database);
    if ($connOutcome->connect_error) die ($connOutcome->connect_error);
    
    //CREATES A CONNECTION TO THE PATIENT DATABASE
    $connPatient = new mysqli($dbhost2, $dbusername2, $dbpassword2, $database2);
    if ($connPatient->connect_error) die ($connPatient->connect_error);
    
    //checks whether a table already exists and, if not, creates it
    function createTable($name, $query)
    {
        queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
        return "Table '$name'created or already exists.<br>";
    }
    
    function createTempTable($name, $query)
    {
        queryMysql("CREATE TEMPORARY TABLE IF NOT EXISTS $name($query)");
        return "Table '$name'created or already exists.<br>";
    }
    
    //ADD A USER TO THE OUTCOMES DATABASE
    function addUser($pass, $firstname, $lastname, $email)
    {
        $result = queryMysql("SELECT * FROM users WHERE email='$email'");
        //IF THE USERNAME HAS BEEN USED THEN RETURN FALSE
        if ($result->num_rows)
            return false;
        //IF THE USERNAME IS FINE THEN ENCRYPT THE PASSWORD AND CREATE NEW RECORD
        else
            $pass = encryptString($pass);
            queryMysql("INSERT INTO users (password, firstname, lastname, email) VALUES ('$pass', '$firstname', '$lastname', '$email')");
            return true;
    }
    
    //GENERATE THE HTML CODE THAT POPULATES THE PATIENT FORM
    function populatePatientForm ($patientid, $firstname, $lastname, $dob, $gender, $ni, $passport, $hospital, $nationality, $email, $mobile,
                              $homephone, $workphone, $address1, $address2, $address3, $city, $postcode, $country, $editoradd)
    {
    
    if($editoradd == "add" ? $submitbutton = "Add patient" : $submitbutton = "Edit patient"); 
    $populate = "<span class='fieldname'>First Name*</span><input type='text' maxlength='32' name='firstname' value='$firstname'><br>
                <span class='fieldname'>Last Name*</span><input type='text' maxlength='32' name='lastname' value='$lastname'><br>
                <span class='fieldname'>Date of Birth*</span><input type='date' maxlength='32' name='dob' value='$dob'><br>
                <span class='fieldname'>Gender*</span>
                <label>Male<input type='radio' name='gender' value='0'";
    if ($gender == 0) $populate .= "checked='checked'";
    $populate .= "></label>
                <label>Female<input type='radio' name='gender' value='1'";
    if ($gender == 1) $populate .= "checked='checked'";
    $populate .= "></label><br>
                <br>
                <span class='fieldname'>NHS Number</span><input type='text' maxlength='10' name='ni' value='$ni'><br>
                <span class='fieldname'>Passport</span><input type='text' maxlength='20' name='passport' value='$passport'><br>
                <span class='fieldname'>Hospital Number</span><input type='text' maxlength='20' name='hospital' value='$hospital'><br>
                <span class='fieldname'>Nationality</span><select type='text' name='nationality' value='$nationality'>";
    
    $populate .= populateCountry($nationality);

    $populate .= "</select>
                <br>
                <br>
                <span class='fieldname'>Email</span><input align='left' type='text' maxlength='32' name='email' value='$email'><br>
                <span class='fieldname'>Mobile</span><input type='text' maxlength='13' name='mobile' value='$mobile'><br>
                <span class='fieldname'>Home Phone</span><input align = 'left'type='text' maxlength='13' name='homephone' value='$homephone'><br>
                <span class='fieldname'>Work Phone</span><input type='text' maxlength='13' name='workphone' value='$workphone'><br>
                <br>
                <span class='fieldname'>Address 1</span><input type='text' maxlength='45' name='address1' value='$address1'><br>
                <span class='fieldname'>Address 2</span><input type='text' maxlength='45' name='address2' value='$address2'><br>
                <span class='fieldname'>Address 3</span><input type='text' maxlength='45' name='address3' value='$address3'><br>
                <span class='fieldname'>City</span><input type='text' maxlength='45' name='city' value='$city'><br>
                <span class='fieldname'>Postal code</span><input type='text' maxlength='7' name='postcode' value='$postcode'><br>
                <span class='fieldname'>Country</span><select type='text' name='country' value='$country'>
                <span class>";
    $populate .= populateCountry($country);
    $populate .= "</select>
                <br>
                <span class='fieldname'>&nbsp;</span>
                <input type='hidden' name='patientid' value='$patientid'>
                <input type='hidden' name='editoradd' value='$editoradd'>
                <input type='submit' name='proceed' value='$submitbutton'>
                <input type='submit' name='cancel' value='Cancel'>";
    
    
    return $populate;
    }
    //ADD A PATIENT TO THE PATIENT DATABASE
    function addPatient($patientid, $firstname, $lastname, $dob, $gender, $ni, $passport, $hospital, $nationality, $email, $mobile, $homephone, $workphone,
                        $address1, $address2, $address3, $city, $postcode, $country)
    {
            $query = "INSERT INTO patient (firstname, lastname, dob, gender, ni, passport, hospital, email, mobile, nationality, homephone,
                    workphone, address1, address2, address3, city, postcode, country) VALUES ('$firstname', '$lastname', '$dob',
                    '$gender', '$ni', '$passport',  '$hospital', '$email', '$mobile', '$nationality','$homephone', '$workphone', '$address1',
                    '$address2', '$address3', '$city', '$postcode', '$country')";
            
            queryMysqlPatient($query);
            return true;
    }
    
    //EDIT PATIENT DETAILS IN THE PATENT DATABASE
    function editPatient ($patientid, $firstname, $lastname, $dob, $ni, $passport, $hospital, $email, $mobile, $nationality, $gender, 
                              $homephone, $workphone, $address1, $address2, $address3, $city, $postcode, $country)
    {
        $query = "UPDATE patient SET firstname='$firstname',lastname='$lastname',dob='$dob',ni='$ni',passport='$passport',
                hospital='$hospital', email='$email',mobile='$mobile',nationality='$nationality',gender='$gender',
                homephone='$homephone', workphone='$workphone',address1='$address1',address2='$address2',address3='$address3',
                city='$city', postcode='$postcode',country='$country' WHERE __kp_patient='$patientid'";
        
        queryMysqlPatient($query);
        
        return true;
    }
    
    function findPatient ($patientid)
    {
        $query = "SELECT * FROM patient WHERE __kp_patient = '$patientid'";
        $patient = queryMysqlPatient($query);
        $patient = $patient->fetch_array(MYSQLI_ASSOC);
        return $patient;
    }
   
    function checkPatientDuplication ($info, $field)
    {
        $result = queryMysqlPatient("SELECT * FROM patient WHERE $field = '$info'");
        if ($result->num_rows)
            return 1;
        return 0;
    }
 
    function getPatient($firstname, $lastname, $dob, $ni, $passport)
    {
        $searchjoin = '';
        $populate = '';
        
        $query = "SELECT * FROM patient WHERE ";
        if($firstname){
            $query .= "firstname='$firstname'";
            $searchjoin = " AND ";
        }
        if($lastname){
            $query .= "$searchjoin lastname='$lastname'";
            $searchjoin = " AND ";
        }
        if($dob){
            $query .= "$searchjoin dob='$dob'";
            $searchjoin = " AND ";
        }
        if($ni){
            $query .= "$searchjoin ni='$ni'";
            $searchjoin = " AND ";   
        }
        if($passport) $query .= "passport='$passport'";
        
        $populate = queryMysqlPatient($query);
        
        return $populate;
    }
    
    function populateConfirmPatient($patientid)
    {
        $populate = '';
        //$num = $populate .= $patientid->num_rows." || ";
        $rows = $patientid->num_rows;
        
        if(!$rows)//IF THERE ARE NO ROWS IN THE ARRAY THEN NOTIFY USER NOT MATCHING RECORDS
            $populate = "<tr>
                            <td></td>
                            <td colspan='5'>No records match your search criteria</td>
                        </tr>
                        </table><br><br>
                        <input type='submit' name='find' value='Find Patient'>
                                    <input type='submit' name='cancel' value='Cancel'>";
        else
        {
        
            for($i = 0; $i < $rows; ++$i)//CREATE A LOOP FOR THE NUMBER OF ROWS IN THE ARRAY
            {
                $populate .= "<tr>";
                
                $rowresult = $patientid->fetch_array(MYSQLI_NUM);//CONVERT THE ARRAY INTO A STRING
                $populate .= "<td><input type='radio' name='patient' value='$rowresult[0]'></td>";
                
                    for($j = 1; $j < 6; ++$j)//CREATE A LOOP FOR THE FIRST SIX COLUMNS OF THE ARRAY
                {
                     $populate .= "<td>$rowresult[$j]</td>";//POPULATE THE TABLE CELLS WITH THE ARRAY STRINGS
                }   
                $populate .= "</tr>";
            }
        $populate .= "</table><br><br>
                        <input type='submit' name='Select' value='Select Patient'>
                        <input type='submit' name='cancel' value='Cancel'>";
        }
        return $populate;
    }

    function queryMysql($query)
    {
        global $connOutcome;
        $result = $connOutcome->query($query);
        if(!$result) die($connOutcome->error);
        return $result;
        $result->close;
    }
    
    function queryMysqlPatient($query)
    {
        global $connPatient;
        $result = $connPatient->query($query);
        if(!$result) die($connPatient->error);
        return $result;
        $result->close;
    }
    
    
    //ENCRYPT A TEXT STRING
    function encryptString($text)
    {
        $salt1 = "6>CW/8";
        $salt2 = "95}W*X";
        
        return hash('ripemd128', "$salt1$text$salt2");
    }
    
    //destroys a php session and clears its data to log users out
    function destroySession()
    {
        $_SESSION = array();
        
        if (session_id() != "" || isset($_COOKIE[session_name()]))
            setcookie(session_name(), '', time()-2592000, '/');
        
        session_destroy();
    }
    
    //remove potentially malicious code or tages from user input
    function sanitiseString($var)
    {
        global $connOutcome;
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);
        return $connOutcome->real_escape_string($var);
    }

    
    //functions that validate user input
    function validate_firstname($field)
    {
        return ($field == "") ? "No First Name was entered<br>" : "";
    }
    
    function validate_lastname($field)
    {
        if ($field == "")   
            return "No Last Name was entered<br>";
    }
    
    function validate_username($field)
    {
        if ($field == "") return "No username was entered<br>";
        else if (strlen($field) < 5)
            return "Usernames must be at least 5 characters<br>";
        else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
            return "Only letters, numbers, - and _ in usernames<br>";
        return "";
    }
    
    function validate_password($field)
    {
        if ($field == "") return "No password was entered<br>";
        else if (strlen($field) < 6)
            return "Passwords must be at least 6 characters<br>";
        else if (!preg_match("/[a-z]/", $field) ||
                 !preg_match("/[A-Z]/", $field) ||
                 !preg_match("/[0-9]/", $field))
            return "Passwords require 1 each of a-z, A-Z and 0-9<br>";
        return "";
    }
    
    function validate_email($field)
    {
        if ($field == "") return "No email was entered<br>";
        else if (!((strpos($field, ".") > 0) &&
                (strpos($field, "@") > 0)) ||
                preg_match("/[^a-zA-Z0-9.@_-]/", $field))
            return "The Email address is invalid<br>";
        return '';
    }
    
    function validate_dob($field)
    {
        $date = date_parse_from_format('Y-m-d', $field);
        $dateStamp = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
        
        if ($field == "") return "No date of birth was entered<br>";
        
        else if(!checkdate($date['month'], $date['day'], $date['year'])) return "An invalid date of birth was entered<br>";
        
        else if ($dateStamp < (time()-3786912000) || $dateStamp > (time()-315576000))
            return "The date of birth was outside the date range (10 - 120 years)<br>";
    
        return;
    }
    
    function check_password($password1, $password2)
    {
        if (!($password1 == $password2)) return "Passwords do not match<br>";
        return "";
    }
    
    //POPULATES A DROPDOWN LIST WITH A LIST OF COUNTRIES
    function populateCountry($country)
    {
        $result = queryMysql("SELECT code, name FROM country");
        $num = $result->num_rows;
        $populate = '';
        if(!$num == 0)
        {
            for ($i = 0; $i < $num; ++$i)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $countryCode = $row['code'];
                $countryName = $row['name'];
                if ($countryCode == $country)
                    $populate .= "<option selected=\"selected\" value=\"$countryCode\">$countryName</option>";
                else
                    $populate .= "<option value=\"$countryCode\">$countryName</option>";
            }
        }
        return $populate;
    }
    
   function populatePatient($patient)
    {
        $result = queryMysqlPatient("SELECT __kp_patient, firstname, lastname, dob FROM patient ORDER BY lastname, firstname, dob");
        $num = $result->num_rows;
        $populate = '';
        
        if(!$num == 0)
        {
            for ($i = 0; $i < $num; ++$i)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $patientId = $row['__kp_patient'];
                $firstName = $row['firstname'];
                $lastName = $row['lastname'];
                $dob = $row['dob'];
                
                if ($patientId==$patient)
                    $populate .= "<option selected=\"selected\" value=\"$patientId\">$lastName, $firstName (DoB: $dob)</option>";
                else
                    $populate .= "<option value=\"$patientId\">$lastName, $firstName (DoB: $dob)</option>";
            }
        }   
        return $populate;
    }
    
    
    function populateSurgeon($surgeon)
    {
        $result = queryMysql("SELECT __kp_surgeon, firstname, lastname FROM surgeon ORDER BY lastname, firstname");
        $num = $result->num_rows;
        $populate = '';
        
        if(!$num == 0)
        {
            for ($i = 0; $i < $num; ++$i)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $surgeonId = $row['__kp_surgeon'];
                $firstName = $row['firstname'];
                $lastName = $row['lastname'];
                
                if ($surgeonId==$surgeon)
                    $populate .= "<option selected=\"selected\" value=\"$surgeonId\">$lastName, $firstName</option>";
                else
                    $populate .= "<option value=\"$surgeonId\">$lastName, $firstName</option>";
            }
        }  
        return $populate;
    }
    
    function populateSmoker($smoker)
    {
        switch($smoker)
        {
            case 0:
                $populate = "<label>Yes<input type='radio' name='smoker' value='0' checked='checked'></label>
                            <label>No<input type='radio' name='smoker' value='1'></label>
                            <label>Don't know<input type='radio' name='smoker' value='2'></label>";
                return $populate;
                break;
            case 1:
                $populate = "<label>Yes<input type='radio' name='smoker' value='0'></label>
                            <label>No<input type='radio' name='smoker' value='1' checked='checked'></label>
                            <label>Don't know<input type='radio' name='smoker' value='2'></label>";
                return $populate;
                break;
            default:
                $populate = "<label>Yes<input type='radio' name='smoker' value='0'></label>
                            <label>No<input type='radio' name='smoker' value='1'></label>
                            <label>Don't know<input type='radio' name='smoker' value='2' checked='checked'></label>";
                return $populate;
                break;
        }
    }
    
    function populateDiabetic($diabetic)
    {
        switch ($diabetic)
        {
            case 0:
                $populate = "<label>Yes<input type='radio' name='diabetic' value='0' checked='checked'></label>
                            <label>No<input type='radio' name='diabetic' value='1'></label>
                            <label>Don't know<input type='radio' name='diabetic' value='2'></label>";
                return $populate;
                break;
            case 1:
                $populate = "<label>Yes<input type='radio' name='diabetic' value='0'></label>
                            <label>No<input type='radio' name='diabetic' value='1' checked='checked'></label>
                            <label>Don't know<input type='radio' name='diabetic' value='2'></label>";
                return $populate;
                break;
            default:
                $populate  = "<label>Yes<input type='radio' name='diabetic' value='0'></label>
                            <label>No<input type='radio' name='diabetic' value='1'></label>
                            <label>Don't know<input type='radio' name='diabetic' value='2' checked='checked'></label>";
                return $populate;
                break;
        }
    }
    
    function operationAdd($operationlist)
    {
       $operationcode = '';
       $details = '';
       $count = 0;
       $populate = '';
       $closetable = false;
       $array = '';
       
       if(count($operationlist) > 0)//CHECK THAT VALUES HAVE BEEN INPUTTED INTO THE VARIABLE
       {

            $operationdetails = operationString($operationlist);
            foreach ($operationdetails as $arraydetails)
            {
                if ($count==0)
                {
                    $populate = "   <tr>
                                        <td></td>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <th>Code</th><th>Operation</th><th><input type='submit' name='operationremove' value='remove'></th>
                                                    </tr>";
                    $closetable = true;
                }
                
                foreach ($arraydetails as $individualdetails)
                {
                    $details .= $individualdetails . " ";
                }
                $operationcodequery = "SELECT `code` FROM `operation_code` WHERE `__kp_operationcode`='$operationlist[$count]'";
                $operationcode = queryExtraction(queryMysql($operationcodequery));
                
                $populate .= "  <tr><td>$operationcode</td>
                                    <td>$details</td>
                                    <td><input type='checkbox' name='remove[]' value='$count'></td><!--CREATE AN ARRAY OF CHECKBOXES-->
                                </tr>";
                $details = null;
                ++$count;
            }
            $populate .= "</table></td>";
        }
       
            
        $populate .= "<tr><td>Operation code</td><td><input type='text' name='operationcode' value=''>";
       
        return $populate;
    }
    
    function operationString($operationlist)//CONVERT THE LIST OF OPERATIONCODES INTO OPERATION NAMES
    {
        
        $operationdetails = array();//SET VARIABLE AS AN ARRAY
        
        foreach ($operationlist as $value)//LOOP THROUGH EACH OF THE ELEMENTS IN THE ARRAY
        {
            //EXTRACT THE DATA FROM SQL FOR EACH LEVEL USING THE OPERATIONCODE
            
            $specialityquery = "SELECT name FROM speciality LEFT JOIN operation_code ON speciality.__kp_speciality=operation_code._kf_speciality WHERE operation_code.__kp_operationcode='$value'";
            $level1query = "SELECT name FROM operation_level1 LEFT JOIN operation_code ON operation_level1.__kp_operationlevel1=operation_code._kf_operationlevel1 WHERE operation_code.__kp_operationcode='$value'";
            $level2query = "SELECT name FROM operation_level2 LEFT JOIN operation_code ON operation_level2.__kp_operationlevel2=operation_code._kf_operationlevel2 WHERE operation_code.__kp_operationcode='$value'";
            $level3query = "SELECT name FROM operation_level3 LEFT JOIN operation_code ON operation_level3.__kp_operationlevel3=operation_code._kf_operationlevel3 WHERE operation_code.__kp_operationcode='$value'";
            $level4query = "SELECT name FROM operation_level4 LEFT JOIN operation_code ON operation_level4.__kp_operationlevel4=operation_code._kf_operationlevel4 WHERE operation_code.__kp_operationcode='$value'";
            $sidequery = "SELECT name FROM side LEFT JOIN operation_code ON side.__kp_side=operation_code._kf_side WHERE operation_code.__kp_operationcode='$value'";
            
            $prefix = "|| ";
            
            $speciality = queryExtraction(queryMysql($specialityquery));
            $level1 = $prefix . queryExtraction(queryMysql($level1query));
            $level2 = $prefix . queryExtraction(queryMysql($level2query));
            $level3 = $prefix .queryExtraction(queryMysql($level3query));
            if($level3==$prefix .'None') $level3='';
            $level4 = $prefix . queryExtraction(queryMysql($level4query));
            $side = $prefix. "Side: ". queryExtraction(queryMysql($sidequery));
            
            //APPEND THE ARRAY OF OPERAITON DETAILS TO THE END OF THE ARRAY
            array_push ($operationdetails, array($speciality, $level1, $level2, $level3, $level4, $side));
        }
        
        return $operationdetails;
    }
    
    function operationRemove($operationcount)
    {
        
    }
    
    function operationLookup($operationcode, $side)
    {
        //LOOKUP THE OPERATION FOR THE OPERATIONCODE AND SIDE OF THE OPERATION AND EXTRACT DATA FROM OBJECT RETURNED
        $operationquery = "SELECT __kp_operationcode FROM operation_code WHERE code='$operationcode' AND _kf_side='$side'";
        
        $operation = queryExtraction(queryMysql($operationquery));
        
        return $operation;
    }
    
    function queryExtraction($query)//THIS FUNCTION EXTRACTS THE STRING FROM THE OBJECT RETURNED BY THE DATABASE AND STORES IT IN A VARIABLE
    {
        $queryreturn = '';
        $row = $query->fetch_array(MYSQLI_ASSOC);
        foreach ($row as $value)
        {
            $queryreturn .= $value;      
        }
        return $queryreturn;
    }
    

//ANYTHING BELOW THIS CAN BE IGNORED
/*
 is_array($operationlist) ? $array = "True" : $array = "False";
        $operationcount = count($operationlist);
        $test = $operationcount;
        //$operationcount = 1;
        if ($test = '')
        {//WHEN THIS IS THE FIRST ITERATION AND NO OPERATIONS HAVE BEEN ADDED
            $populate = "<td style='text-align:left'><input type='text' maxlength='' size='6' name='operationcode' value=''>;
            return $populate;
        }
        else  
        {//WHEN THERE HAVE BEEN OPERATIONS ADDED
            $operationdetails = operationString($operationlist);//OBTAIN THE DESCRIPTION OF THE OPERATIONS
            $operationname = '';
            $populate = "<td colspan='2'>
                            <table>
                                <tr>
                                    <th>Code</th><th colspan='2'>$array $test</th>
                                </tr><tr>";
                            

            for($i = 0; $i = $operationcount; ++$i)//LOOP THROUGH THE OPERATIONS ADDED APPENDING ROWS
            {
                for($j = 0; $j < 5; ++$j)
                {
                    $operationname .= $operationdetails[$i][$j]." ";
                }
                $operationname .= $operationdetails[$i][5];
                $operationcodequery = "SELECT `code` FROM `operation_code` WHERE `__kp_operationcode`=$operationlist[$i]";
                $operationcode = queryExtraction(queryMysql($operationcodequery));
                        
                $populate .= "  <td><input type='text' maxlength='' size='6' name='operationcode.$i' value=$operationcode readonly></td><td>$operationname</td><td><input id=$i type='submit' value='remove' name='operationremove.$i'></td>
                                <input type='hidden' name='operation.$i' value='$operationlist[$i]'>
                                </tr>
                            <tr>";   
            }
            //APPEND THE ADD BUTTON
            $populate .=    "</td></table><tr>
                                <td></td>
                                <td style='text-align:left'><input type='text' maxlength='' size='4' name='operationcode' value=''>";
            return $populate;
        }
            
*/
?>
<?php

    require_once 'header.php';
    
    if(!$loggedin) die();
    
    
    static $added = false;
    $operationcount = $var = $operation = $error = $operationcode = '';
    $remove = '';
    
    static $patientid = '';
    static $surgeonid = '';
    static $date = '';
    static $smoker = 2;
    static $diabetic = 2;
    $operation = '';
    $side = '';
    
    if (!isset($_SESSION['operationlist']))
    {
        $_SESSION['operationlist'] = array();
    }
    
    
    if (isset($_POST['addevent']))
    {
        //RESET ALL THE STATIC VARIABLES
        $patientid = '';
        $surgeonid = '';
        $date = '';
        $smoker = 2;
        $diabetic = 2;
        $var = "addevent";  
        
    }
    
    else if (isset($_POST['addpatient'])) header('Location: ' . $url.'addpatient.php');
    
    else if (isset($_POST['addsurgeon'])) header('Location: ' . $url.'addsurgeon.php');
    
    else if(isset($_POST['cancel']))
    {
        $_SESSION['operationlist'] = '';
        $patientid = '';
        $surgeonid = '';
        $date = '';
        $smoker = 2;
        $diabetic = 2;
    }
    
    else if(isset($_POST['operationremove']))
    {
            
        if(!empty($_POST['remove']))//IF A CHECKBOX HAS BEEN SELECTED
        {
            foreach($_POST['remove'] as $check)//LOOP THROUGH ALL TEH CHECKBOXES THAT HAVE BEEN SELECTED
            {
                unset($_SESSION['operationlist'][$check]);//REMOVE THE ELEMENT WITHOUT CHANGING THE INDEXING;
            }
            $_SESSION['operationlist'] = array_values($_SESSION['operationlist']);//RESET THE INDEXING OF THE ARRAY
        }
        $patientid = sanitiseString($_POST['patient']);
        $surgeonid = sanitiseString($_POST['surgeon']);
        $smoker = sanitiseString($_POST['smoker']);
        $diabetic = sanitiseString($_POST['diabetic']);
        $date = sanitiseString($_POST['date']);
    }
        
    else if(isset($_POST['operationadd']))
    {
        
        
        $patientid = sanitiseString($_POST['patient']);
        $surgeonid = sanitiseString($_POST['surgeon']);
        $smoker = sanitiseString($_POST['smoker']);
        $diabetic = sanitiseString($_POST['diabetic']);
        $date = sanitiseString($_POST['date']);
        
        $operationcode = sanitiseString($_POST['operationcode']);
        $side = sanitiseString($_POST['side']);
        
        $operation = operationLookup($operationcode, $side);//FIND THE OPERATION CODE FROM THE OPERATION AND THE SIDE
        
        if ($operation=='')
            {
                $error = 'Operation code: '. $operationcode .' is not valid';//IF NO OPERAITONS ARE RETURNED WITH THE OPERATION CODE THEN DISPLAY AND ERROR MESSAGE
            }
        else
            {
                array_push ($_SESSION['operationlist'], $operation);
                $operationcount = count($_SESSION['operationlist']);
            }
        
        
        
    }
    
        
    echo <<<_END
        <form method='post' action='addevent.php'>$var &nbsp || operation count: $operationcount || operationcode: $operationcode &nbsp $side &nbsp $operation<br>
        <table width='100%'  cellpadding='10'>
            <col width='30%'>
            <col width='70%'>
            
            <tr>
                <td style="text-align:right">Patient</td><td style="text-align:left"><select type='text' name='patient' value='$patientid'>
_END;

    echo populatePatient($patientid);
    
    echo <<<_END
                </select>&nbsp<input type='submit' value='New patient' name='addpatient'></td>
            </tr>
            <tr>
                <td style="text-align:right">Surgeon</td><td style="text-align:left"><select type='text' name='surgeon' value='$surgeonid'>
_END;

    echo populateSurgeon($surgeonid);
    
    echo <<<_END
                </select>&nbsp<input type='submit' value='New surgeon' name='addsurgeon'></td>
            </tr>
            <tr>
                <td style="text-align:right">Date of event</td><td style="text-align:left"><input type='date' maxlength='32' name='date' value='$date' placeholder='dd/mm/yyyy'></td>
            </tr>
            <tr>
                
            </tr>
            <tr>
                <td style="text-align:right">Is the patient a CURRENT smoker?</td>
                <td style="text-align:left">
_END;
                echo populateSmoker($smoker);
                    
                echo "</td></tr><tr><td style='text-align:right'>Is the patient diabetic?</td>
                <td style='text-align:left'>";
                
                echo populateDiabetic($diabetic);
                
                echo "</td></tr>";
           
            echo operationAdd ($_SESSION['operationlist']);
                
            echo <<<_END
            
            <!--Display the option to choose which side the operation is being performed on-->
            Side:&nbsp
                <label>Left<input type='radio' name='side' value='1'></label>
                <label>Right<input type='radio' name='side' value='2'></label>
                <label>Both<input type='radio' name='side' value='3'></label>
                <label>N/A<input type='radio' name='side' value='4' checked='checked'></label>

            <input type='submit' value='Add' name='operationadd'></td>
                
            </tr>
            
_END;
            
//NEED TO INCLUDE A HIDDEN FIELD SO THAT WHEN PATIENTS OR SURGEONS ARE ADDED THE USER CAN RETURN TO THIS PAGE

?>
            <tr></tr>
            <tr><td></td><td><input type='submit' value='Submit ' name='addevent'><input type='submit' value='Cancel' name='cancel'></td>
            </tr>
        </table>
        <br><br>
    </body>
</html>
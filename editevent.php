<?php
 require_once 'header.php';
    
    if(!$loggedin) die();
    
    $patientid = '';
    
    echo <<<_END
    <form method='post' action='addpatient.php'><br>
    <input type='hidden' name='patient' value='$patientid'>
    <table>
        <tr>
            <td>Search<input type='radio' name='search' value='type'></td>
        </tr>    
    
    </table>
    <input type='submit' name='search' value='Search'> <input type='submit' name='cancel' value='Cancel'>
    
_END;
?>
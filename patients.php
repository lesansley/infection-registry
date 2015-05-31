<?php
    require_once 'header.php';
    
    if (!$loggedin) die ();
    
    //POSTING ACROSS THE HIDDEN INPUT INFORMS WHETHER THE USER IS EDITING OR VIEWING
    echo <<<_END
    <table>
        <tr>
            <td>
                <form method="post" action="addpatient.php">
                    <input type="submit" value = "Add Patient">
                </form>
            </td>
            <td>
                <form method="post" action="findpatient.php">
                    <input type="hidden" name="editorview" value="edit">
                    <input type="submit" value="Edit Patient">
                </form>
            </td>
            <td>
                <form method="post" action="findpatient.php">
                    <input type="hidden" name="editorview" value="view">
                    <input type="submit" value="View Patient">
                </form>
            </td>
        </tr>
    </table>
_END;
?>
<br><br>
</body>
</html>
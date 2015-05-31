<?php
    require_once 'header.php';
    
    if (!$loggedin) die ();
   
echo <<<_END
    <table>
        <tr>
            <td>
                <form method="post" action="addevent.php">
                    <input type="submit" value = "Add Event">
                </form>
            </td>
            <td>
                <form method="post" action="findevent.php">
                    <input type="hidden" name="editorview" value="edit">
                    <input type="submit" value="Edit Event">
                </form>
            </td>
        </tr>
    </table>
_END;
?>
<br><br>
</body>
</html>
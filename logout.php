<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'functions.php';
session_start();

if (isset($_SESSION['member_id']))
{
    destroySession();
    echo <<<_END
<script>
document.location.href = 'index.html'
</script>
_END;
 }

else {
    echo <<<_END
<script>
document.location.href = 'index.html'
</script>
_END;
}
?>

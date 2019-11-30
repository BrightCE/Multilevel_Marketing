<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'functions.php';
session_start();
$member_id = $mesg = $member_name = "";
$validuser = FALSE; $p_title = "MLM::Member"; $p_name= "";

//check if session id isset
if (isset ($_SESSION['member_id']))
    {
        $member_id = $_SESSION['member_id'];
        $member_name = get_name($member_id);
        $validuser = TRUE;
        $p_name = "Welcome $member_name";
        $menu = 2; $c_page = "Home";
    }
//session not set,unidentified user
else{
    //redirect to login page
    echo <<<_END
<script>
document.location.href = 'login.php'
</script>
_END;
    exit;
}

//output page
if ($validuser)
        {

            f_header($p_title);
            f_menu($menu, $c_page);
            //display page
            f_content($p_name,$mesg);
            f_footer();
        }
?>

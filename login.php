<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Include funtion files
include 'functions.php';

//initialising variables
$email = $password = $member_id = $mesg = "";
$validuser = FALSE; $menu=1;
$p_title = "MLM::Login";$p_name= "Members Login";

//check if form was submitted
    if ((isset ($_POST['email']))&& isset ($_POST['password']))
        {
            //receive form variables for further processing
            $email = sanitizeString($_POST['email']);
            $password = sanitizeString($_POST['password']);

            //check if form was properly filled

            if ($email == "" || $password == "")
                {
                    $mesg = "Error: Not all fields were entered. Please try again.";
                }

           //email and password was entered
           else
                {
                    $password = sha1($password);
                    $query = "SELECT * FROM login
                        WHERE username ='$email' AND password='$password'";
                     $result = queryMysql($query);

                    if (mysqli_num_rows($result) == 0)
                        {
                            $mesg = "Sorry your email and password combination is incorrect. Please try again.";
                        }

                    else
                        {
                            //valid member, process query result
                            session_start();
                            $row = mysqli_fetch_row($result);
                            $_SESSION['member_id'] = $row[0];
                            $validuser = TRUE;
                            $menu = 1;

                            $mesg = "Welcome! Login was successful.<br>
                                        Please go to <a href = 'index.php'>Members </a>page now";

                            //redirect to members home page
                            
                            echo <<<_END
<script>
document.location.href = 'index.php'
</script>
_END;

                        }
                }


        }

   //form not submited
   else
    {
        $mesg = "Please enter your email and password to Login";

    }

    if ($validuser)
        {

            f_header($p_title);
            f_menu($menu);
            f_content($p_name,$mesg);
            f_footer();
        }
    else
        {
            f_header($p_title);
            f_menu($menu);
            f_content($p_name,$mesg);
            f_loginform();
            f_footer();
        }
?>

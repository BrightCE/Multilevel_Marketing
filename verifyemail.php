<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'functions.php';

if (isset($_POST['email']))
    {
        $email = sanitizeString($_POST['email']);
        if(valid_email($email))
            {
                $code = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,8);;
                $message ="Thanks for your interest in MLM.\n
                            To continue with your registration, please enter this code in the feild provided.\n
                                $code \n
                                  Thank you.";
                  $subject = "MLM Code";
                  $headers = 'From: noreply@mlm.com' . "\r\n" .
                                'X-Mailer: PHP/' . phpversion();

                    if(mail($email, $subject, $message, $headers))
                        {
                            $q_validt = "INSERT INTO validate VALUES ('$email','$code')";
                            if(queryMysql($q_validt))
                                {
                                    echo "Code sent";
                                }
                                else{
                                    echo "";
                                }
                        }
                        else{
                            echo "not sent";
                        }


            }
            else{
                echo "Not valid!";
            }
    }
?>

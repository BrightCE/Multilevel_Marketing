<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Include funtion files
include 'functions.php';

$p_title = "MLM::Enroll";$p_name= "Membership Enrollment.";
$display_form = TRUE; $menu= 1; $p_form = FALSE;
$mesg = "To enroll, please fill the form bellow correctly";
$c_Page = "Enrol";

//check if form feilds are filled
if (isset($_POST['s_name'])&& isset($_POST['f_name']))
    {
     if(filled_out($_POST))
        {
            //process form variables
            $s_name = sanitizeString($_POST['s_name']);
            $f_name = sanitizeString($_POST['f_name']);
            $phone = sanitizeString($_POST['phone']);
            $email = sanitizeString($_POST['email']);
            $address = sanitizeString($_POST['address']);
            $sponsor_id = sanitizeString($_POST['sponsor_id']);
            $level = sanitizeString($_POST['level']);
            $code = sanitizeString($_POST['code']);

            $formdata = array($s_name,$f_name,$phone,$address,$sponsor_id);
            /*  validate form data. if valid, continue processing else,
            output error message and form with submitted values again.

            */
            $sponsor_id = checksponsor($sponsor_id);
        if($sponsor_id == 0)
            {
                //the member cant sponsor a new member. output mesg and form
                $mesg = "Please enter another sponsor id.";

            }
        //check if email is valid
        elseif(verifycode($code,$email))
            {
                //save data temporaryly in session.
                session_start();
                $_SESSION['s_name'] = $s_name;
                $_SESSION['f_name'] = $f_name;
                $_SESSION['phone'] = $phone;
                $_SESSION['email'] = $email;
                $_SESSION['address'] = $address;
                $_SESSION['sponsor_id'] = $sponsor_id;
                $_SESSION['level'] = $level;

                $p_form = TRUE; $display_form = FALSE;
                $mesg = "Please choose a password to complete your registration.";
                        }
            else    {
                    $mesg = "Your email could not be verified at this time.
                        Please try enrolling again later.";
                }

            }

        else{
            $mesg = "Please Fill all form feilds with correct data.";
        }
    }
else if(isset($_POST['password']) && isset($_POST['password2']))
    {
        //process password
        if(filled_out($_POST))
            {
                $password = sanitizeString($_POST['password']);
                $password2 = sanitizeString($_POST['password2']);
                if($password == $password2)
                    {
                        //retrive session variables and store in database
                        session_start();
                        $s_name = $_SESSION['s_name'] ;
                        $f_name = $_SESSION['f_name'] ;
                        $phone = $_SESSION['phone'] ;
                        $email = $_SESSION['email'] ;
                        $address = $_SESSION['address'] ;
                        $sponsor_id = $_SESSION['sponsor_id'] ;
                        $level = $_SESSION['level']  ;
                        $password = sha1($password);
                        $q_member = "INSERT INTO members(s_name,f_name,phone,email,address)
                                VALUES('$s_name','$f_name','$phone','$email','$address')";
                $member_id = insertMysql($q_member);
                if($member_id)
                    {
                        //enter other details with the generated member id.
                        
                        $q_gegy ="INSERT INTO genealogy
                                    VALUES('$member_id','$sponsor_id')";
                        $q_cat = "INSERT INTO category
                                    VALUES('$member_id','$level')";
                        $q_pswd = "INSERT INTO login
                                    VALUES('$member_id','$email','$password')";
                         if( queryMysql($q_cat) && queryMysql($q_pswd)&& queryMysql($q_gegy))
                              {
                                  //details saved successfully, redirect to members home page
                                  $mesg = "Your registration is complete.";
                                   $p_form = FALSE; $display_form = TRUE;

                                   $_SESSION['member_id'] = $member_id;
                                   $_SESSION['email'] = "";$_SESSION['s_name']="" ; $_SESSION['f_name']="" ; $_SESSION['phone']="" ;
                                   $_SESSION['address']="" ; $_SESSION['sponsor_id'] =""; $_SESSION['level']="" ;
                                   //send welcome email...

 echo <<<_END
<script>
document.location.href = 'index.php'
</script>
_END;

                              }
                           else{
                                    $mesg = "An unexpected error occured, please contact the web master.";
                                    $formdata = array();
                                }

                            }
                    else{
                            $mesg = "Sorry, your data could not be saved at this time, please try again later.";
                        }
                    }
                    else{
                        $mesg = "Sorry passwords do not match. please try again.";
                        $p_form = TRUE; $display_form = FALSE;
                    }
            }
            else{
                $mesg ="Please enter password.";$p_form = TRUE; $display_form = FALSE;
            }

    }
//output page

        f_header($p_title);
        f_menu($menu,$c_Page);
        f_content($p_name,$mesg);
 if($display_form)
      {
          f_signupform($formdata);
      }
  else if($p_form)
      {
         f_pswdform();
      }
      f_footer();

      //ajax function to send email verification code
      echo <<<_END
<script>

function verifyemail(email)
{
    if (email.value == '')
    {
        document.getElementById('info').innerHTML = ''
        return
    }

    params  = "email="+email.value
    request = new ajaxRequest()
    request.open("POST", "verifyemail.php", true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.setRequestHeader("Content-length", params.length)
    request.setRequestHeader("Connection", "close")

    request.onreadystatechange = function()
    {
        if (this.readyState == 4)
            if (this.status == 200)
                if (this.responseText != null)
                    document.getElementById('info').innerHTML = this.responseText
    }
    request.send(params)
}

function ajaxRequest()
{
    try { var request = new XMLHttpRequest() }
    catch(e1) {
        try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        catch(e2) {
            try { request = new ActiveXObject("Microsoft.XMLHTTP") }
            catch(e3) {
                request = false
    }   }   }
    return request
}

</script>

_END;

?>

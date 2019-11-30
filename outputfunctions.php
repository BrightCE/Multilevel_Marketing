<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// functions to Output HTML
// function to display the page head section
function f_header($var)
    {
echo <<<_END

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>$var</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="css/templatemo_style.css" rel="stylesheet" type="text/css" />

        <link href="css/svwp_style.css" rel="stylesheet" type="text/css" />
        <script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script src="js/jquery.slideViewerPro.1.0.js" type="text/javascript"></script>

        <!-- Optional plugins  -->
        <script src="js/jquery.timers.js" type="text/javascript"></script>


        </head>
_END;
    }

//function to display the page body opening tag and menu bar
function f_menu($typ,$currentpg)
    {
echo <<<_END
        <body>

<div id="templatemo_header_wrapper">
	<div id="templatemo_header">

    	<div id="site_title">
            <h1><a href="#"><img src="images/logo2.png" alt="logo" /><span>Multi Level Marketing Platform</span></a></h1>
      	</div> <!-- end of site_title -->
_END;

    if($typ == 1)
    {
        
        $m_items = array("Home", "Get A Job","Make Money","Enrol","Testimonial","Contact");
        $link = array("index.html", "getajob.html", "makemoney.html", "enroll.php", "testimonial.html", "contact.html");

       echo "<div id='templatemo_menu'>
            <ul>";
            for($i = 0; $i < 6; $i++)
                {
                     if($m_items[$i]==$currentpg)
                        {
                             echo "<li><a href='$link[$i]' class='current'>$currentpg</a></li>" ;
                        }
                    else
                        {
                            echo "<li><a href='$link[$i]' >$m_items[$i]</a></li>";
                        }
                }
               

                echo <<<_END
            </ul>
        </div> <!-- end of templatemo_menu -->

    </div>
</div> <!-- end of templatemo_header -->

<div id="templatemo_middle_wrapper">
	<div id="templatemo_middle">

_END;
    }
    else
        {
            //create an array of Menu items
            $m_items = array("Home", "Training","Downlines","Commission","Prospects","Logout");
            $link = array("index.php", "training.php", "downline.php", "commission.php","prospects.php","logout.php");
            echo "<div id='templatemo_menu'>
            <ul>";
            //itetrate through array
            for ($i = 0; $i < 6; $i++)
                {
                    if($m_items[$i]==$currentpg)
                        {
                            
                           echo "<li><a href='$link[$i]' class='current'>$currentpg</a></li>" ;
                        }
                    else
                        {
                            
                            echo "<li><a href='$link[$i]' >$m_items[$i]</a></li>";
                        }
                }

            echo <<<_END
            
                </ul>
        </div> <!-- end of templatemo_menu -->

    </div>
</div> <!-- end of templatemo_header -->

<div id="templatemo_middle_wrapper">
	<div id="templatemo_middle">
_END;
        }
    }

//function to display page content
function f_content($p_name,$mesg)
    {
echo <<<_END
    <div id="templatemo_content">

            <div class="content_box_wrapper">
            	<div class="content_box">

                        <h4>$p_name</h4>

                        <p>$mesg</p>

                        <div class="cleaner"></div>

_END;
    }

//outputs login form
function f_loginform()
    {
echo <<<_END
   
                     <div class="contact_form">
                   
                    <form name="login" action="login.php" method="POST">
                        <table border="0" cellspacing="10">

                            <tbody>
                                <tr>
                                    <td>Your email </td>
                                    <td><input type="text" name="email" value="" /></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td><input type="password" name="password" value="" /></td>
                                </tr>
                                <tr>
                                    <td align ="left"><a href="resetpassword.php"><small>Forgot password?</small></a></td>
                                    <td align="right"><input type="submit" class="submit_btn float_r" value="Login" /></td>
                                </tr>

                            </tbody>
                        </table>

                    </form>
                    </div><!-- end of contact form-->
                    <div class="cleaner"></div>
                

_END;
    }

//displays page footer
function f_footer()
    {
echo <<<_END
    </div> <!-- end of content_box -->
            </div> <!-- end of content_box_wrapper -->

    </div> <!-- end of templatemo_content -->
   </div>

    <div id="templatemo_copyright">
        Copyright © 2014 <a href="#">Your Company Name</a> | Designed by <a href="http://www.brightprogrammes.com" target="_blank">Bright Programmes</a>
    </div>

 </div><!-- end of templatemo_content_wrapper -->

</body>
</html>


_END;
    }

//function to display signup form
function f_signupform($var)
    {
      echo <<<_END
        <div class="contact_form">

            <h4>Signup Form</h4>

              <form method="post" name="signup" action="enroll.php">

                        <div class="col_w300 float_l">
                        <label>Surname:</label> <input type="text" name="s_name" value = "$var[0]" class="required input_field"/>
                            <div class="cleaner_h10"></div>
                        <label>Firstname:</label> <input type="text" name="f_name" value = "$var[1]" class="required input_field"/>
                            <div class="cleaner_h10"></div>
                        <label>Phone:</label> <input type="text" name="phone" value = "$var[2]" class="required input_field"/>
                            <div class="cleaner_h10"></div>
                        <label>Email: <span id = "info"> </span></label> <input type="text" name="email" value = "" onBlur='verifyemail(this)' class="required input_field"/>
                            <div class="cleaner_h10"></div>
                            <div class="cleaner_h20"></div>
                            <input type="reset" class="submit_btn float_r" name="reset" id="reset" value="Reset" />
                        </div>

                        <div class="col_w300 float_r">
                        <label>Address:</label> <input type="text" name="address" value = "$var[3]" class="required input_field"/>
                            <div class="cleaner_h10"></div>
                        <label>Sponsor ID Number:</label> <input type="text" name="sponsor_id" value = "$var[4]" class="required input_field"/>
                            <div class="cleaner_h10"></div>
                         <label>Membership Level:</label><select name="level" class="required input_field">
                                                            <option>- Select Level -</option>
                                                            <option value= "1">Low</option>
                                                            <option value= "2" >Medium</option>
                                                            <option value= "3">High</option>
                                                         </select>
                            <div class="cleaner_h10"></div>
                         <label>Validation code:</label> <input type="text" name="code" value = "" class="required input_field"/>
                            <div class="cleaner_h10"></div>
                          <div class="cleaner_h20"></div>
                          <input type="submit" class="submit_btn float_l" name="submit" id="submit" value="Send" />
                          
                          </div>
                        </form>
                          </div>
            		<div class="cleaner"></div>
_END;

    }

    //display password form
  function f_pswdform()
    {
        echo <<<_END
        <div class="contact_form">

            <h4>Signup Form</h4>

              <form method="post" name="signup" action="enroll.php">

                        <div class="col_w300 float_l">
                        <label>Password:</label> <input type="password" name="password" value = "" class="required input_field"/>
                            <div class="cleaner_h10"></div>
                        <label>Repeat password:</label> <input type="password" name="password2" value = "" class="required input_field"/>
                            <div class="cleaner_h10"></div>
                            <div class="cleaner_h20"></div>
                            <input type="reset" class="submit_btn float_l" name="reset" id="reset" value="Reset" />
                            <input type="submit" class="submit_btn float_r" name="submit" id="submit" value="Send" />
                        </div>

                            <div class="cleaner_h10"></div>
                          <div class="cleaner_h20"></div>

                        </form>
                          </div>
            		<div class="cleaner"></div>
_END;

    }





?>
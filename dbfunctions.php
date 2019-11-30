<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//establishes a database connection
function dbconnect()
    {
        @ $db = new mysqli('localhost', 'mlmapp', 'mlmpswd', 'mlm');

        if (mysqli_connect_error())
            {
                die('Could not connect: ' . mysqli_connect_error());
            }

        return $db;
    }

//creates a database table
function createTable($name, $query)
    {
        queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
        echo "Table '$name' created or already exists.<br />";
    }

//queries a database
function queryMysql($query)
    {
        $conn = dbconnect();
        $result = $conn->query($query) or die (mysqli_error($conn));
        return $result;
    }
 //insert querry function
 function insertMysql($query)
    {
        $conn = dbconnect();
        $conn->query($query) or die (mysqli_error($conn));
        $id = $conn->insert_id;
        return $id;
    }

//get member name using member id as search value
function get_name($id)
    {
        $qry = "select s_name, f_name from members where member_id = '$id'";
        $row = mysqli_fetch_row(queryMysql($qry));
        $name = "$row[0], $row[1]";
        return $name;
    }

//checks if submitted code is same as one saved in database
function verifycode($code, $email)
    {
        $query = "SELECT * FROM validate
                        WHERE email ='$email' AND code ='$code'";
         if (mysqli_num_rows(queryMysql($query)) == 0)
            {
                //code and email combination does not exist
                return FALSE;
            }
         else {
             return TRUE;
         }
    }

//checks if submitted sponsor has completed his quota
//and if so, gets an available downline's id as sponsor
function checksponsor($s_id)
    {
        $p = $h= $z= $t= 0;
        //query genealogy table
        //first generation
        $query = "SELECT * FROM genealogy
                    WHERE parent_id = '$s_id'";
         $result = queryMysql($query);
         if (mysqli_num_rows($result) < 5)
            {
                //member can still sponsor a new member directly
                return $s_id;
                break;
            }
        else{
                // itetrate through members of his generation to
                //find an available slot then return the member's id.

               for($i = 0; $i < mysqli_num_rows($result); $i++)
                    {
                        //second generation
                        $row = mysqli_fetch_row($result);
                        $q = "SELECT * FROM genealogy
                                    WHERE parent_id = '$row[0]'";
                        $r = queryMysql($q);
                        if (mysqli_num_rows($r)<5)
                            {
                                return $row[0];break;
                            }
                        else{
                                for($x = 0; $x < 5; $x++)
                                {
                                    $gen3[$p] = mysqli_fetch_row($r);
                                    $p++;
                                }

                        }
                    }
                    //Third generation itetration loop
                for ($j = 0; $j < count($gen3); $j++)
                    {
                        //third generation
                        $t_row = $gen3[$j];
                        $q_3 = "SELECT * FROM genealogy
                                  WHERE parent_id = '$t_row[0]'";
                         $r_3 = queryMysql($q_3);
                          if (mysqli_num_rows($r_3)<5)
                            {
                                return $t_row[0]; break;
                            }
                          else{
                                for($x = 0; $x < 5; $x++)
                                {
                                    $gen4[$h] = mysqli_fetch_row($r_3);
                                    $h++;
                                }
                          }
                    }

                    //Fourth generation itetration loop
                    for ($k = 0; $k < count($gen4); $k++)
                        {
                            //fouth generation
                            $f_row = $gen4[$k];
                            $q_4 = "SELECT * FROM genealogy
                                  WHERE parent_id = '$f_row[0]'";
                            $r_4 = queryMysql($q_4);
                          if (mysqli_num_rows($r_4)< 5)
                            {
                                return $f_row[0]; break;
                            }
                          else{
                                for($x = 0; $x < 5; $x++)
                                {
                                    $gen5[$z] = mysqli_fetch_row($r_4);
                                    $z++;
                                }
                          }

                        }
                   //fifth generation itetration
                   for ($m = 0; $m < count($gen5); $m++)
                        {
                            //fouth generation
                            $v_row = $gen5[$m];
                            $q_5 = "SELECT * FROM genealogy
                                  WHERE parent_id = '$v_row[0]'";
                            $r_5 = queryMysql($q_5);
                          if (mysqli_num_rows($r_5)< 5)
                                 {
                                    return $v_row[0]; break;
                                 }
                          else{
                                if($m == 624)
                                    {
                                        return 0; break;
                                    }
                                 else{
                                        for($x = 0; $x < 5; $x++)
                                                {
                                                    $gen6[$t] = mysqli_fetch_row($r_5);
                                                    $t++;
                                                }
                                 }
                           }
                    }
             }
    }

    //function to count downlines and display
    //a summary of result and link button to
    //show details.
    function dl_summary($id)
        {
            $n1 = $n2 = $n3 = $n4 = $n5 = 0;
            $g1 = $g2=$g3= $g4= $g5= 0;
            $mesg = array();

            $q1= "SELECT * FROM genealogy
                    WHERE parent_id = '$id'";
            $result = queryMysql($q1);
            if(mysqli_num_rows($result)>0)
                {
                    $n1 = mysqli_num_rows($result);


                    $mesg1= "First generation: $n1 members. <br>" ;
                    for($x = 0; $x < mysqli_num_rows($result);$x++)
                             {
                                  $gen1[$g1] = mysqli_fetch_row($result);
                                    $g1++;
                              }
                    //get number of second generation members.
                    $mesg[0]= $mesg1;
                    $mesg[1]= $gen1;
                    for ($i = 0; $i< $n1; $i++)
                        {
                            $row = $gen1[$i];
                            $q2 = "SELECT * FROM genealogy
                                    WHERE parent_id = '$row[0]'";
                             $r2 = queryMysql($q2);
                             if(mysqli_num_rows($r2)>0)
                                {
                                  $n2 += mysqli_num_rows($r2);
                                  for($x = 0; $x < mysqli_num_rows($r2);$x++)
                                        {
                                            $gen2[$g2] = mysqli_fetch_row($r2);
                                                $g2++;
                                        }

                                }


                        }//end second generation loop

                    if($n2 > 0)
                        {
                            $mesg1 .= "Second generation: $n2 members.<br>";
                            $mesg[0] = $mesg1;
                            $mesg[2] = $gen2;
                    
                    //get number of third generation members
                    
                     for ($i = 0; $i< $n2; $i++)
                        {
                            $row = $gen2[$i];
                            $q3 = "SELECT * FROM genealogy
                                    WHERE parent_id = '$row[0]'";
                             $r3 = queryMysql($q3);
                             if(mysqli_num_rows($r3)>0)
                                {
                                  $n3 += mysqli_num_rows($r3);
                                  for($x = 0; $x < mysqli_num_rows($r3);$x++)
                                        {
                                            $gen3[$g3] = mysqli_fetch_row($r3);
                                                $g3++;
                                        }
                                 }

                         }//end third generation loop
                   
                   if($n3 > 0)
                        {
                          $mesg1 .= "Third generation: $n3 members.<br>";
                          $mesg[0] = $mesg1;
                            $mesg[3] = $gen3;
                   //get number of fourth generation members
                   for ($i = 0; $i< $n3; $i++)
                        {
                            $row = $gen3[$i];
                            $q4 = "SELECT * FROM genealogy
                                    WHERE parent_id = '$row[0]'";
                             $r4 = queryMysql($q4);
                             if(mysqli_num_rows($r4)>0)
                                {
                                  $n4 += mysqli_num_rows($r4);
                                  for($x = 0; $x < mysqli_num_rows($r4);$x++)
                                        {
                                            $gen4[$g4] = mysqli_fetch_row($r4);
                                                $g4++;
                                        }
                                 
                                }

                         }//end fourth generation loop
                     
                     if($n4 > 0)
                        {
                            $mesg1 .= "Fourth generation: $n4 members.<br>";
                            $mesg[0] = $mesg1;
                            $mesg[4] = $gen4;
                     //get number of fifth generation members
                     for ($i = 0; $i< $n4; $i++)
                        {
                            $row = $gen4[$i];
                            $q5 = "SELECT * FROM genealogy
                                    WHERE parent_id = '$row[0]'";
                             $r5 = queryMysql($q5);
                             if(mysqli_num_rows($r5)>0)
                                {
                                  $n5 += mysqli_num_rows($r5);
                                   for($x = 0; $x < mysqli_num_rows($r5);$x++)
                                        {
                                            $gen5[$g5] = mysqli_fetch_row($r5);
                                                $g5++;
                                        }
                                }

                         }//end fifth generation loop
                        
                         if($n5 > 0)
                        {
                            $mesg1 .= "Fifth generation: $n5 members.<br>";
                            $mesg[0] = $mesg1;
                            $mesg[5] = $gen5;
                        }
                        else{
                            return $mesg;
                        }
                    }//end if of 4th generation
                        else{
                            return $mesg;
                        }
                     
                     
                      
                        
                    }//end if of 3rd generation
                        else{
                            return $mesg;
                        }
                   

                        }//end if for 2nd generation
                        else{
                            return $mesg;
                        }

                }//end if
                else {
                    $mesg[0] = "Sorry you do not have downlines yet.";
                    return $mesg;
                }//end no downline condition

           //return function value

           return $mesg;
        }//end downline summary function

//function to output table of downline members in their respective generations
function display_gen_detail($downlines)
    {
        echo "<div class='cleaner'></div>".
                "<h4>Downline details</h4>";
        $gen_name = array("","First","Second","Third","Fourth","Fifth");

        for($i = 1; $i < count($downlines); $i++)
            {

                if($downlines[$i] != "")
                    {
                       $gen = $downlines[$i];
                       echo "<h5>$gen_name[$i] generation.</h5>";
                       echo "<table border = '1'>
                                 <thead>
                                    <tr>
                                    <th>Sponsor ID</th>
                                    <th>Member ID</th>
                                    <th>Member Name</th>
                                    </tr>
                                </thead>
                            <tbody>";
                       for ($x = 0; $x < count($gen); $x++)
                            {
                                $row = $gen[$x];
                                $name = get_name($row[0]);
                                echo "<tr>
                                        <td>$row[1]</td>
                                        <td>$row[0]</td>
                                        <td>$name</td>
                                      </tr>";
                            }
                         echo"</tbody>
                            </table>
                                <div class='cleaner'></div>
                                <div class='cleaner_h20'></div>";
                    }
                    else return "";
            }
    }




?>

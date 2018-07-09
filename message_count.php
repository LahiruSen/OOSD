<?php
/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 7/9/2018
 * Time: 8:41 AM
 */

require 'db.php';

    if(isset($_GET['user_id']))
    {


        $user_id = $_GET['user_id'];




        $result=$mysqli->query("SELECT COUNT(id) as counts FROM notifications WHERE target_user_ids = '$user_id' and delete_receiver='0' and is_seen='0'");




        if($result->num_rows >0)
        {




            $data = $result->fetch_assoc();



            echo $data['counts'];

        }else
        {
            echo '0';
        }



    }else
        {


            if(isset($_POST['msg_id']))
            {


                $msg_id = $_POST['msg_id'];



                if($mysqli->query("UPDATE notifications  SET is_seen='1'  WHERE id='$msg_id'"))
                {




                    echo $msg_id;

                }else
                {
                    echo '0';
                }



            }else
            {

                echo '0';

            }



        }





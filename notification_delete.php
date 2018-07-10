<?php
/**
 * Created by PhpStorm.
 * User: BlackLion
 * Date: 7/9/2018
 * Time: 8:41 AM
 */

require 'db.php';

if (session_status() == PHP_SESSION_NONE) {    session_start();}

    if(isset($_GET['id']))
    {

        $id = $_GET['id'];

        if(isset($_GET['types']))
        {

            $types = $_GET['types'];


            if($types=="sender")
            {

                $result = $mysqli->query("SELECT * FROM notifications WHERE id='$id'");


                if($result->num_rows>0)
                {

                    $data= $result->fetch_assoc();



                    if($data['delete_receiver'] == 1)
                    {

                        $sql="DELETE FROM notifications WHERE id='$id'";


                        if($mysqli->query($sql))
                        {

                            $_SESSION['message'] = "You have successfully deleted the notification";
                            header("location:error.php");


                        }else
                            {


                                $_SESSION['message'] = "Something went wrong";
                                header("location:error.php");

                            }




                    }else
                        {

                            $sql="UPDATE notifications  SET delete_sender='1'  WHERE id='$id'";


                            if($mysqli->query($sql))
                            {

                                $_SESSION['message'] = "You have successfully deleted the notification";
                                header("location:error.php");


                            }else
                            {


                                $_SESSION['message'] = "Something went wrong";
                                header("location:error.php");

                            }

                        }




                }else
                {

                    $_SESSION['message'] = "Can't find the notification";
                    header("location:error.php");

                }






            }elseif ($types=="receiver")
            {




                $result = $mysqli->query("SELECT * FROM notifications WHERE id='$id'");


                if($result->num_rows>0)
                {

                    $data= $result->fetch_assoc();



                    if($data['delete_sender'] == 1)
                    {

                        $sql="DELETE FROM notifications WHERE id='$id'";


                        if($mysqli->query($sql))
                        {

                            $_SESSION['message'] = "You have successfully deleted the notification";
                            header("location:error.php");


                        }else
                        {


                            $_SESSION['message'] = "Something went wrong";
                            header("location:error.php");

                        }




                    }else
                    {

                        $sql="UPDATE notifications  SET delete_receiver='1'  WHERE id='$id'";


                        if($mysqli->query($sql))
                        {

                            $_SESSION['message'] = "You have successfully deleted the notification";
                            header("location:error.php");


                        }else
                        {


                            $_SESSION['message'] = "Something went wrong";
                            header("location:error.php");

                        }

                    }




                }else
                {

                    $_SESSION['message'] = "Can't find the notification";
                    header("location:error.php");

                }




            }else
                {


                    $_SESSION['message'] = "Wrong type parameter";
                    header("location:error.php");
                }



        }else
            {

                $_SESSION['message'] = "Parameter error";
                header("location:error.php");

            }


    }else
        {

            $_SESSION['message'] = "Parameter error";
            header("location:error.php");


        }





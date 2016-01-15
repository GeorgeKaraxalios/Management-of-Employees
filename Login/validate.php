<?php

include "$_SERVER[DOCUMENT_ROOT]/kataxorisis/connector.php";


$username=$_POST['username'];
$password=$_POST['password'];

var_dump($_POST);
$con=new Connector();

$res=$con->prepare('select * from login where UserName=? and Password=?',array($username,$password));
if($row=$res->fetch()){
    session_start();
    $_SESSION['username']=$username;
    $_SESSION['password']=$password;
    //header("Location:$_SERVER[DOCUMENT_ROOT]/kataxorisis/"); exit;
    echo "<script>window.location.replace('http://192.168.1.184/kataxorisis');</script>";
}else{
    echo "wrong";
    echo "<script>window.location.replace('http://192.168.1.184/kataxorisis/Login/index.php?error=1');</script>";
    //header("Location:$_SERVER[DOCUMENT_ROOT]/kataxorisis/Login?error=1");exit;
    
}

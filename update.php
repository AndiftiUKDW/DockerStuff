<?php
session_start();
$base_url = ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'http') . '://' . ($_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
  header("Location: $base_url/login.php");
  exit();
}
$email = isset($_SESSION['email']) ? $_SESSION['email'] : (isset($_COOKIE['email']) ? $_COOKIE['email'] : '');
$isLoggedIn = isset($_SESSION['email']) || isset($_COOKIE['email']);


include_once("connection.php");
if($_POST){
    $email = (array) $_POST['email'];
    $name = (array) $_POST['name'];
    $DoB = (array) $_POST['DoB'];
    $gender = (array) $_POST['gender'];
    $phoneNum = (array) $_POST['phoneNum'];
    $Identity = (array) $_POST['Identity'];
    $Address = (array) $_POST['Address'];
    $detailid = (array) $_POST['detailid'];
    for($i=0;$i<sizeof($email);$i++){
        $sql = "UPDATE detail_order set nama='{$name[$i]}', email='{$email[$i]}', dob='{$DoB[$i]}', gender='{$gender[$i]}', phonenum={$phoneNum[$i]}, nik='{$Identity[$i]}', address='{$Address[$i]}' where id={$detailid[$i]}";
        $result = mysqli_query($conn,$sql);
    }
    header("location:$base_url/histori.php");
}
header("location:$base_url/index.php");
?>
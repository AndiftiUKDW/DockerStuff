<?php
session_start();
include_once("connection.php");

if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
  header("Location: $base_url/login.php");
  exit();
}
$email = isset($_SESSION['email']) ? $_SESSION['email'] : (isset($_COOKIE['email']) ? $_COOKIE['email'] : '');
$isLoggedIn = isset($_SESSION['email']) || isset($_COOKIE['email']);


if($_POST){
    $id = $_POST['orderid'];
    $sql = "DELETE from ordered where orderid=$id";
    $sql2 = "DELETE from detail_order where id_order=$id";
    $run = mysqli_query($conn,$sql);
    $run2 = mysqli_query($conn,$sql2);
    header("location:$base_url/histori.php");
} else {
    header("location:$base_url/index.php");
}

?>
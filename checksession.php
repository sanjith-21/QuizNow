<?php
if (!isset($_SESSION["uid"]) || !isset($_SESSION["uname"]) || !isset($_SESSION["utype"])) {

    header("Location: index.php");
    exit();
} else {
    $con = new mysqli("localhost:3307", "root", "", "quiz") or die("Connection Failed: %s\n".$con->error);
    $uid = $_SESSION["uid"];
    $uname = $_SESSION["uname"];
    $utype = $_SESSION["utype"];
}
?>
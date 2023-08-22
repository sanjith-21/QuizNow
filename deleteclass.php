<?php

session_start();
require('checksession.php');
if (isset($_REQUEST['id'])) {
    $con->query("delete from class_room where cid='" . $_REQUEST['id'] . "'");
    header("Location: setting.php");
} else if (isset($_REQUEST['uid'])) {
    $sid = "";
    $sqlll = "select * from class_room where sid like '%" . $_REQUEST['uid'] . "%' and cid like '%" . $_REQUEST['cid'] . "%'";
    $result = $con->query($sqlll);
    while ($rows = $result->fetch_assoc()) {
        $sid = $rows["sid"];
    }
    if (strpos($sid, ",") !== false){
        $sid = str_replace("," . $_REQUEST['uid'], "", $sid);
        $temp = $_REQUEST['uid'];
        $result22 = $con->query("DELETE FROM qattempt WHERE sid='$temp'");
    } else {
        $sid = null;
        $temp1 = $_REQUEST['uid'];
        $result222 = $con->query("DELETE FROM qattempt WHERE sid='$temp1'");
    }
    $con->query("update class_room set sid='$sid' where cid='" . $_REQUEST['cid'] . "'");
    header("Location: class_room.php?no=" . $_REQUEST['cid']);
}
?>
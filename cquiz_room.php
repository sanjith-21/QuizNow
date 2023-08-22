<!DOCTYPE html>
<?php
session_start();
$photo = "profile.jpg";
require('checksession.php');
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icon.png">
    <title>Quiz Management</title>
    <style>
        * {
            margin: 0px;
            box-sizing: border-box;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }

        .header {
            width: 100%;
            font-size: 30px;
            background-color: #0ead88;
            padding: 10px 30px 10px 10px;
            font-family: timesnewroman;
            color: white;
        }

        .img_style {
            width: 35px;
            height: 35px;
            float: left;
            margin-right: 10px;
        }

        body {
            font-family: Arial;
        }

        .tabcontent {
            float: right;
            padding: 10px 15px;
            width: 74%;
        }

        .menu {
            float: left;
            padding: 20px 15px;
            width: 25%;
        }

        fieldset {
            border: 3px solid white;
            border-style: groove;
            padding: 15px;
            height: 520px;
        }

        .logoutbutton {
            width: 50%;
            color: white;
            padding: 10px;
            border-radius: 20px;
            font-weight: bolder;
            background-color: #0ead88;
        }

        .logoutbutton:hover {
            box-shadow: 0px 0px 5px 2px grey;
            background-color: #0ead99;
        }

        .question {
            width: 80%;
            padding: 10px;
            font-size: 20pt;
            background-color: #0ead88;
            box-shadow: 0px 0px 5px 2px grey;
        }

        .question textarea {
            width: 90%;
            font-weight: lighter;
            font-size: 18pt;
            resize: none;
        }

        .answer {
            width: 80%;
            padding: 10px;
            font-size: 18pt;
            border: 2px solid #0ead88;
            box-shadow: 0px 0px 5px 2px grey;
        }

        .correctanswer {
            width: 80%;
            padding: 10px;
            font-size: 20pt;
            margin-bottom: 10px;
            background-color: #0ead88;
            box-shadow: 0px 0px 5px 2px grey;
        }

        .answerinput {
            width: 80%;
            margin: 5px;
            font-weight: lighter;
            font-size: 18pt;
        }

        .addbutton {
            float: left;
            margin-left: 100px;
        }

        .addbutton input {
            border: none;
            padding: 10px;
            color: white;
            font-weight: bolder;
            border-radius: 10px;
            background-color: #0ead88;
        }

        .savebutton {
            float: right;
            margin-right: 100px;
        }

        .savebutton input {
            border: none;
            padding: 10px;
            color: white;
            font-weight: bolder;
            border-radius: 10px;
            background-color: #0ead88;
        }

        .scroll {
            overflow-y: scroll;
            width: 100%;
            height: 520px;
        }

        .tableview {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-size: 10pt;
        }

        .tableview th {
            font-size: 15pt;
        }

        #currenttime {
            padding: 5px;
            width: auto;
            font-size: 20pt;
            font-family: Comic Sans MS;
            border: 2px solid white;
            border-style: groove;
            background-color: lightgray;
            color: black;
            border-radius: 20px;
        }

        @media screen and (max-width: 1200px) {

            .tabcontent,
            .menu {
                width: 100%;
                margin-top: 0;
            }

            #currenttime {
                font-size: 15pt;
                width: 20%;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <table style="width:100%;">
            <tr>
                <td align="left">
                    <img src="icon.png" class="img_style" alt="no image">
                    <div style="margin-top:0px; float:left;">Quiz Management System</div>
                    <a href="dashboard.php">
                        <img class="img_style" style="margin-left: 10px" src="home.jpg" alt="no image">
                    </a>
                </td>
                <td align="right"><button class="logoutbutton" onclick="location.href='logout.php'">LOGOUT</button></td>
            </tr>
        </table>
    </div>
    <?php
    $qid = $_REQUEST["qid"];
    $qdate = "";
    $stime = "";
    $etime = "";
    $shuffle = "";
    $qname = "";
    date_default_timezone_set("Asia/Kolkata"); //India time (GMT+5:30)
    $currentdate = date('Y-m-d');
    $currenttime = date('H:i');
    $result = $con->query("select * from qlist where qid='$qid'");
    while ($rows = $result->fetch_assoc()) {
        $status = $rows["status"];
        if ($rows["qdate"] == $currentdate) {
            $status = $rows["status"];
            if ($rows["stime"] <= $currenttime) {
                $check = $con->query("update qlist set status='ACTIVE' where qid='$qid'");
                $status = "ACTIVE";
                if ($rows["etime"] <= $currenttime) {
                    $check1 = $con->query("update qlist set status='COMPLETED' where qid='$qid'");
                    $status = "COMPLETED";
                }
            }
        } else if ($rows["qdate"] < $currentdate) {
            $check1 = $con->query("update qlist set status='COMPLETED' where qid='$qid'");
        }
        $qdate = $rows["qdate"];
        $qname = $rows["qname"];
        $stime = $rows["stime"];
        $etime = $rows["etime"];
        $shuffle = $rows["shuffle"];
    }
    ?>
    <div class="menu">
        <form name="form1" id="form1" method="post" action="joincreate.php">
            <input type="hidden" name="qid1" id="qid" value="<?php echo $qid; ?>" />
        </form>
        <fieldset style="background-color: #0ead88;">
            <table style="width:100%" cellspacing="10">
                <tr>
                    <td colspan="2" align="center">
                        <p id="currenttime"></p>
                    </td>
                </tr>
                <tr>
                    <td>Quiz Date</td>
                    <td> :<input form="form1" type="date" name="qdate" value="<?php echo $qdate; ?>" readonly></td>
                </tr>
                <tr>
                    <td>Start Time</td>
                    <td> : <input form="form1" type="time" name="stime" value="<?php echo $stime; ?>" readonly></td>
                </tr>
                <tr>
                    <td>End Time</td>
                    <td> : <input form="form1" type="time" name="etime" value="<?php echo $etime; ?>" readonly></td>
                </tr>
                <tr>
                    <td>Quiz Status</td>
                    <td id="status"> :
                        <?php echo $status; ?>
                    </td>
                </tr>
                <tr id="marks">
                    <td>Mark</td>
                    <?php
                    $result3 = $con->query("SELECT distinct(status),marks FROM qmarks inner join qattempt on qattempt.qid = qmarks.qid and qattempt.sid = qmarks.sid where qmarks.sid='$uid' and qattempt.qid='$qid';");
                    if ($rows = $result3->fetch_assoc()) {
                        ?>
                        <td> :
                            <?php echo $rows["marks"] ?>
                        </td>
                        <?php
                    } else {
                        ?>
                        <td> : 0</td>
                        <?php
                    }
                    ?>
                </tr>
            </table>
        </fieldset>
    </div>
    <div class="tabcontent" id="tabcontent">
        <fieldset class="scroll">
            <legend>
                
                <font size="6pt"><b>
                        <?php echo $qname; ?>
                    </b></font>
            </legend>
            <!-- <?php echo $qdate ?> -->
            <p style="font-size:50px; text-align:center; vertical-align:middle;">After quiz get completed the result
                will be published</p>
        </fieldset>
    </div>
    <div class="tabcontent" id="tabcontent1">
        <fieldset class="scroll">
            <legend>
                <font size="6pt"><b>
                        <?php echo $qname; ?>
                    </b></font>
            </legend>
            <?php

            $i = 0;
            $result1 = $con->query("SELECT * FROM qquestions where qid='$qid'");
            $flag = 0;
            while ($rows = $result1->fetch_assoc()) {

                $correctanswer = explode(",", $rows["answer"]);
                // print_r($correctanswer);
                // echo $uid;
                $result2 = $con->query("SELECT * from qattempt where sid='" . $uid . "' and questions='" . $rows["questions"] . "' and qid='" . $rows["qid"] . "'");
                while ($rows1 = $result2->fetch_assoc()) {
                    $answer = explode(",", $rows1["answer"]);
                    // echo $uid;
                    // echo $rows1["status"];
                    if ($rows1["status"] == "Not Started" || $rows1["status"] == "Started") {
                        $flag = 1;
                        ?>
                        <p style="font-size:50px; text-align:center; vertical-align:middle;">Quiz got Over</p>
                        <?php
                        break;
                    }

                    ?>
                    <div id="questions">
                        <div class="question center">
                            <p>
                                <?php echo "Question " . ($i + 1) . "."; ?>
                            </p>
                            <span style="color:white;">
                                <?php echo $rows["questions"]; ?>
                            </span>
                        </div>
                        <div class="answer center">
                            <ol type="A">
                                <?php
                                for ($j = 1; $j <= 4; $j++) {
                                    $flag = 0;
                                    ?>
                                    <li>
                                        <?php echo $rows["option$j"];
                                        if (in_array($rows["option$j"], $answer)) {
                                            if (in_array($rows["option$j"], $correctanswer)) {
                                                ?>
                                                <img src="tick.png" width="30" height="30" alt="no image">
                                                <?php
                                            } else {
                                                ?>
                                                <img src="cross.jpg" width="30" height="30" alt="no image">
                                                <?php
                                            }
                                        }
                                        ?>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ol>
                        </div>
                        <div class="correctanswer center">
                            <p>Correct Answer : <span style="color:white;">
                                    <?php echo implode(",", $correctanswer); ?>
                                </span></p>
                        </div>
                    </div>
                    <?php
                }
                $i++;
                if ($flag == 1) {
                    break;
                }
            }
            ?>
            <input type="hidden" id="count" value="<?php echo $i ?>" />
        </fieldset>
    </div>
    <script>
        var status = document.getElementById("status").innerHTML;
        let test_date = document.form1.qdate.value.split("-");
        let start = document.form1.stime.value.split(":");
        let end = document.form1.etime.value.split(":");
        function gettime() {
            let date = new Date();
            let h = date.getHours();
            let m = date.getMinutes();
            let s = date.getSeconds();
            let h1 = " ", s1 = " ", m1 = " ";
            if (h < 10) h1 = "0" + h;
            else h1 = h;
            if (s < 10) s1 = "0" + s;
            else s1 = s;
            if (m < 10) m1 = "0" + m;
            else m1 = m;
            document.getElementById('currenttime').innerHTML = h1 + ":" + m1 + ":" + s1;
            setTimeout('gettime()', 1000);
        }
        gettime();

        function gettime1() {
            let date = new Date();
            date.setMinutes(date.getMinutes() - 1);
            let h = date.getHours();
            let m = date.getMinutes();
            let s = date.getSeconds();
            let d = date.getDate();
            let mo = date.getMonth() + 1;
            let y = date.getFullYear();
            let d1 = " ", mo1 = " ", y1 = " ";
            if (d < 10) d1 = "0" + d;
            else d1 = "" + d;
            if (mo < 10) mo1 = "0" + mo;
            else mo1 = "" + mo;
            if (y < 10) y1 = "0" + y;
            else y1 = "" + y;
            let h1 = " ", s1 = " ", m1 = " ";
            if (h < 10) h1 = "0" + h;
            else h1 = h;
            if (s < 10) s1 = "0" + s;
            else s1 = s;
            if (m < 10) m1 = "0" + m;
            else m1 = m;
            if ((test_date[0] == y1) && (test_date[1] == mo1) && (test_date[2] == d1)) {
                if ((end[0] == h1 && end[1] <= m1) || (end[0] < h1)) {
                    document.getElementById('tabcontent').style.display = "none";
                    document.getElementById('tabcontent1').style.display = "";
                    document.getElementById('marks').style.display = "";
                }
                else {
                    document.getElementById('tabcontent1').style.display = "none";
                    document.getElementById('marks').style.display = "none";
                    document.getElementById('tabcontent').style.display = "";
                }
            }
            else if (((test_date[0] == y1) && (test_date[1] == mo1) && (test_date[2] < d1)) || ((test_date[0] == y1) && (test_date[1] < mo1)) || (test_date[0] < y1)) {
                document.getElementById('tabcontent1').style.display = "block";
                document.getElementById('marks').style.display = "block";
                document.getElementById('tabcontent').style.display = "none";
            }
            else {

                document.getElementById('tabcontent').style.display = "";
                document.getElementById('tabcontent1').style.display = "none";
                document.getElementById('marks').style.display = "none";
            }
            setTimeout('gettime1()', 10000);
        }
        gettime1();
        function submit1() {
            var n = parseInt(document.getElementById('count').value);
            for (let i = 1; i <= n; i++) {
                let flag = 0;
                let array = document.getElementsByName('option[' + i + '][]');
                for (let j = 0; j < 4; j++) {
                    if (array[j].checked) {
                        flag = 1;
                        break;
                    }
                }
                if (flag === 0) {
                    alert("Choose the correct option for the question " + i);
                    array.focus();
                    return false;
                }
            }
            document.getElementById('form1').submit();

        }
    </script>
</body>

</html>
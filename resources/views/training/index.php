<?php
include_once ("../exam/lib/Session.php");
Session::init();
include_once ("../exam/lib/Database.php");
include_once ("../exam/helpers/Format.php");
$db = new Database();
$fm = new Format();
$msg="";
?>
<html>
    <head>
        <style>
            .main{
                width: 70%; margin: auto; text-align: center; display: block;
                font-family: sans-serif;
            }
            .error{
                color: red;
            }
        </style>
    </head>
    <?php
    if(isset($_GET["logout"])){
        Session::set("trainingLogin", false);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $code = $fm->validation($_POST['access_code']);
        $code = mysqli_real_escape_string($db->link,md5($code));
        $query = "SELECT * FROM tbl_training WHERE code = '$code'" ;
        
    $result = $db->select($query);
    if ($result != false) {
    	$value = $result->fetch_assoc();
    	
    	Session::set("trainingLogin", true);
    	header("Location:lecture.php");
    }else{
    	$msg = "<span class='error'>Access Code Not Matched !  </span>";
//    	return $msg;
    }
//        $adminData = $db->getAdminData($_POST);
    }
    ?>
    <div class="main">
        <h2>Authentication Required</h2>
        <form action="" method="post">
            <table>
                <tr>
                    <td>Access Code</td>
                    <td><input type="password" name="access_code"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $msg;?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="login" value="Submit"/></td>
                </tr>
            </table>
            </from>
    </div>
</html>
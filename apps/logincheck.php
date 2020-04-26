<?php
//error_reporting(0);
session_start();

include 'ServerDetails.php';
include 'dbconfig.php';
$conn=mysql_connect("$host", "$username", "$password")or die("cannot connect");
$myusername=$_POST['myusername']; 
$mypassword=sha1($_POST['mypassword']);

if (isset($_POST["myusername"])) {
$myusername = mysqli_real_escape_string($conn,stripslashes($myusername));
$mypassword = mysqli_real_escape_string($conn,stripslashes($mypassword));
    

   try {
        $con = new PDO("mysql:host=$host; dbname=$db_name", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM logindetails WHERE username = '$myusername'";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $username_exists = false;
        $lockout_minutes = 30;
        $login_fail_max = 3;
        $login_fail_count = 0;
        $timestamp = date("Y-m-d H:i:s");
        $LoginDate = date("Y-m-d H:i:s");
        if (sizeof($data) == 1) {
            $LoginId = $data[0]['LoginId'];

            $username_exists = true;
            if ($data[0]['is_locked'] == 1) {
                $lock_start_timestamp = $data[0]['lock_start_timestamp'];
                if ($lock_start_timestamp != NULL) {
                    $dif = (strtotime($timestamp) - strtotime($lock_start_timestamp));
                    if ($dif > $lockout_minutes * 60) {
                        $login_fail_count = 0;
                        $sql = "UPDATE logindetails
                        SET  is_locked = 0, login_fail_count = 0, lock_start_timestamp = NULL
                        WHERE LoginId = $LoginId";
                        $stmt = $con->prepare($sql);
                        $stmt->execute();
                        
                        $sql1="INSERT INTO LoginAttempts (ServerName, LoginId, UserName, LoginDate)
		VALUES ('$ServerName', '$LoginId', '$myusername', '$LoginDate')";
		$stmt = $con->prepare($sql);
                        $stmt->execute();


                    }
                }
            } else {
                $login_fail_count = $data[0]['login_fail_count'];
            }
        }
        if ($username_exists) {
            $sql = "SELECT * FROM logindetails WHERE username = '$myusername' AND password = '$mypassword' LIMIT 1";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            
            if (sizeof($data) == 1) {
                if ($data[0]["is_locked"] == 0) {
                
            $token = getToken(12);
            $_SESSION['UName']=$myusername;
            $_SESSION['last_login_timestamp']= time();
            $_SESSION['token'] = $token;

                    $sql = "UPDATE logindetails
                    SET status = '1', token = '$token', login_fail_count = 0, LoginDate = '$timestamp'
                    WHERE LoginId = $LoginId";
                    $stmt = $con->prepare($sql);
                    $stmt->execute();
                   
                    $_SESSION['ServerName']=$ServerName;
                    $LoginId=$data[0]['LoginId'];
                    $Type=$data[0]['Type'];
                    $LoginDate = date("Y-m-d H:i:s");
                    $dbUserName=$data[0]['UserName'];
                   $dbPassword=$data[0]['Password'];  
  
        
           


         if ($Type=="3")
        {
            header("location:studenthome.php");
        }
         if ($Type=="2")
        {
            header("location:teacherhome.php");
        }
      if ($Type=="1") 
        {
            header("location:HomeAdmin.php");
        }


                } else {
                    // Account is locked. Increment failed login count
                    $sql = "UPDATE logindetails
                        SET login_fail_count = login_fail_count + 1
                        WHERE username = '$myusername'";
                    $stmt = $con->prepare($sql);
                    $stmt->execute();
                    echo "<pre>Account is locked.</pre>";
                }
            } else {
                // Not Successful. Increment failed login count
                $will_be_locked = ($login_fail_count == $login_fail_max - 1);
                $timestamp = date("Y-m-d H:i:s");
                if ($will_be_locked) {
                    $sql = "UPDATE logindetails 
                    SET login_fail_count = login_fail_count + 1, is_locked = 1, lock_start_timestamp = '$timestamp'
                    WHERE LoginId = $LoginId";
                } else {
                    $sql = "UPDATE logindetails 
                    SET login_fail_count = login_fail_count + 1
                    WHERE LoginId = $LoginId";
                }
                $stmt = $con->prepare($sql);
                $stmt->execute();
                
                if ($will_be_locked) {
                    echo "<pre>Account is locked.</pre>";
                } else {
                    $attempts_remaining = ($login_fail_max - ($login_fail_count + 1));
                    if ($attempts_remaining > 0) {
                        echo "<pre>Incorrect username or password.</pre>";
                        if ($attempts_remaining <= 3) {
                            echo "<pre>Attempts remaining: " . ($login_fail_max - ($login_fail_count + 1)) . "</pre>";
                        }
                    }
                }
            }
        } else {
            echo "<pre>Incorrect username or password.</pre>";
        }
    } catch (PDOException $e) {
        echo "Fail: " . $e->getMessage();
    }
}

function getToken($length){
     $token = "";
     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
     $codeAlphabet.= "0123456789";
     $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[rand(0, $max-1)];
    }

    return $token;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <meta name="viewport" content="width=device-width, initial-state=1"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"></script>

    <style type="text/css">
    .bg{background: url('https://jalapps.herokuapp.com/back.jpg') ;
    width:100%;
    height:100%;
    }
    #log{
        border : 2px solid white;
        padding : 25px 25px;
        background-color: #006dcc;
        margin-top : 80px;
        -webkit-box-shadow: -5px 2px 10px 6px rgba(0,0,0,0.75);
-moz-box-shadow: -5px 2px 10px 6px rgba(0,0,0,0.75);
box-shadow: -5px 2px 10px 6px rgba(0,0,0,0.75);
    }
    img{ width: 180px;
        margin:auto;

    }
    h1{
        color:white;
        text-align:center;
        font-weight:bolder;
        margin-top:-20px;
    }


    label{font-size:20px; color:white;}

    </style>
</head>
<body>
    <div class="container-fluid bg">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12"></div>
                        <div class="col-md-4 col-sm-4 col-xs-12 text-center">
                            <form id="log" action="logincheck.php" method="post">
                                <h1>Login Form</h1>
                                <img class="rounded-circle text-center" src="https://jalapps.herokuapp.com/login.jpg">
                                <div class="form-group">
                                    <label></label>
                                    <input name="myusername" id="myusername" type="text" class="form-control" placeholder="Username">
                                    
                                </div>
                                <div class="form-group">
                                    <label></label><input type="password" name="mypassword" id="mypassword" class="form-control" placeholder="Password">                        
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Login</button>
                            </form>

                        </div>

            
        </div>
        
    </div>

</body>
</html>
        


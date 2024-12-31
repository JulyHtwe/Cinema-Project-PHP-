<?php
session_start();

include("Model/db.php");
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Sanitize inputs
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $remember_me = isset($_POST['remember_me']) ? true : false;

    if ($email == null && $password == null) {
        echo ".<script>
                    alert('Fill Email and Password!');
               </script>.";
        header("Location: login.php");
            exit;
    } else {

        $flag=false;
        $sql = mysqli_query($connection, "SELECT uid FROM user WHERE email = '$email' AND password = '$password' ");

        //$stmt = $connection->prepare("SELECT uid FROM user WHERE email = ? AND password = ?");
        //$stmt->bind_param("ss", $email, $password);
        while ($res = mysqli_fetch_assoc($sql)) {
            $flag=true;
            $uid = $res['uid'];

            if ($remember_me) {
                $_SESSION['uid'] = $uid;

                // Generate a unique token
                $token = bin2hex(random_bytes(16));

                // Prepare the statement to update the user's token
                mysqli_query($connection,"update user set token='$token' where uid='$uid'");
                

                setcookie("token", $token, time() + 3600, "/");
                
            }
            
        }
        if($flag){
            header("Location: View/index.php");
            exit;
        }else{
            echo ".<script>alert('Something went wrong! Please Try again!')</script>.";
        }
    }
} else {
    echo "Please enter both username and password.";
}

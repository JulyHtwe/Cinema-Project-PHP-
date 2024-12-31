<?php
session_start();
include("Model/db.php");
if (isset($_POST['reg_submit'])) {

    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $repassword = mysqli_real_escape_string($connection, $_POST['repassword']);
    $emailsql=mysqli_query($connection,"select count(*) as count from user where email='$email'");
    $emailres=mysqli_fetch_assoc($emailsql);
    $count=$emailres['count'];
    

    if ($password !== $repassword) {
        echo "Passwords do not match!";
        exit();
    } else {
        if($count<1){
            $uid = hash('sha256', $email);
            $stmt = $connection->prepare("INSERT INTO user (uid, username, email, password) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssss", $uid, $username, $email, $password);
    
                // Execute the query
                if ($stmt->execute()) {
                    echo "New record created successfully";
                    header("Location: login.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $connection->error;
                }
                $stmt->close();
            }
        }
        else{
            echo "<script>alert('Emial already exists!')</script>";
            
            exit(0);
        }
        

    }

}
?>
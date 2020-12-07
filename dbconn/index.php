<?php
    include_once 'db.php';
    include_once 'user.php';

    $con = new DBConnector();
    $pdo = $con->connectToDB();

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = new User();
        $user->setEmail($email);
        $user->setPass($password);
        echo $user->login($pdo);

    }
    if(isset($_POST['register'])){
        $fullName = $_POST['fname'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $password = $_POST['password'];
        $user = new User();
        $user->setEmail($email);
        $user->setPass($password);
        $user->setFullName($fullName);
        $user->setCity($city);
        echo $user->register($pdo);

    }
    if(isset($_POST['changepassword'])){
        $email = $_POST['email'];
        $originalPassword = $_POST['oldpassword'];
        $newPassword = $_POST['newpassword'];
        $confirmPassword = $_POST['new-password'];
        
        if($confirmPassword == $newPassword){
            $user = new User();
            $user->setEmail($email);
            $user->setNewPassword($newPassword);
            $user->setPass($originalPassword);
            echo $user->changePassword($pdo);
        }
        else{
            echo "Passwords do not match";
        }

    }
?>
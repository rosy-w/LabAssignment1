<?php
    include_once 'user.php';
    include_once 'db.php';

    $con = new DBConnector();
    $pdo = $con->connectToDB();

   // $event = $_POST['event'];
if(isset($_POST['register'])){
        //register
        $fullName = $_POST['fullName'];
        $city = $_POST['city'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $user = new User($email, $password);
        $user->setFullName($fullName);
        $user->setCity($city);
        echo $user->register($pdo);
}
else {
        //login
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = new User($email, $password);
        echo $user->login($pdo);
} 
?>
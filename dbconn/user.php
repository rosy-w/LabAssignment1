<?php
include_once '../Account.php';

class User implements Account{
    private $fullname;
    private $email;
    private $city;
    private $password;
    private $newpassword;
    private $confirmPass;

    public function __construct(){
        $this->fullname = "";
        $this->email = "";
        $this->city = "";
        $this->password = "";
        $this->newpassword = "";
        $this->confirmPass = "";
    }     
            /**
        * Create a new user
        * @param Object PDO Database connection handle
        * @return String success or failure message
        */
    public function register ($pdo){
        $passwordHash = password_hash($this->password,PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare ('INSERT INTO users (full_name,city,password,email) VALUES(?,?,?,?)');
            $stmt->execute([$this->getFullName(),$this->getCity(),$passwordHash,$this->getEmail()]);
            return "Registration was successful";
        } catch (PDOException $e) {
            $pdo->rollBack();
            return $e->getMessage();
        }            
    }
    /**
    * Check if a user entered a correct username and password
    * @param Object PDO Database connection handle
    * @return String success or failure message
    */
    public function login ($pdo){
        try {
            $stmt = $pdo->prepare("SELECT password FROM users WHERE email=?");
            $stmt->execute([$this->email]);
            $row = $stmt->fetch();
            if($row == null){
                return "This account does not exist";
            }
            if (password_verify($this->password,$row['password'])){
                return "Correct blah blah....";
            }
            return "Your username or password is not correct";
        } catch (PDOException $e) {
            $pdo->rollBack();
            return $e->getMessage();
        }
    }
    public function changePassword($pdo){
        try
        {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
            $stmt->execute([$this->email]);
            $row = $stmt->fetch();
            if (password_verify($this->password,$row['password']))
                {
                    $hashedPassword = password_hash($this->getnewpassword(), PASSWORD_DEFAULT);
                    $stm = $pdo->prepare("UPDATE users SET password =  ? ");
                    $stm->execute([$hashedPassword]);
                    $stm = null;
                    return header('Location: Profile.php ');
                }
                else
                {
                    return header('Location: Change_Password.php ');
                }
        }catch(PDOException $e)
        {
            return $ex->getMessage();
        }     
    }
    public function logout($pdo){
        session_destroy();
    }

    public function setFullName($fullname){
        return $this->fullname = $fullname;
    }
    public function getFullName(){
        return $this->fullname;
    }
    public function setCity($city){
        return $this->city = $city;
    }
    public function getCity(){
        return $this->city;
    }
    public function setNewPassword($password){
        return $this->newpassword = $password;
    }
    public function getNewPassword(){
        return $this->newpassword;
    }
    public function setPass($password){
        return $this->password = $password;
    }
    public function getPass(){
        return $this->password;
    }
    public function getConfPass(){
        return $this->confirmPass;
    }
    public function setConfPass($password){
        return $this->confirmPass = $pass;
    }
    public function setEmail($email){
        return $this->email = $email;
    }   
    public function getEmail(){
        return $this->email;
    } 
}
?>
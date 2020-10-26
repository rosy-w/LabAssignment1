<?php
Interface Account {
	public function register ($pdo);
	public function login($pdo);
	public function changePassword($pdo);
	public function logout ($pdo);
}
<?php
    class User {
        //properties 
        protected $email;
        protected $password;
        protected $fullName;
        protected $city;
        //class constructor 
        function __construct($email, $pass){
            $this->email =$email;
            $this->password = $pass;
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
                return "Registration was successiful";
            } catch (PDOException $e) {
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
            	return $e->getMessage();
            }
        }


		 //full name setter 
		public function setFullName ($name){
			$this->fullName = $name;
		}
		//full name getter
		public function getFullName (){
			return $this->fullName;
		}
		public function setPassword($password){
			$this->password=$password;
		}
		public function getPassword(){
			return $this->password;
		}
		public function setEmail($email){
			$this->email = $email;
		}
		public function getEmail(){
			return $this->emai;
		}
		public function setCity($city){
			$this->city= $city;
		}
		public function getCity(){
			return $this->city;
		}

}

?>
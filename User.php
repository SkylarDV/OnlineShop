<?php
    include_once(__DIR__."/Db.php");

class User
{   
    private string $email;
    private string $password;
    private string $username;
    private string $pfp; 
    private int $currency; 
    private bool $admin;  

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $existingEmail = self::getByEmail($email);
        if ($existingEmail !== null) {
            throw new Exception("The email address is already in use.");
        }
        $this->email = $email;
    }


    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPfp(): string
    {
        return $this->pfp;
    }

    public function setPfp(string $pfp): void
    {
        $this->pfp = $pfp;
    }

    public function getCurrency(): int
    {
        return $this->currency;
    }

    public function setCurrency(int $currency): void
    {
        if ($currency < 0) {
            throw new InvalidArgumentException("Currency cannot be negative.");
        }
        $this->currency = $currency;
    }

    public function getAdmin(): bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): void
    {
        $this->admin = $admin;
    }

    public function save(){
        $conn = Db::getConnection();

        $query = $conn->prepare("INSERT INTO `users` (`email`, `password`, `username`, `admin`, `currency`) VALUES (:email, :password, :username, :admin, :currency)");
        $email = $this->getEmail();
        $password = $this->getPassword();
        $username = $this->getUsername();
        $currency = $this->getCurrency();
        $admin = $this->getAdmin();

        $query->bindValue(":email", $email);
        $query->bindValue(":username", $username);
        $query->bindValue(":password", $password);
        $query->bindValue(":currency", $currency);
        $query->bindValue(":admin", $admin, PDO::PARAM_INT);  // Bind as integer

        $result = $query->execute();
        return $result;
    }

    public static function getAll(){
        $conn = Db::getConnection();
        $query = $conn->prepare("SELECT * FROM users");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC); 
    }

    public static function getByEmail($email){
        $conn = Db::getConnection();
        $query = $conn->prepare("SELECT ID FROM users WHERE email = :email");
        $query->bindValue(":email", $email);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result["ID"] : null;
    }

    public static function changePassword($email, $password) {
        $conn = Db::getConnection();
        $query = $conn->prepare("UPDATE users SET password = :password WHERE email = :email");
        $query->bindValue(":email", $email);
        $options = ["cost" => 15,];
        $password = password_hash($password, PASSWORD_DEFAULT, $options);
        $query->bindValue(":password", $password);
        $query->execute();
    }
    
    public static function checkIfAdmin($email) {
        $conn = Db::getConnection();
        $query = $conn->prepare("SELECT admin FROM users WHERE email = :email");
        $query->bindValue(":email", $email);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['admin'] : null;
    }
    
}

?>

<?php
    include_once(__DIR__."/Db.php");

class User
{   

    private string $email;
    private string $password;
    private string $username;
    private string $pfp; // Profile picture (URL or file path)
    private int $currency; // User's currency, assumed to be an integer
    private bool $admin;  // User's admin status

    // Getter and setter for Email
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //     throw new InvalidArgumentException("Invalid email format.");
        // }
        $this->email = $email;
    }

    // Getter and setter for Password
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    // Getter and setter for Username
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    // Getter and setter for Profile Picture (PFP)
    public function getPfp(): string
    {
        return $this->pfp;
    }

    public function setPfp(string $pfp): void
    {
        $this->pfp = $pfp;
    }

    // Getter and setter for Currency
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

    // Getter and setter for Admin Status
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
        
}

?>

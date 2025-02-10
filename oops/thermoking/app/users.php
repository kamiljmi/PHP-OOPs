<?php
include_once('D:/xampp/htdocs/oops/thermoking/app/database.php');

class Users extends Database {
    private $table_name = "users";
    public $id;
    public $name;
    public $email;
    public $password;

        public function register() {
        try {
            // Check if email already exists
            $checkQuery = "SELECT id FROM " . $this->table_name . " WHERE email = :email";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(':email', $this->email);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                return "Email already registered.";
            }

            // Securely hash the password
            $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

            $query = "INSERT INTO " . $this->table_name . " (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage(), 3, "error_log.txt"); // Logs errors instead of displaying them
            return false;
        }
    }

    
    public function login() {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
            $stmt = $this->conn->prepare($query);    
            $stmt->bindParam(':email', $this->email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password
            if ($user && password_verify($this->password, $user['password'])) {
                // ✅ Optional: Start a session for the logged-in user
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];

                return true; // Successful login
            } else {
                return false; // Invalid credentials
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage(), 3, "error_log.txt");
            return false;
        }
    }

    public function logout() {
        try {
            session_start();
session_unset();
session_destroy();
//header("Location: login.php");
return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage(), 3, "error_log.txt");
            return false;
        }
    }
}
?>

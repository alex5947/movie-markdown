<?php

class MovieMarkdownController {

    
    private $command;
    private $db;

    public function __construct($command) {
        $this->command = $command;
        $this->db = new Database();
    }

    public function run() {
        switch($this->command) {
            case "homepage":
                $this->homePage();
                break;
            case "genres":
                $this->genresPage();
                break;
            case "moveielist":
                $this->movielistPage();
                break;
            case "logout":
                $this->destroySession();
                break;
            case "login":
                $this->login();
                break;
        }
    }

    
    // Destroy current session
    private function destroySession() {
        session_unset();
        session_destroy();

        header("Location: ?command=login");
    }

    // Email Validation Function
    private function validateEmail($email, $regex = "") {
        // echo func_num_args();
        if(preg_match('/^[A-Za-z0-9_\-\+]+[\.A-Za-z0-9_\-\+]*[A-Za-z0-9_\-\+]+[@][A-Za-z0-9\.\-]*(\.[A-Za-z]+)$/', $email)) {
            if($regex != "") {
                if(preg_match($regex, $email)) {
                    return true;
                }
                else {
                    return false;
                }
            }
            return true;
        }
        return false;
    }
    
    // Display the login page (and handle login logic)
    private function login() {
        if (isset($_POST["email"]) && $this->validateEmail($_POST["email"])) {
            $data = $this->db->query("select * from project_user where email = ?;", "s", $_POST["email"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } else if (!empty($data)) {
                if (password_verify($_POST["password"], $data[0]["password"])) {
                    $_SESSION["name"] = $_POST["name"];
                    $_SESSION["email"] = $_POST["email"];
                    $_SESSION["user id"] = $this->db->query("select id from project_user where email = ?;", "s", $_POST["email"]);
                    header("Location: ?command=homepage");
                } else {
                    $error_msg = "Wrong password";
                }
            } else { // empty, no user found
                $insert = $this->db->query("insert into project_user (name, email, password) values (?, ?, ?);", 
                "sss", $_POST["name"], $_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT));
                if ($insert === false) {
                    $error_msg = "Error inserting user";
                } else {
                    $_SESSION["name"] = $_POST["name"];
                    $_SESSION["email"] = $_POST["email"];
                    $_SESSION["user id"] = $this->db->query("select id from project_user where email = ?;", "s", $_POST["email"]);
                    header("Location: ?command=homepage");
                }
            }
        }
        else {
            $error_msg = "Error, please provide a valid email address";
        }
        include("templates/login.php");
    }

    // Display homepage (index.html)
    private function homePage() {
        include("templates/index.html");
    }

    // Display genres page (genres.html)
    private function genresPage() {
        include("templates/genres.html");
    }

    // Display homepage (mymovielist.html)
    private function movielistPage() {
        include("templates/mymovielist.html");
    }
}


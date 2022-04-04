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
            case "movielist":
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
            if ($this->validateEmail($_POST["email"])) {
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
                $error_msg = "Error, please enter a valid email address";
            }
        }
        include("templates/login.php");
    }

    // Display homepage (index.html)
    private function homePage() {
        // get list of trending, popular, and plan-to-watch movies
        $trending = $this->db->query("select * from project_movies where id between 1 and 2;");
        $popular = $this->db->query("select * from project_movies where id between 3 and 4;");
        $plan_to_watch = $this->db->query("select * from project_movies where id between 5 and 6;");

        // add movie to movie list
        if (isset($_POST["addmovie"])) {
            $added_movie = $this->db->query("select * from project_movies where id = ?;", "i", $_POST["movieid"]);
            $insert = $this->db->query("insert into project_movielist (user_id, title, genre, poster, rating) values (?, ?, ?, ?, ?);", 
                "isssi", $_SESSION["user id"], $added_movie[0]["title"], $added_movie[0]["genre"], $added_movie[0]["poster"], $added_movie[0]["rating"]); 
        }

        // get list of movies that current user has added to movielist
        $seen = $this->db->query("select title from project_movielist where user_id = ?;", "i", $_SESSION["user id"]);
        $added = array();
        foreach ($seen as $movie) {
            array_push($added, $movie["title"]);
        }

        include("templates/home.php");
    }

    // Display genres page (genres.html)
    private function genresPage() {
        include("templates/genres.php");
    }

    // Display homepage (mymovielist.html)
    private function movielistPage() {

        if(isset($_POST["option_rating"]) && !empty($_POST["option_rating"])){
            $this->db->query("update project_movielist set rating = ? where user_id = ? and id = ?;", "iii", $_POST["option_rating"], $_SESSION["user id"], $_POST["option_id"]);
        }

        $my_movie_list_data = $this->db->query("select * from project_movielist where user_id = ?;", "i", $_SESSION["user id"]);

        include("templates/mymovielist.php");
    }
}


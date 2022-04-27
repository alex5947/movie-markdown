<?php
// authors: Alex Chan and Nathaniel Gonzalez

include "MovieMarkdownController.php";
include "Config.php";
class Database {
    private $mysqli;

    public function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->mysqli = new mysqli(Config::$db["host"], 
                Config::$db["user"], Config::$db["pass"], 
                Config::$db["database"]);
    }

    public function query($query, $bparam=null, ...$params) {
        $stmt = $this->mysqli->prepare($query);

        if ($bparam != null)
            $stmt->bind_param($bparam, ...$params);

        if (!$stmt->execute()) {
            return false;
        }

        if (($res = $stmt->get_result()) !== false) {
            return $res->fetch_all(MYSQLI_ASSOC);
        }

        return true;
    }
}

$db = new Database();
$added_movie = $db->query("select * from project_movies where id = ?;", "i", $_POST["movieid"]);
$insert = $db->query("insert into project_movielist (user_id, title, genre, poster, rating) values (?, ?, ?, ?, ?);", 
    "isssi", $_POST["userid"], $added_movie[0]["title"], $added_movie[0]["genre"], $added_movie[0]["poster"], $added_movie[0]["rating"]); 

include("templates/home.php");

?>
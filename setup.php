<?php
spl_autoload_register(function($classname) {
    include "classes/$classname.php";
});

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli(Config::$db["host"], Config::$db["user"], 
                 Config::$db["pass"], Config::$db["database"]);

$db->query("drop table if exists project_user;");
$db->query("create table project_user (
                id int not null auto_increment,
                name text not null,
                email text not null,
                password text not null,
                primary key (id) 
            );");

$db->query("drop table if exists project_movielist;");
$db->query("create table project_movielist (
                id int not null auto_increment,
                user_id int not null, -- the user id who inserted this movie
                title text not null, -- title of movie 
                genre text not null, -- genre of transaction
                poster text not null, -- image link to movie poster
                rating int not null default 1, -- rating of movie
                primary key (id)
            );");

$db->query("drop table if exists project_movies;");
$db->query("create table project_movies (
                id int not null auto_increment,
                title text not null, -- title of movie 
                genre text not null, -- genre of transaction
                poster text not null, -- image link to movie poster
                rating int not null default 1, -- rating of movie
                primary key (id) 
            );");

$movies = array(
                $movie0 = [
                    "title" => "Spider-man: No Way Home",
                    "genre" => "Action",
                    "poster" => "images/spiderman-no-way-home.jpg",
                    "rating" => 1,
                ],

                $movie1 = [
                    "title" => "The Lego Movie",
                    "genre" => "Comedy",
                    "poster" => "images/lego-movie.jpg",
                    "rating" => 1,
                ],

                $movie2 = [
                    "title" => "Cars",
                    "genre" => "Drama",
                    "poster" => "images/cars.jpg",
                    "rating" => 1,
                ],

                $movie3 = [
                    "title" => "Real Steel",
                    "genre" => "Action",
                    "poster" => "images/real-steel.jpg",
                    "rating" => 1,
                ],

                $movie4 = [
                    "title" => "Uncharted",
                    "genre" => "Action",
                    "poster" => "images/uncharted-movie.jpg",
                    "rating" => 1,
                ],

                $movie5 = [
                    "title" => "Bee Movie",
                    "genre" => "Comedy",
                    "poster" => "images/bee-movie.jpg",
                    "rating" => 1,
                ],

                $movie6 = [
                    "title" => "No Time To Die",
                    "genre" => "Action",
                    "poster" => "images/action/notimetodie.jfif",
                    "rating" => 1,
                ],
                
                $movie7 = [
                    "title" => "Jungle Cruise",
                    "genre" => "Action",
                    "poster" => "images/action/junglecruise.jfif",
                    "rating" => 1,
                ],
                
                $movie8 = [
                    "title" => "Fatherhood",
                    "genre" => "Comedy",
                    "poster" => "images/comedy/fatherhood.jfif",
                    "rating" => 1,
                ],
                
                $movie9 = [
                    "title" => "Rush Hour 3",
                    "genre" => "Comedy",
                    "poster" => "images/comedy/rushhour.jfif",
                    "rating" => 1,
                ],
                
                $movie10 = [
                    "title" => "A Silent Voice",
                    "genre" => "Drama",
                    "poster" => "images/drama/asilentvoice.jfif",
                    "rating" => 1,
                ],
                
                $movie11 = [
                    "title" => "Titanic",
                    "genre" => "Drama",
                    "poster" => "images/drama/titanic.jfif",
                    "rating" => 1,
                ],
            );


$stmt = $db->prepare("insert into project_movies (title, genre, poster, rating) values (?, ?, ?, ?);");

foreach($movies as $movie) {

    $stmt->bind_param("sssi", $movie["title"], $movie["genre"], $movie["poster"], $movie["rating"]);
    $stmt->execute();
    // $db->query("insert into project_movies (title, genre, poster, rating) values (?, ?, ?, ?);", 
    // "sssi", $movie["title"], $movie["genre"], $movie["poster"], $movie["rating"]);
}
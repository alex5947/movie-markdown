<?php
spl_autoload_register(function($classname) {
    include "classes/$classname.php";
});

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli(Config::$db["host"], Config::$db["user"], 
                 Config::$db["pass"], Config::$db["database"]);

$db->query("create table project_user (
                id int not null auto_increment,
                name text not null,
                email text not null,
                password text not null,
                primary key (id) 
            );");

$db->query("create table project_movielist (
                id int not null auto_increment,
                user_id int not null, -- the user id who inserted this movie
                title text not null, -- title of movie 
                genre text not null, -- genre of transaction
                poster text not null, -- image link to movie poster
                rating int not null default 1, -- rating of movie
                primary key (id)
            );");
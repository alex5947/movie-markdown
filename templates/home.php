<!DOCTYPE html>

<html lang="en">
    <head>
        <!--
          SITE URL: https://cs4640.cs.virginia.edu/ac5ug/project/
        -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet/less" type="text/css" href="styles/styles.less" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        
        <meta name="author" content="Alex Chan and Nathaniel Gonzalez">
        <meta name="description" content="Website to discover movies and add them to a personal movie list to track what movies you've watched">
        <meta name="keywords" content="Movies, IMDB, List, Entertainment, Ratings, Reviews">        
        <title>Movie Markdown</title>
        <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <script>
          function confirmLogout() {
            let text = "Are you sure you want to logout?";
            if (confirm(text) == true) {
              var ajax = new XMLHttpRequest();
              ajax.open("GET", "?command=logout", false);
              ajax.send(null);
            }
          }
        </script>
    </head>

    <body class="bg-dark">
        <!--Navigation Bar-->
        <nav class="navbar navbar-expand-lg navbar-light bg-dark bg-gradient" aria-label="nav">
            <div class="container-fluid">
              <a class="navbar-brand acitve text-light">Movie Markdown</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link active highlight text-light" aria-current="page" href="?command=homepage">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active highlight text-light" href="?command=genres">Genres</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link acitve highlight text-light" href="?command=movielist">My Movie List</a>
                  </li>
                  <!--If not logged in, will show as "Login", else if logged in, will show as "Logout"-->
                  <li class="nav-item">
                    <a href="" class="nav-link active highlight text-light" onclick="confirmLogout()">Logout</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>        

          <!--Search Bar-->
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Search</button>
          </form>

          <!--Scrollspy Side Navigation Bar-->
          <nav id="navbar-example3" class="navbar navbar-light bg-dark bg-gradient flex-column align-items-stretch p-3 sidebar" aria-label="nav">
            <a class="navbar-brand text-light">Sections</a>
            <hr class="text-light">
            <nav class="nav nav-pills flex-column" aria-label="nav">
              <a class="nav-link highlight" href="#trending">Trending</a>
              <a class="nav-link highlight" href="#popular-all-time">Popular (All-Time)</a>
              <a class="nav-link highlight" href="#plan-to-watch">Plan To Watch</a>
            </nav>
          </nav>
          
          <div class="home_sections">
            <!--Trending Section-->
            <section id="trending">
              <div class="jumbotron">
                <h3 class="display-4 text-light">Trending</h3>
                <hr class="my-4 text-light"> 
              </div>
              <!--Cards for each individual movie-->
              <section class="row">
                <?php 
                    foreach ($trending as $movie) {
                    ?>
                      <div class="card col-4 bg-dark bg-gradient" style="width: 18rem;">
                        <img src="<?php echo $movie["poster"];?>" class="card-img-top padding-top" alt="<?php echo $movie["title"];?>"> <!--Movie Thumbnail-->
                        <div class="card-body">
                          <h5 class="card-title text-light"><?php echo $movie["title"];?></h5> <!--Movie Title-->
                          <?php
                            if (in_array($movie["title"], $added)) {
                              ?>
                                <button type="button" class="btn btn-primary" disabled>Movie Added</button>
                              <?php
                            }
                            else {
                              ?>
                              <div class="trending_add_movie_button" value="<?php echo $movie["id"];?>">
                                <input type="hidden" id="trending_movieid" name="trending_movieid" value="<?php echo $movie["id"];?>"/> 
                                <button type="submit" id="trending_addmovie<?php echo $movie["id"];?>" name="trending_addmovie" class="btn btn-primary" value="<?php echo $movie["id"];?>">Add to Movie List</button>
                              </div>
                              <?php
                            }
                          ?>
                        </div>
                      </div>
                    <?php
                    }
                ?>
                <script>
                    var trending_elements = document.getElementsByClassName("trending_add_movie_button");

                    var trendingFunction = (event) => {
                      let btnValue = event.target.getAttribute("value"); 
                      let user = "<?php echo $_SESSION["user id"]; ?>";
                      $.ajax({
                        url: "../movie-markdown/classes/AddMovie.php",
                        type: "POST",
                        dataType: "json",
                        data: ({movieid: btnValue, userid: user}),
                      });

                      var id = event.target.getAttribute("id");
                      var button = document.getElementById(id);
                      button.disabled = true;
                      button.textContent = "Movie Added";
                    }

                    for (var i = 0; i < trending_elements.length; i++) {
                      let button = trending_elements[i].children[1];
                      button.addEventListener("click", trendingFunction);
                    }
                    
                </script>
              </section>
            </section>
            
            <!--Popular All Time Section-->
            <section id="popular-all-time">
              <div class="jumbotron">
                <h3 class="display-4 text-light">Popular (All-Time)</h3>
                <hr class="my-4 text-light"> 
              </div>
              <!--Cards for each individual movie-->
              <section class="row">
                <?php 
                    foreach ($popular as $movie) {
                    ?>
                      <div class="card col-4 bg-dark bg-gradient" style="width: 18rem;">
                        <img src="<?php echo $movie["poster"];?>" class="card-img-top padding-top" alt="<?php echo $movie["title"];?>"> <!--Movie Thumbnail-->
                        <div class="card-body">
                          <h5 class="card-title text-light"><?php echo $movie["title"];?></h5> <!--Movie Title-->
                          <?php
                            if (in_array($movie["title"], $added)) {
                              ?>
                                <button type="button" class="btn btn-primary" disabled>Movie Added</button>
                              <?php
                            }
                            else {
                              ?>
                              <!-- <form action="?command=homepage" class="pop_add_movie_button" method="post"> -->
                              <div class="pop_add_movie_button" value="<?php echo $movie["id"];?>">
                                <input type="hidden" id="pop_movieid" name="pop_movieid" value="<?php echo $movie["id"];?>"/> 
                                <button type="submit" id="pop_addmovie<?php echo $movie["id"];?>" name="pop_addmovie" class="btn btn-primary" value="<?php echo $movie["id"];?>">Add to Movie List</button>
                              </div>
                              <!-- </form> -->
                              <?php
                            }
                          ?>
                        </div>
                      </div>
                    <?php
                    }
                ?>
                <script>
                    var pop_elements = document.getElementsByClassName("pop_add_movie_button");

                    var popFunction = (event) => {
                      let btnValue = event.target.getAttribute("value"); 
                      let user = "<?php echo $_SESSION["user id"]; ?>";
                      $.ajax({
                        url: "../movie-markdown/classes/AddMovie.php",
                        type: "POST",
                        dataType: "json",
                        data: ({movieid: btnValue, userid: user}),
                      });

                      var id = event.target.getAttribute("id");
                      var button = document.getElementById(id);
                      button.disabled = true;
                      button.textContent = "Movie Added";
                    }

                    for (var i = 0; i < pop_elements.length; i++) {
                      let button = pop_elements[i].children[1];
                      button.addEventListener("click", popFunction);
                    }
                    
                </script>
              </section>
            </section>
            
            <!--Plan To Watch Section-->
            <section id="plan-to-watch">
              <div class="jumbotron">
                <h3 class="display-4 text-light">Plan To Watch</h3>
                <hr class="my-4 text-light"> 
              </div>
              <!--Cards for each individual movie-->
              <section class="row">
                <?php 
                    foreach ($plan_to_watch as $movie) {
                    ?>
                      <div class="card col-4 bg-dark bg-gradient" style="width: 18rem;">
                        <img src="<?php echo $movie["poster"];?>" class="card-img-top padding-top" alt="<?php echo $movie["title"];?>"> <!--Movie Thumbnail-->
                        <div class="card-body">
                          <h5 class="card-title text-light"><?php echo $movie["title"];?></h5> <!--Movie Title-->
                          <?php
                            if (in_array($movie["title"], $added)) {
                              ?>
                                 <button type="button" class="btn btn-primary" disabled>Movie Added</button>
                              <?php
                            }
                            else {
                              ?>
                              <!-- <form action="?command=homepage" class="ptw_add_movie_button" method="post" id="add_movie_button"> -->
                              <!-- <form class="ptw_add_movie_button" method="post" id="add_movie_button"> -->
                                <!-- <input type="hidden" id="movieid" name="movieid" value=""/> -->
                                <!-- <button type="submit" id="addmovie" name="addmovie" class="btn btn-primary">Add to Movie List</button> -->
                              <!-- </form> -->
                              <div class="ptw_add_movie_button" value="<?php echo $movie["id"];?>">
                                <input type="hidden" id="ptw_movieid" name="ptw_movieid" value="<?php echo $movie["id"];?>"/> 
                                <button type="submit" id="ptw_addmovie<?php echo $movie["id"];?>" name="ptw_addmovie" class="btn btn-primary" value="<?php echo $movie["id"];?>">Add to Movie List</button>
                              </div>
                            <?php
                            }
                          ?>
                        </div>
                      </div>
                    <?php
                    }
                ?>
                <script>
                    var ptw_elements = document.getElementsByClassName("ptw_add_movie_button");

                    var ptwFunction = (event) => {
                      let btnValue = event.target.getAttribute("value"); 
                      let user = "<?php echo $_SESSION["user id"]; ?>";
                      $.ajax({
                        url: "../movie-markdown/classes/AddMovie.php",
                        type: "POST",
                        dataType: "json",
                        data: ({movieid: btnValue, userid: user}),
                      });

                      var id = event.target.getAttribute("id");
                      var button = document.getElementById(id);
                      button.disabled = true;
                      button.textContent = "Movie Added";
                    }

                    for (var i = 0; i < ptw_elements.length; i++) {
                      let button = ptw_elements[i].children[1];
                      button.addEventListener("click", ptwFunction);
                    }
                    
                </script>
              </section>
            </section>
          </div>

          <footer class="py-3 my-4">
            <div class = "col-12">
            <ul class="nav justify-content-center border-bottom border-light pb-3 mb-3">
                <li class="nav-item"><a href="?command=homepage" class="nav-link px-2 text-light">Home</a></li>
                <li class="nav-item"><a href="?command=genres" class="nav-link px-2 text-light">Genres</a></li>
                <li class="nav-item"><a href="?command=movielist" class="nav-link px-2 text-light">My Movie List</a></li>
                <li class="nav-item"><a href="" class="nav-link px-2 text-light" onclick="confirmLogout()">Logout</a></li>
            </ul>
            <p class="text-center text-light">Made by Alex Chan & Nathaniel Gonzalez © 2022</p>
            </div>
          </footer>


    </body>
          
</html>
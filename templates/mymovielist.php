<!DOCTYPE html>

<html lang="en">

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet/less" type="text/css" href="styles/styles.less" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        
        <meta name="author" content="Alex Chan and Nathaniel Gonzalez">
        <meta name="description" content="List of movies current user has marked as already watched">
        <meta name="keywords" content="Movies, IMDB, List, Entertainment, Ratings, Reviews, Watched">        
        <title>My Movie List</title>
        <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body class="bg-dark">

        <!--Navigation Bar-->
        <nav class="navbar navbar-expand-lg navbar-light bg-dark bg-gradient">
            <div class="container-fluid">
              <a class="navbar-brand highlight text-light" href="index.html">Movie Markdown</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link highlight text-light" aria-current="page" href="index.html">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link highlight active text-light" href="mymovielist.html">My Movie List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link highlight text-light" href="genres.html">Genres</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link highlight text-light">My Profile</a>
                  </li>
                  <!--If not logged in, will show as "Login", else if logged in, will show as "Logout"-->
                  <li class="nav-item">
                    <a class="nav-link highlight text-light">Login/Logout</a>
                  </li>
                </ul>
              </div>
            </div>
        </nav>   
          
          
        <!--Table used to create list of Movies-->
        <div class="table-responsive">
            <table class="table list text-light">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Movie Image</th>
                        <th scope="col">Movie Title</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Rating</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      if($my_movie_list_data !== false && !empty($my_movie_list_data)){
                        $counter = 1;
                        foreach($my_movie_list_data as $movie){
                          echo "<tr class='border-bot'>";
                          echo "<td>{$counter}</td>";
                          echo "<td> <img src='{$movie['poster']}' alt='{$movie['title']}' class='list_images pop'></td> <!--Movie Image-->";
                          echo "<td class='align-middle'>{$movie['title']}</td> <!--Movie Title-->";
                          echo "<td>{$movie['genre']}</td><!--Movie Genre-->";
                          echo "<td>";
                          echo "<form action='?command=movielist' method='post'>";
                          echo "<select name='option_rating' aria-label='rating'>";
                          for ($i = 1; $i < 11; $i++){
                            if($i === $movie["rating"]){
                              echo "<option value='{$i}' selected>{$i}</option>";
                            } else {
                              echo "<option value='{$i}'>{$i}</option>";
                            }
                          }
                          echo "</select>";
                          echo "<button type='submit' class='btn btn-default btn-xs'>Set</button>";
                          echo "<input type='hidden' id='option_id' name='option_id' value='{$movie[id]}'/>";
                          echo "</form>";
                          echo "</td><!--Movie Rating-->";
                          echo "</tr>";
                          $counter += 1;
                        }
                      }
                      ?>
                  </tbody>
            </table>
        </div>

        <!--Footer Element-->
        <footer class="py-3 my-4">
          <div class = "col-12">
          <ul class="nav justify-content-center border-bottom border-light pb-3 mb-3">
              <li class="nav-item"><a href="index.html" class="nav-link px-2 text-light">Home</a></li>
              <li class="nav-item"><a href="mymovielist.html" class="nav-link px-2 text-light">My Movie List</a></li>
              <li class="nav-item"><a href="genres.html" class="nav-link px-2 text-light">Genres</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2 text-light">My Profile</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2 text-light">Login/Logout</a></li>
          </ul>
          <p class="text-center text-light">Made by Alex Chan & Nathaniel Gonzalez © 2022</p>
          </div>
        </footer>
                
      </body>
            
</html>
            
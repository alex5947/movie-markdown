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
        <script src="https://code.jquery.com/jquery-3.6.0.js"
	              integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
	              crossorigin="anonymous"></script>

        <style>
          tr {
            border-bottom: 1px solid #ffffff;
          }

          .hover{
            color:red;
            cursor:pointer;
          }

        </style>

        <!-- <script type="text/javascript">
          $(document).ready(function(){
            // displayMovies();
            getMovies();

            $(".btn-primary").hover(
                function() {
                  $(this).text("Replaced");
                }, function() {
                  $(this).text("Delete Entry");
                }
              );

            $(".btn-primary").each(function(index, element){
              $(this).click(function(){
                // $(this).remove(); // now reference using 'element' after this line
                // $(`tr:eq(${index+1})`).remove();
                $(`tr#${index}`).remove();


                let btnValue = this.value; // try using 'element' if 'this' doesn't work -- value should store movie id (unique)
                $.post("?command=remove_movie", {
                  btnValue: btnValue
                }); // change this function to be the one that handles removal of movie
              });
            });
          });
        </script> -->

    </head>

    <body class="bg-dark">

        <!--Navigation Bar-->
        <nav class="navbar navbar-expand-lg navbar-light bg-dark bg-gradient">
            <div class="container-fluid">
              <a class="navbar-brand highlight text-light" href="?command=homepage">Movie Markdown</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link highlight text-light" aria-current="page" href="?command=homepage">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link highlight active text-light" href="?command=movielist">My Movie List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link highlight text-light" href="?command=genres">Genres</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link highlight text-light">My Profile</a>
                  </li>
                  <!--If not logged in, will show as "Login", else if logged in, will show as "Logout"-->
                  <li class="nav-item">
                    <a href="?command=logout" class="nav-link highlight text-light">Logout</a>
                  </li>
                </ul>
              </div>
            </div>
        </nav>   
          
          
        <!--Table used to create list of Movies-->
        <div class="table-responsive">
            <table class="table list text-light" id="movie_table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Movie Image</th>
                        <th scope="col">Movie Title</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Remove</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      // if($my_movie_list_data !== false && !empty($my_movie_list_data)){
                      //   $counter = 1;
                      //   foreach($my_movie_list_data as $movie){
                      //     echo "<tr class='border-bot'>";
                      //     echo "<td>{$counter}</td>";
                      //     echo "<td> <img src='{$movie['poster']}' alt='{$movie['title']}' class='list_images pop'></td> <!--Movie Image-->";
                      //     echo "<td class='align-middle'>{$movie['title']}</td> <!--Movie Title-->";
                      //     echo "<td>{$movie['genre']}</td><!--Movie Genre-->";
                      //     echo "<td>";
                      //     echo "<form action='?command=movielist' method='post'>";
                      //     echo "<select name='option_rating' aria-label='rating'>";
                      //     for ($i = 1; $i < 11; $i++){
                      //       if($i === $movie["rating"]){
                      //         echo "<option value='{$i}' selected>{$i}</option>";
                      //       } else {
                      //         echo "<option value='{$i}'>{$i}</option>";
                      //       }
                      //     }
                      //     echo "</select>";
                      //     echo "<br>";
                      //     echo "<button type='submit' class='btn btn-success btn-xs' style='margin-top: 10px'>Set</button>";
                      //     echo "<input type='hidden' id='option_id' name='option_id' value='{$movie['id']}'/>";
                      //     echo "</form>";
                      //     echo "</td><!--Movie Rating-->";
                      //     echo "<form action='?command=movielist' method='post'>";
                      //     echo "<td><button type='submit' class='btn btn-link btn-xs' name='remove_movie' value='{$movie['id']}'>Delete Entry</button></td>";
                      //     echo "</form>";
                      //     echo "</tr>";
                      //     $counter += 1;
                      //   }
                      //   echo "<p class='text-light'>{$json_variable}</p>";
                      // }
                      ?>
                  </tbody>
            </table>
        </div>

        <!--Error message if ajax doesn't load json of movielist data-->
        <div id="ajax_error_msg"></div>

        <!--Footer Element-->
        <footer class="py-3 my-4">
          <div class = "col-12">
          <ul class="nav justify-content-center border-bottom border-light pb-3 mb-3">
              <li class="nav-item"><a href="?command=homepage" class="nav-link px-2 text-light">Home</a></li>
              <li class="nav-item"><a href="?command=mymovielist" class="nav-link px-2 text-light">My Movie List</a></li>
              <li class="nav-item"><a href="?command=genres" class="nav-link px-2 text-light">Genres</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2 text-light">My Profile</a></li>
              <li class="nav-item"><a href="?command=logout" class="nav-link px-2 text-light">Logout</a></li>
          </ul>
          <p class="text-center text-light">Made by Alex Chan & Nathaniel Gonzalez © 2022</p>
          </div>
        </footer>

        <script>
          var my_movies_json = null;
          
          function getMovies() {
            var ajax = new XMLHttpRequest();
            ajax.open("GET", "?command=get_movielist", true);
            ajax.responseType = "json";
            ajax.send(null);

            ajax.addEventListener("load", function () {
              if(this.status == 200){ // we properly recieved our movie_list data from our database in the form of json
                my_movies_json = this.response;
                displayMovies(); // create this function
                setClickDelete(); // keep adding button event function setters here
              }
            });

            ajax.addEventListener("error", function() {
              document.getElementById("ajax_error_msg").innerHTML =
              "<div class='alert alert-danger'>An error loading movie json data via ajax occured. In getMovies()</div>";
            });

          }

          function displayMovies() {
            var table = document.getElementById("movie_table")
            
            var cnt = 1;
            // start for-each loop here on the 'my_movies_json' object -- allows us to not need to index our json object
            my_movies_json.forEach(function(item, index){
              var newRow = table.insertRow(table.rows.length); // may need to add class name here
              newRow.id = `${index}`; // added id to row

              var newCell = newRow.insertCell(0); // first cell indicated by 0
              newCell.innerHTML = "<td>" + cnt + "</td>";
  
              newCell = newRow.insertCell(1); // second cell
              newCell.innerHTML = `<td> <img src='${item['poster']}' alt='${item['title']}' class='list_images pop'></td>`;
  
              newCell = newRow.insertCell(2); // third cell
              newCell.innerHTML = `<td class='align-middle'>${item['title']}</td>`;

              newCell = newRow.insertCell(3); // fourth cell
              newCell.innerHTML = `<td>${item['genre']}</td>`;

              newCell = newRow.insertCell(4); // fifth cell
              var sel = "<select name='option_rating' aria-label='rating'>";
              var options = "";
              for(let i = 1; i < 11; i++){
                if(i === item['rating']){
                  options += `<option value='${i}' selected>${i}</option>`;
                } else {
                  options += `<option value='${i}'>${i}</option>`;
                }
              }
              var sel_closing = "</select>";
              var button = "<button type='submit' class='btn btn-success btn-xs' style='margin-top: 10px'>Set</button>";
              newCell.innerHTML = `<td>${sel}${options}${sel_closing}<br>${button}</td>`;

              newCell = newRow.insertCell(5); // sixth cell
              newCell.innerHTML = `<td><button type='submit' class='btn btn-primary btn-xs' name='remove_movie' value='${item['id']}'>Delete Entry</button></td>`;

              cnt += 1;
            });
          }

          function setClickDelete(){
            // $(".btn-primary").hover(
            //     function() {
            //       $(this).text("Replaced");
            //     }, function() {
            //       $(this).text("Delete Entry");
            //     }
            //   );

            $(".btn-primary").each(function(index, element){
              $(this).click(function(){
                // $(this).remove(); // now reference using 'element' after this line
                // $(`tr:eq(${index+1})`).remove();
                $(`tr#${index}`).remove();


                let btnValue = this.value; // try using 'element' if 'this' doesn't work -- value should store movie id (unique)
                $.post("?command=remove_movie", {
                  btnValue: btnValue
                }); // change this function to be the one that handles removal of movie
              });
            });
          }

          getMovies();
        </script>
                
      </body>
            
</html>
            
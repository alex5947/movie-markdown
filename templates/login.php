<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Alex Chan (ac5ug) and Nathaniel Gonzalez (neg2mhs)">
        <meta name="description" content="MyMovieList Login Screen">  
        <title>MyMovieList Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    </head>
    <body>
        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                <p> Welcome to MyMovieList!  To get started, enter a name, email, and password.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                <?php
                    if (!empty($error_msg)) {
                        echo "<div class='alert alert-danger'>$error_msg</div>";
                    }
                ?>
                <form action="?command=login" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"/>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"/>
                        <div id="emhelp" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"/>
                        <div id="pwhelp" class="form-text"></div>
                    </div>
                    <div class="text-center">                
                    <button type="submit" class="btn btn-primary" id="submit" disabled>Login</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

        <!-- JavaScript login validation  -->
        <script> 

            function passwordValidate() {
                var passwordRegExp = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
                // var passwordRegExp = new RegExp("^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$") // minimum eight characters at least one letter and one number
                var pass = document.getElementById("password");
                var submit = document.getElementById("submit");
                var pwhelp = document.getElementById("pwhelp");
                var passval = pass.value;

                if (passwordRegExp.test(passval)) {
                    pass.classList.remove("is-invalid");
                    submit.disabled = false;
                    pwhelp.textContent = "";
                } else {
                    pass.classList.add("is-invalid");
                    submit.disabled = true;
                    pwhelp.textContent = "Please include at least one lowercase letter, uppercase letter, number, and special character (!,@,#,$,%,^,&,*)";
                }
            }   

            document.getElementById("password").addEventListener("keyup", function() {
                passwordValidate();
            });
            
        </script>
    </body>
</html>
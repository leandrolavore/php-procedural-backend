<?php
    session_start();
    require_once('appvars.php');    
    require_once('header.php');

    //no session, no cookie, get infor from the form and then get make session and cookies
    if(!isset($_SESSION['username'])){

        if(!isset($_COOKIE['username'])){
            //if post is submitted create everything

            if(isset($_POST['submit'])){
                // Prepare db connection
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                //take info from forms and create user pass sessions and cookies
                $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
                $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

                $query = "SELECT * FROM registered_users WHERE username = '$username' AND password = SHA('$password')";
                $data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
                mysqli_close($dbc);
                //check if the info submitted is in db, in that case 
                if(mysqli_num_rows($data) == 1){
                    $row = mysqli_fetch_array($data);
                    $user_id = $row['ID'];
                    $user_username = $row['username'];

                    $_SESSION['username'] = $user_username;
                    $_SESSION['id'] = $user_id;

                    setcookie(session_name(), time() + 7200);
                    setcookie('username', $user_username, time() + 7200);

                    $index_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php ';
                    header('Location: ' . $index_url);
                }
                //if info do't check, ask to sign up
                else{
                    echo '<p>You are not registered, please sign up <a href="signup.php">here</a></p>';
                }

            }
            //else ask for submition
            else{
                ?>

                <form method="post" action=<?php $_SERVER['PHP_SELF']?> >
                    <fieldset>
                        <legend>Log In</legend>
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username"
                        value="<?php if (!empty($username)) echo $username; ?>" /><br />
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" />
                    </fieldset>
                    <input type="submit" value="Log In" name="submit" />
                </form>

                <?php
            }

        }
        //no session but i do have the cookies, so create session and redirect
        else{
            $_SESSION['username'] = $_COOKIE['username'];
            $index_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php ';
            header('Location: ' . $index_url);
        }
    }
    //session is set but no cookies, so create cookies from session  
    else{
        //set cookies, then just redirect to wherever
        if(!isset($_COOKIE['username'])){
            setcookie(session_name(), time() + 7200);
            setcookie('username',$username, time() + 7200);
            $index_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php ';
            header('Location: ' . $index_url);
        }
        //session and cookies are set, so just redirect
        else{
            $index_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php ';
            header('Location: ' . $index_url);
        }
    }
    session_destroy();
?>
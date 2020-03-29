<?php
    session_start();
    require_once('appvars.php');  
    require_once('header.php');
    //when they submit
    if(isset($_POST['submit'])){
        //create user in db 
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

        $query = "INSERT INTO registered_users (username, password) VALUES " . 
        "('$username', SHA('$password'))";

        mysqli_query($dbc, $query);
        //if no session, start session, if no cookie start cookie
        if(!isset($_SESSION['username'])){
            $_SESSION['username'] = $user_username;
            $_SESSION['id'] = $user_id;

            setcookie(session_name(), time() + 7200);
            setcookie('username',$username, time() + 7200);

            $index_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php ';
            header('Location: ' . $index_url);
        }
        mysqli_close($dbc);
    }
    
?>
    <form method="post" action=<?php $_SERVER['PHP_SELF']?> >
        <fieldset>
            <legend>Sign Up</legend>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"
            value="<?php if (!empty($username)) echo $username; ?>" /><br />
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" />
        </fieldset>
        <input type="submit" value="Sign Up" name="submit" />
    </form>
<?php
    require_once('footer.php');
?>

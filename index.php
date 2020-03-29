<?php
    require_once('header.php');
    require_once('appvars.php');

    if(isset($_COOKIE['username']) && isset($_COOKIE[session_name()])){
        $user = $_COOKIE['username'];

        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $file_name = $_FILES['file']['name'];
            $career = $_POST['career'];
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "INSERT INTO files VALUES (0, '$name', '$file_name', '$career')";

            mysqli_query($dbc, $query);
            $target = ASSESSMENTS_UPLOAD_PATH . $career . "/" . $file_name;
            echo "<h1>Target " . $name;
            move_uploaded_file($_FILES['file']['tmp_name'], $target);
            mysqli_close($dbc);
            echo "<h1>Your file " . $name . " has been uploaded</h1>";
        }
?>
    <h1>Welcome <?php echo $user?></h1>
    <br>
    <form enctype="multipart/form-data" method="post" action=<?php $_SERVER['PHP_SELF']?>>
        <input type="hidden" name="MAX_FILE_SIZE" value="200000">
        <label for="name">Give file a title</label>
        <input type="text" id="name" name="name">
        <label for="career">Career</label>
        <input type="text" id="career" name="career">
        <input type="file" id="file" name="file">
        <input type="submit" value="Add" name="submit">
    </form><hr>
    <h1>Search assessments</h1>
    <a href="search.php">Go search</a>

<?php
    require('footer.php');
    }
    else{
?>
        <h1>Something happened</h1>
        <a href="login.php">Back to login page</a>
<?php
    }
?>
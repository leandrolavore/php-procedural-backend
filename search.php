<?php //for now I will be searching by career
    require_once('header.php');
    require_once('appvars.php');

    if(isset($_COOKIE[session_name()]) && isset($_COOKIE['username']) && !isset($_POST['search'])){
?>
        <form method="post" action=<?php $_SERVER['PHP_SELF']?> >
            <label for="career"></label>
            <select name="career" id="career">
                <option value="Hospitality">Hospitality</option>
                <option value="Cookery">Cookery</option>
            </select>
            <input type="submit" value="Search" name="search" />
        </form>

<?php
    }
    else if(isset($_COOKIE[session_name()]) && isset($_COOKIE['username']) && isset($_POST['search'])){
        //bring results and present all of the assessments for that catergory
        $career = $_POST['career'];
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "SELECT * FROM files WHERE career = '$career'";
        $data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
        $target = ASSESSMENTS_UPLOAD_PATH . $career . "/";
        
        //show results in a table
        if(mysqli_num_rows($data) > 0){
            
            while($row = mysqli_fetch_array($data)){

?>      <hr>
            <h1>Career: <?php echo $row['career']?></h1>
            <h2>File name: <?php echo $row['name']?></h2>
            <?php echo $target . $row['file_name']?>
            <h2>File: <?php echo $row['file_name']?></h2> 
            <a download="<?php echo $row['file_name']?>" href="<?php echo $target . $row['file_name']?>">download</a>
        <hr>

<?php
            } 
?>
<?php
        }
?>
<?php
        mysqli_close($dbc);
    }
    else{
?>

        <h1>You need to log in, your session expired</h1>

<?php
    }
?>
    <hr>
    <a href="index.php">Back to main</a>
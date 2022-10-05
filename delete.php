<?php
if(isset($_POST["id"]))
{
    require "connection_db.php";
    $userid = mysqli_real_escape_string($connection, $_POST["id"]);
    if(mysqli_query($connection, "DELETE FROM comments WHERE id = '$userid'")){
        header("Location: index.php");
    }
    mysqli_close($connection);    
}
?>
<?php
require_once("backend/dbConnection.php");
session_start();
$search_element=$_GET["id"];
if(isset($_SESSION["username"]))
{
 try
 {
    global $conn;
    $sql = "DELETE FROM posts WHERE id='$search_element'";
    $Execute = $conn->query($sql);
    if($Execute)
    {
        header("Location:index.php");
    }
 }
 catch(Exception $e)
 {
    echo $e;
 }
}
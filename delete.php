<?php
require "models/user.php";

$user = new User();
$id= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$user->deleteUser($id);
header("location:list.php");

?>
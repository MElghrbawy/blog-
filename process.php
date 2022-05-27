<html>
<?php
require "models/user.php";

$error_fields = array();
if (empty($_POST['name'])) {
    $error_fields[] = 'name';
}
if (!(isset($_POST['email']) && filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))) {
    $error_fields[] = 'email';
}
if (!(isset($_POST['password']) && strlen($_POST['password']) > 5)) {
    $error_fields[] = 'password';
}
if (empty($_POST['gender'])) {
    $error_fields[] = 'gender';
}
if(!($_FILES['userfile']['error']==UPLOAD_ERR_OK))
{
    $error_fields[]='avatar';
}
if ($error_fields) {
  
    header("location: add.php?errors=" . implode(",", $error_fields));
    
    exit;
}

$user = new User();
$upload_dir=$_SERVER['DOCUMENT_ROOT'].'/uploads';
$avatar='';
$tmp_dir=$_FILES['userfile']['tmp_name'];
$avatar = basename($_FILES['userfile']['name']);
move_uploaded_file($tmp_dir,"$upload_dir/$avatar");

$password = sha1($_POST['password']);
$user->addUser(['id'=>NULL,'name'=>$_POST['name'],'email'=>$_POST['email'],'password'=>$password,'avatar'=>$avatar]);
header("location: list.php");



?>

</html>
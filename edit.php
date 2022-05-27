<?php
$error_fields = array();
$conn = mysqli_connect("localhost", "root", "", "blog");
        if (!$conn) {
            echo mysqli_connect_error();
            exit;
        }
$id= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$query = "select * from users where id = ".$id." limit 1";
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    if (!$error_fields) {
        $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
        $name = mysqli_escape_string($conn, $_POST['name']);
        $email = mysqli_escape_string($conn, $_POST['email']);
        $password = (!empty($_POST['password']?sha1($_POST['password']):sha1($row['password'])));
        

        $query="update users set name = ' ".$name."' , email='".$email."',password='".$password."' where
        id = ".$id;
        if(mysqli_query($conn,$query))
        {
            header("location:list.php");
        }
        else{
            echo mysqli_errno($conn);
        }
    }
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>
<html>

<body>
    <form method="post">
        <input type="hidden" name="id" id="id" value="<?=isset($row['id'])?$row['id']:''?>"/>
        <label for="name">Name :</label>
        <input type="text" name="name" id="name" value="<?=isset($row['name'])?$row['name']:''?>"/> <?php if (in_array('name', $error_fields)) echo
            "please enter a valid name"; ?>
        <br /> <br />
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?=isset($row['email'])?$row['email']:''?>" /><?php if (in_array('email', $error_fields)) echo
                                                        "please enter a valid email"; ?>
        <br /> <br />
        <label for="password">Password :</label>
        <input type="password" name="password" id="password" /> <?php if (in_array('password', $error_fields)) echo
                                                                "please enter a valid password"; ?>
        <br /><br />
        <label for="gender">Gender :</label> <?php if (in_array('gender', $error_fields)) echo
                                                "please enter gender"; ?>
        <br />
        <input type="radio" name="gender" value="female" /> Female <br />
        <input type="radio" name="gender" value="male" /> Male <br /> <br />
        <input type="submit" name="submit" value="register" />
    </form>
</body>

</html>
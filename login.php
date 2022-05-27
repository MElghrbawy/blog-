<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "blog");
    if (!$conn) {
        echo mysqli_connect_error();
        exit;
    }
    $email = mysqli_escape_string($conn,$_POST['email']);
    $password = sha1($_POST['password']);
    $query = "select * from users where email = '".$email."' and password = '".$password."' limit 1";
    $result = mysqli_query($conn,$query);
    if($row=mysqli_fetch_assoc($result))
    {
        $_SESSION['id']=$row['id'];
        $_SESSION['email']=$row['email'];
        header("location: list.php");
        exit;
    }
    else{
        $error='invalid email or password';
    }
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>
<html>

<head>
    <title>
        Login Page
    </title>
</head>

<body>
    <?php if(isset($error)){
        echo $error ;
    }?>
    <form method="post">
        <label for="email"> Username : </label>
        <input type="text" id="email" name="email" placeholder="enter username or email " />
        <br /> <br />
        <label for="password"> Password : </label>
        <input type="password" id="password" name="password" placeholder="enter password " />
        <br /> <br />
        <input type="submit" value="login" />
    </form>
</body>

</html>
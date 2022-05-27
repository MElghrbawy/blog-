<?php
$error_fields = array();
if(isset($_GET['errors']))
{
    $error_fields=explode(",", $_GET['errors']);
}
?>
<html>

<body>
    <form method="post" action="process.php" enctype="multipart/form-data">
        <label for="name">Name :</label>
        <input type="text" name="name" id="name" /> <?php if(in_array('name',$error_fields)) echo 
        "please enter a valid name";?>
         <br /> <br /> 
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" /><?php if(in_array('email',$error_fields)) echo 
        "please enter a valid email";?>
         <br /> <br />
        <label for="password">Password :</label>
        <input type="password" name="password" id="password" /> <?php if(in_array('password',$error_fields)) echo 
        "please enter a valid password";?>
         <br /><br />
         <input type="file" name="userfile"/> <?php if(in_array('avatar',$error_fields)) echo 
        "please enter a valid avatar";?>
         <br /><br />
        <label for="gender">Gender :</label> <?php if(in_array('gender',$error_fields)) echo 
        "please enter gender";?>
         <br/>
        <input type="radio" name="gender" value="female" /> Female <br /> 
        <input type="radio" name="gender" value="male" /> Male <br /> <br />
        <input type="submit" name="submit" value="register"/>
    </form>
</body>

</html>
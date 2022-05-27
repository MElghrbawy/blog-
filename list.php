<?php
require "models/user.php";
session_start();
if(isset($_SESSION['id'])){
    echo "<h3> Welcome ".$_SESSION['email']." <a href='logout.php'> Logout</a> </h3>";
}
else
{
    header("location:login.php");
    exit;
}
$user = new User();
$users = $user->getUsers();

if(isset($_GET['search']))
{
    $users = $user->searchUsers($_GET['search']); 
    
}

?>
<html>

<head>
    <title>
        List Users
    </title>
    <style>
        table,tr,td,th{
            border: 2px black double;
        }
        img{
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body>
    <h1>
        List Users
    </h1>
    <form method="get">
        <input type="text" name="search" placeholder=" please enter {Name} or {Email} to search"/>
        <input type="submit" value="search"/>
    </form>
    <table >
        <thead>
            <tr >
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Avatar</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($users as $row ) {
        ?>
        <tr >
        <td><?= $row['id']?></td> 
        <td><?= $row['name']?></td>
        <td><?= $row['email']?></td>
        <td><?php if ($row['avatar']) { ?><img src="../uploads/<?= $row['avatar']?>"/>
            <?php } else { ?><img src="../uploads/NoImage.png"/><?php } ?>
        </td>
        <td><a href="edit.php?id=<?=$row['id']?>">Edit</a>|<a href="delete.php?id=<?=$row['id']?>">Delete</a></td>
        </tr>
        
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr >
                <td colspan="2" style="text-align:center ;"><?= count($users)?> Users</td>
                <td colspan="3" style="text-align:center;"><a href="add.php">Add User</a></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
<!-- <?php
// mysqli_free_result($result);
// mysqli_close($conn);
?> -->
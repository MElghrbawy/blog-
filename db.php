<?php
//open connection
$conn = mysqli_connect("localhost","root","","blog");
if (! $conn)
{
    echo mysqli_connect_error();
    exit;
}
// make some query 
$query="select * from users";
$result = mysqli_query($conn,$query);
 while($row=mysqli_fetch_assoc($result))
   {
    echo $row['id'] ;
    echo"<br/>";
    echo $row['name'];
    echo"<br/>";
    echo $row['email'];
    echo"<hr/>";
    }

mysqli_close($conn);
?>
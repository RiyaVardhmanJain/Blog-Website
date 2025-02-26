
//during log  in we had set the session values so now when we log out we have to unset them
<?php
include '../connect.php';
session_start();
session_unset();
session_destroy();
header("location:http://localhost/MyProj/login.php");
exit();
?>

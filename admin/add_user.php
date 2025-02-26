<?php
include "header.php";
if(isset($_POST['add_user'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $c_pass = $_POST['c_pass'];
$role=$_POST['role'];
if(strlen($username)<4 || strlen($username)>100){
    $error = "Username must be between 4 to 100 characters";
}
elseif(strlen($pass)<4){
    $error = "Password must be greater than 4 characters";
}
elseif($pass!=$c_pass){
    $error = "Password does not match";
}
else{
    $sql = "SELECT * FROM user WHERE email='$email'";
    $query = mysqli_query($config,$sql);
    $row= mysqli_num_rows($query);
    if($row){
        $error ="Email already exists";
    }
    else{
       $sql2="INSERT INTO user (username,email,password,role) VALUES('$username','$email','$pass','$role')";
       $query2 = mysqli_query($config,$sql2);
       if($query2){
        $msg = ['User added succesfully','alert-success'];
        $_SESSION['msg'] = $msg;
        header("location:users.php");
      exit();

   }
    }
}
}

?>
<div class="container mb-4">
    <div class="row">
        <div class="col-md-5 m-auto bg-white p-4 shadow-lg rounded">
            <?php
            if(!empty($error)){
                echo "<p class='bg-danger text-white p-2'>".$error."</p>";
            }
            ?>
            <form action="" method="POST">
                <h4 class="text-center text-primary mb-4">Create New User</h4>
                <div class="mb-3">
                    <input type="text" name="username" placeholder="Username" class="form-control rounded-pill" value="<?= (!empty($error))?$username:''; ?>" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" value="<?= (!empty($error))?$email:''; ?>" placeholder="Email" class="form-control rounded-pill" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" placeholder="Password" class="form-control rounded-pill" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="c_pass" placeholder="Confirm Password" class="form-control rounded-pill" required>
                </div>
                <div class="mb-3">
                    <select class="form-control rounded-pill" name="role" required>
                        <option disabled selected>Select Role</option>
                        <option value="1">Admin</option>
                        <option value="0">Co-Admin</option>
                    </select>
                </div>
                <div class="d-grid">
                    <input type="submit" name="add_user" class="btn btn-primary rounded-pill fw-bold" value="Create">
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>

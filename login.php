<?php
include 'connect.php';
include 'header.php';
session_start();
if(isset($_SESSION['user_data'])){
    header("location:http://localhost/MyProj/admin/index.php");
 }
?>

<style>
    *{
        margin: 0;
        padding: 0;
    }
    .login_box {
    margin: 50px auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    max-width: 700px;  /* Increased width */
    width: 90%; /* Responsive width */
    height: 500px; /* Increased height */
    border-radius: 12px; /* Slightly rounded edges */
    background: url('bg_image.jpg') no-repeat center center/cover;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Stronger shadow */
    padding: 50px; /* More spacing inside */
    position: relative;
    color: white; /* To ensure text is visible */
    font-weight: bold;
}


</style>

<form action="" method="POST">
    <div class="login_box">
        <div class="mb-3">
            <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Email address" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control" id="exampleFormControlInput2" placeholder="Enter your password" required>
        </div>

        <button type="Submit" name="login_btn" class="btn btn-primary">Login</button>

        <?php
        if(isset($_SESSION['error'])){
            echo "<p class='bg-danger p-2 text-white'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        ?>
    </div>
</form>


<?php
if(isset($_POST['login_btn']))
{
    $email=$_POST['email'];
    $pass=$_POST['password'];

    // Checking if the user exists in the database
    $sql = "SELECT * FROM user WHERE email='{$email}' AND password='{$pass}'";
    $query = mysqli_query($config, $sql);
    $data = mysqli_num_rows($query);

    if($data) {
        $result = mysqli_fetch_assoc($query);
        $user_data =array($result['user_id'],$result['username'],$result['role']);
        $_SESSION['user_data'] = $user_data;
        header("location:admin/index.php");
        exit();
        

    } 
    else {
        $_SESSION['error'] = "Invalid email/password";
        header("location:login.php");
       
       
    }
}
?>

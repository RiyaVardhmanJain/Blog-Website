<?php
include 'connect.php';
include 'header.php';
session_start();

if (isset($_SESSION['user_data'])) {
    header("Location: http://localhost/MyProj/admin/index.php");
    exit();
}
?>

<style>
    * {
        margin: 0;
        padding: 0;
    }
    .login_box {
        margin: 50px auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        max-width: 700px;
        width: 90%;
        height: 500px;
        border-radius: 12px;
        background: url('bg_image.jpg') no-repeat center center/cover;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        padding: 50px;
        position: relative;
        color: white;
        font-weight: bold;
    }
</style>

<form action="" method="POST">
    <div class="login_box">
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email address" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <button type="submit" name="login_btn" class="btn btn-primary">Login</button>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='bg-danger p-2 text-white'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>
    </div>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($config, $_POST['email']);
    $pass = mysqli_real_escape_string($config, $_POST['password']);

    // Checking if the user exists in the database
    $sql = "SELECT * FROM user WHERE email='$email' AND password='$pass'";
    $query = mysqli_query($config, $sql);
    $data = mysqli_num_rows($query);

    if ($data > 0) {
        $result = mysqli_fetch_assoc($query);
        $_SESSION['user_data'] = array($result['user_id'], $result['username'], $result['role']);
        header("Location: admin/index.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid email/password";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

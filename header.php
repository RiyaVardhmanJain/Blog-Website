<?php
$page = basename($_SERVER['PHP_SELF'],".php");
include 'connect.php';
$select = "SELECT * FROM categories";
$query =mysqli_query($config,$select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Blog page</title>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Blog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo ($page == "home") ? "active" : ""; ?>"" href="home.php">Home <span class="visually-hidden">(current)</span></a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Categories</a>
          <ul class="dropdown-menu">
          <?php while($cats=mysqli_fetch_assoc($query)){?>
            <li><a class="dropdown-item" href="category.php?id=<?= $cats['cat_id'];?>"><?= $cats['cat_name'];?></a></li>
          <?php } ?>
            
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($page == "login") ? "active" : ""; ?>" href="login.php">Login</a>
        </li>
      </ul>
      <?php
      if(isset($_GET['keyword'])){
        $keyword=$_GET['keyword'];
      }
      else{
        $keyword="";
      }
      ?>
      <form class="d-flex" action="search.php" method="GET">
        <input class="form-control me-sm-2" type="search" placeholder="Search" name="keyword" maxlength="20" autocomplete="off" value="<?= $keyword ?>">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>

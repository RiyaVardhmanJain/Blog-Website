<?php
   include '../connect.php';
   include 'header.php';
   if(isset($_SESSION['user_data'])){
    $author_id = $_SESSION['user_data']['2'];
   }
   $sql = "SELECT * FROM categories";
   $query=mysqli_query($config,$sql);

   ?>
<div class="container-fluid mb-4"> 
   <h5 class="mb-2 text-gray-800">Blogs</h5>
   <div class="row">
      <div class="col-xl-12 col-lg-6">
         <div class="card">
            <div class="card-header">
               <h6 class="font-weight-bold text-primary mt-2">Publish blogs</h6>
            </div>
            <div class="card-body">
               <form action="" method="POST" enctype="multipart/form-data">
                  <div class="p-4">
                     <div class="mb-3">
                        <input type="text" name="blog_title" class="form-control" placeholder="Title" required>
                     </div>
                     <div class="mb-3">
                        <label>Body</label>
                        <textarea class="form-control" name="blog_body" id="blog" rows="2" required></textarea>
                     </div>
                     <div class="mb-3">
                        <input type="file" name="blog_image" class="form-control" required>
                     </div>
                     <div class="mb-3">
                        <select name="category" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php while($cats=mysqli_fetch_assoc($query)){?>
                                <option value="<?= $cats['cat_id']; ?>"><?= $cats['cat_name']; ?></option>
                                <?php

                            }?>
                        
                       </select>
                     </div>
                     <div class="mb-3">
                        <input type="submit" name="add_blog" value="Add" class="btn btn-primary">
                        <a href="index.php" class="btn btn-secondary">Back</a>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include 'footer.php';
  if(isset($_POST['add_blog'])){
   $title = $_POST['blog_title'];
   $body = $_POST['blog_body'];
   $category = $_POST['category'];
   $filename = $_FILES['blog_image']['name'];
   $tmp_name = $_FILES['blog_image']['tmp_name'];
   $size = $_FILES['blog_image']['size'];
   $image_ext = strtolower(pathinfo($filename ,PATHINFO_EXTENSION));
   $allow_type = ['jpg','png','jpeg'];
   $destination ="upload/".$filename;
   if(in_array($image_ext, $allow_type)){
      if($size <= 2000000){
          move_uploaded_file($tmp_name, $destination);
          $sql2 = "INSERT INTO blog(blog_title, blog_body, image, category, author_id) 
                   VALUES('$title', '$body', '$filename', '$category', '$author_id')";
          $query2 = mysqli_query($config, $sql2);
          if($query2){
              $msg = ['Post published Successfully !!', 'alert-success'];
              $_SESSION['msg'] = $msg;
              header("location:add_blog.php");
              exit();
          }
      } 
      else {  
          $msg = ['Image size should not be greater than 2mb!!', 'alert-danger'];
          $_SESSION['msg'] = $msg;
          header("location:add_blog.php");
          exit();
      }
  } 
  else {  
      $msg = ['File type is not allowed !!(only jpg, png and jpeg)', 'alert-danger'];
      $_SESSION['msg'] = $msg;
      header("location:add_blog.php");
      exit();
  }
  }
  
?>

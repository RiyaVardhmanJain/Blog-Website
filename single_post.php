<?php
   include 'header.php';
   include 'connect.php';
   $id=$_GET['id'];
   if(empty($id)){
    header("location:home.php");
   }
   $sql = "SELECT * FROM blog WHERE blog_id='$id'";
   $run =mysqli_query($config,$sql);
   $post =mysqli_fetch_assoc($run);
   ?>
<div class="container mt-2">
   <div class="row">
      <div class="col-lg-8">
         <div class="card shadow">
            <div class="card-body" >
               <div id="single_img">
                <?php $img=$post['image']; ?>
                <a href="admin/upload/<?= $img ?>">
                  <img src="admin/upload/<?= $img ?>" alt="image">
                </a>
               </div>
               <hr>
               <div>
                  <h5><?= $post['blog_title']; ?></h5>
                  <p><?= $post['blog_body']; ?></p>
               </div>
            </div>
         </div>
      </div>
      <?php
       include 'sidebar.php';
      ?>
   </div>
</div>
<?php
   include 'footer.php';
   ?>

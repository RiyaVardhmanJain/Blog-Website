<?php
   include '../connect.php';
   include 'header.php'
   ?>
<div class="container-fluid mb-4">
   <h5 class="mb-2 text-gray-800">Categories</h5>
   <div class="row">
      <div  class="col-xl-6 col-lg-5">
         <div class="card">
            <div class="card-header">
               <h6 class="font-weight-bold text-primary mt-2">Add Category</h6>
            </div>
            <div  class="card-body">
               <form action="" method="POST">
                  <div class="p-4">
                     <div class="mb-3">
                        <input type="text" name="cat_name" class="form-control" placeholder="Category name" required>
                     </div>
                     <div class="mb-3">
                        <input type="submit" name="add_cat" value="Add" class="btn btn-primary">
                        <a href="categories.php" class="btn btn-secondary">Back</a>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
include 'footer.php';
if(isset($_POST['add_cat'])){
   $cat_name = $_POST['cat_name'];
   //to check if the category is already present in database

   $sql = "SELECT * FROM categories WHERE cat_name='{$cat_name}'";

   $query = mysqli_query($config,$sql);

   $row=mysqli_num_rows($query);
   if($row){
      $msg = ['Category name already exists','alert-danger'];
      $_SESSION['msg'] = $msg;
      header("location:add_cat.php");
      exit();
   }
   else{
    $sql1 = "INSERT INTO categories (cat_name) VALUES ('$cat_name')";

    $query1 = mysqli_query($config,$sql1);
      if($query1){
        $msg = ['Category added Successfully !!','alert-success'];
        $_SESSION['msg'] =$msg;
        header("location:add_cat.php");
        exit();
    }
   }
}

?>
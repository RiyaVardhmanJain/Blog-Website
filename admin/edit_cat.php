<?php
   include '../connect.php';
   include 'header.php';
   if(isset($_GET['id'])) { 
    $id = $_GET['id']; 
}
   if(empty($id)){
      header("location:categories.php");
   }
   $sql = "SELECT * FROM categories WHERE cat_id ='$id'";
   $query= mysqli_query($config,$sql);
   $row= mysqli_fetch_assoc($query);
?>
<div class="container">
   <h5 class="mb-2 text-gray-800">Categories</h5>
   <div class="row">
      <div  class="col-xl-6 col-lg-5">
         <div class="card">
            <div class="card-header">
               <h6 class="font-weight-bold text-primary mt-2">Edit Category</h6>
            </div>
            <div  class="card-body">
               <form action="" method="POST">
                  <div class="p-4">
                     <div class="mb-3">
                        <input type="text" name="cat_name" class="form-control" placeholder="Category name" required value="<?=$row['cat_name'];?>">
                     </div>
                     <div class="mb-3">
                        <input type="submit" name="update_cat" value="Update" class="btn btn-primary">
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
if(isset($_POST['update_cat'])){            
    $cat_name = $_POST['cat_name'];

    $sql2 = "UPDATE categories SET cat_name='{$cat_name}' WHERE cat_id='{$id}'";
    $update = mysqli_query($config,$sql2);
    if($update){
        $msg = ['Category name updated succesfully','alert-success'];
        $_SESSION['msg'] = $msg;
        header("location:categories.php");
        exit();
     }
     else{
          $msg = ['Failed !!','alert-danger'];
          $_SESSION['msg'] =$msg;
          header("location:categories.php");
          exit();
      }
     }
 
 ?>


<?php
include 'header.php';
if($admin!=1){
   header("location:index.php");
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
   <!-- Page Heading -->
   <h5 class="mb-2 text-gray-800">Categories</h5>
   <!-- DataTales Example -->
   <div class="card shadow">
      <div class="card-header py-3 d-flex justify-content-between">
         <div>
            <a href="add_cat.php">
               <h6 class="font-weight-bold text-primary mt-2">Add New</h6>
            </a>
         </div>
         <div>
            <form class="navbar-search">
               <div class="input-group">
                  <input type="text" class="form-control bg-white border-0 small" placeholder="Search for...">
                  <div class="input-group-append">
                     <button class="btn btn-primary" type="button"> <i class="fa fa-search"></i> </button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
               <thead>
                  <tr>
                     <th>Sr.No</th>
                     <th>Category Name</th>
                     <th colspan="2">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                   $sql = "SELECT * FROM categories";
                   $query = mysqli_query($config,$sql);
                   $rows=mysqli_num_rows($query);
                   $count = 1;
                   if($rows)
                   {
                     while($row = mysqli_fetch_assoc($query)){
                        ?>
                        <tr>
                           <td><?= $count++ ?></td>
                           <td><?= $row['cat_name'] ?></td>
                           <td>
                              <a href="edit_cat.php?id=<?=$row['cat_id'] ?>" class="btn btn-sm btn-success">Edit</a>                           
                     </td>
                     <td>
                        <form action="" method="POST" onsubmit= "return confirm('Are you sure you want to delete?')">
                           <input  type="hidden" name="catID" value="<?= $row['cat_id'] ?>">
                        <input type="submit" name="delete_cat" value="Delete" class="btn btn-sm btn-danger">
                        </form>
                     </td>
                           
                        </tr>
                        <?php
                     }

                   }
                   else{
                     ?>
                     <tr><td colspan=4>No record Found  </td><tr>
                     <?php
                   }
                   ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<!-- /.container-fluid -->
</div>
<?php
include 'footer.php';
if(isset($_POST['delete_cat'])){
   $id=$_POST['catID'];
   $delete = "DELETE FROM categories WHERE cat_id='$id' ";
   $run=mysqli_query($config,$delete);
   if($run){
      $msg = ['Category name deleted successfully','alert-success'];
      $_SESSION['msg'] = $msg;
      header("location:categories.php");
      exit();
   }
   else{
      $msg = ['Failed','alert-danger'];
      $_SESSION['msg'] = $msg;
      header("location:categories.php");
      exit();
   }
}
?>

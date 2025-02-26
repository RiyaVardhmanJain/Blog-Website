<?php
include 'connect.php';
include 'header.php';
$keyword= $_GET['keyword'];
if(empty($keyword)){
    header("location:home.php");
}
// pagination
if(!isset($_GET['page'])){
	$page = 1;
}
else{
$page=$_GET['page'];
}
$limit=4;
$offset=($page-1)*$limit; //formula of offset

// --------------------------------
$sql="SELECT * FROM blog LEFT JOIN categories ON blog.category=categories.cat_id LEFT JOIN user ON blog.author_id=user.user_id WHERE blog_title like '%$keyword%' or blog_body like '%$keyword%' ORDER BY blog.publish_date DESC limit $offset,$limit";
$run=mysqli_query($config,$sql);
$row=mysqli_num_rows($run);

?>
<div class="container-fluid mt-2">
	<div class="row">
    <h4 class="mt-3 mb-3">
    Search result for: 
    <span class="fw-bold text-danger"><?= htmlspecialchars($keyword) ?></span>
    </h4>

		<div class="col-lg-8">
            <hr>
            <?php 
            if($row){
                while($result=mysqli_fetch_assoc($run)){
            ?>   

			<div class="card shadow">

				<div class="card-body d-flex blog_flex">
					<div class="flex-part1">
						<a href="single_post.php?id=<?= $result['blog_id']; ?>">
                        <?php 
                         $img = $result['image'];
                        ?>    
                        <img src="admin/upload/<?= $img; ?>"> </a>
					</div>
					<div class="flex-grow-1 flex-part2">
						  <a href="single_post.php?id=<?= $result['blog_id']; ?>" id="title">
                            <?= $result['blog_title']; ?>
                          </a>
						<p>
						  <a href="single_post.php?id=<?= $result['blog_id']; ?>" id="body">
                          <?= strip_tags(substr($result['blog_body'],0,200))."..."; ?>
						  </a> <span><br>
                          <a href="single_post.php?id=<?= $result['blog_id']; ?>" class="btn btn-sm btn-outline-primary">Continue Reading
                          </a></span>
                        </p>
						<ul>
							<li class="me-2"><a href=""> <span>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
							<?= $result['username']; ?>
							</a>
							</li>
							<li class="me-2">
								<a href=""> <span><i class="fa fa-calendar-o" aria-hidden="true"></i></span> 
							    <?php $date=$result['publish_date']; ?>
								<?= date('d-M-Y',strtotime($date)); ?>
							</a>
							</li>
							<li>
								<a href="category.php?id=<?= $result['cat_id'];?>" class="text-primary"> <span><i class="fa fa-tag" aria-hidden="true"></i></span> 
							  <?= $result['cat_name']; ?>
							</a>
						    </li>
						</ul>
					</div>
				</div>
			</div>
            <?php 
                }
            }else{
                echo "<h5 class='text-danger'>No Record Found !</h5>
                <b>Suggestions:</b>
                <li>Make sure that all words are spelled correctly.</li>
                <li>Try different keywords.</li>";
            } ?> 
			<!-- Pagination begins -->
			 <?php 
			 $pagination ="SELECT * FROM blog LEFT JOIN categories ON blog.category=categories.cat_id 
                           LEFT JOIN user ON blog.author_id=user.user_id WHERE blog_title LIKE '%$keyword%' OR blog_body LIKE '%$keyword%'";
			 $run_q=mysqli_query($config,$pagination);
			 $total_post=mysqli_num_rows($run_q);
			 $pages=ceil($total_post/$limit); //total pagination pages
            ?>
			<ul class="pagination pt-2 pb-5">
				<?php for($i=1;$i<=$pages;$i++){ ?>
			     <li class="page-item <?= ($i==$page) ? $active="active": "";?>">
					<a href="search.php?keyword=<?=$keyword?>&page=<?=$i?>" class="page-link"><?= $i ?></a>
				 </li> 
				 <?php } ?>
		    </ul>


		<!-- -------------------------------------------------	 -->
		</div>
		<?php
        include 'sidebar.php'; 
        ?>
	</div>
</div>




<?php
include 'footer.php';

?>
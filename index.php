<?php
session_start();
include 'connect.php';
include 'header.php';

// Fetch featured posts (most recent 3 posts)
$featured_sql = "SELECT * FROM blog 
                LEFT JOIN categories ON blog.category=categories.cat_id 
                LEFT JOIN user ON blog.author_id=user.user_id 
                ORDER BY blog.publish_date DESC LIMIT 3";
$featured_run = mysqli_query($config, $featured_sql);
$featured_count = mysqli_num_rows($featured_run);

// Fetch recent categories for the "Why Choose Us" section
$categories_sql = "SELECT cat_name, cat_id, COUNT(blog_id) as post_count 
                  FROM categories 
                  LEFT JOIN blog ON categories.cat_id = blog.category 
                  GROUP BY cat_id 
                  ORDER BY post_count DESC 
                  LIMIT 3";
$categories_run = mysqli_query($config, $categories_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Haven | Your Daily Inspiration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3a6ea5;
            --secondary-color: #f8f9fa;
            --accent-color: #ff6b6b;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('images/blog-hero.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 40px;
            border-radius: 0 0 20px 20px;
        }
        
        .hero-title {
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .featured-section {
            padding: 40px 0;
        }
        
        .feature-card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        
        .card-title {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .card-title a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .card-title a:hover {
            color: #2c5282;
        }
        
        .category-badge {
            background-color: var(--accent-color);
            color: white;
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 10px;
            text-decoration: none;
        }
        
        .category-badge:hover {
            background-color: #ff5252;
            color: white;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #2c5282;
            transform: scale(1.05);
        }
        
        .newsletter-section {
            background-color: var(--primary-color);
            padding: 50px 0;
            color: white;
            border-radius: 20px;
            margin: 40px 0;
        }
        
        .cta-section {
            background-color: var(--secondary-color);
            padding: 60px 0;
            border-radius: 20px;
        }
        
        .icon-feature {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .meta-info {
            font-size: 0.8rem;
            color: #6c757d;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .meta-info i {
            margin-right: 5px;
        }
        
        .meta-info span {
            margin-right: 15px;
        }
        
        .category-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="hero-title">Welcome to Blog Haven</h1>
            <p class="hero-subtitle">Discover thought-provoking articles, expert insights, and inspiring stories to fuel your curiosity</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="home.php" class="btn btn-primary btn-lg"><i class="fas fa-book-open me-2"></i>Explore Blogs</a>
            </div>
        </div>
    </section>
    
    <!-- Featured Posts Section -->
    <section class="featured-section">
        <div class="container">
            <h2 class="text-center mb-5">Featured Posts</h2>
            <div class="row">
                <?php 
                if($featured_count > 0):
                    while($featured = mysqli_fetch_assoc($featured_run)):
                ?>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <a href="single_post.php?id=<?= $featured['blog_id']; ?>">
                            <img src="admin/upload/<?= $featured['image']; ?>" alt="<?= $featured['blog_title']; ?>" class="feature-img">
                        </a>
                        <div class="card-body">
                            <a href="category.php?id=<?= $featured['cat_id']; ?>" class="category-badge">
                                <?= $featured['cat_name']; ?>
                            </a>
                            <h5 class="card-title">
                                <a href="single_post.php?id=<?= $featured['blog_id']; ?>">
                                    <?= $featured['blog_title']; ?>
                                </a>
                            </h5>
                            <div class="meta-info">
                                <span><i class="fas fa-user"></i> <?= $featured['username']; ?></span>
                                <span><i class="fas fa-calendar"></i> <?= date('d-M-Y', strtotime($featured['publish_date'])); ?></span>
                            </div>
                            <p class="card-text"><?= strip_tags(substr($featured['blog_body'], 0, 120))."..."; ?></p>
                            <a href="single_post.php?id=<?= $featured['blog_id']; ?>" class="btn btn-sm btn-outline-primary">Read More</a>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile;
                else:
                ?>
                <!-- Default cards if no featured posts are found -->
                <div class="col-md-4">
                    <div class="card feature-card">
                        <img src="images/placeholder-1.jpg" alt="Featured post" class="feature-img">
                        <div class="card-body">
                            <span class="category-badge">Technology</span>
                            <h5 class="card-title">The Future of AI in Everyday Life</h5>
                            <p class="card-text">Explore how artificial intelligence is transforming our daily routines and what to expect in the coming years.</p>
                            <a href="home.php" class="btn btn-sm btn-outline-primary">Browse Blogs</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card">
                        <img src="images/placeholder-2.jpg" alt="Featured post" class="feature-img">
                        <div class="card-body">
                            <span class="category-badge">Lifestyle</span>
                            <h5 class="card-title">Mindfulness Practices for Busy Professionals</h5>
                            <p class="card-text">Simple techniques to incorporate mindfulness into your hectic schedule and improve overall well-being.</p>
                            <a href="home.php" class="btn btn-sm btn-outline-primary">Browse Blogs</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card">
                        <img src="images/placeholder-3.jpg" alt="Featured post" class="feature-img">
                        <div class="card-body">
                            <span class="category-badge">Travel</span>
                            <h5 class="card-title">Hidden Gems: Unexplored Destinations</h5>
                            <p class="card-text">Discover breathtaking locations off the beaten path that offer authentic experiences away from tourist crowds.</p>
                            <a href="home.php" class="btn btn-sm btn-outline-primary">Browse Blogs</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container text-center">
            <h3 class="mb-4">Stay Updated with Our Newsletter</h3>
            <p class="mb-4">Get the latest articles, resources, and exclusive content delivered straight to your inbox.</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form class="d-flex" action="subscribe.php" method="POST">
                        <input type="email" name="email" class="form-control form-control-lg me-2" placeholder="Your email address" required>
                        <button type="submit" class="btn btn-light px-4">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Categories Section -->
    <!-- <section class="cta-section">
        <div class="container">
            <h2 class="text-center mb-5">Explore Our Categories</h2>
            <div class="row text-center">
                <?php 
                if(mysqli_num_rows($categories_run) > 0):
                    $icons = ['fas fa-laptop-code', 'fas fa-heart', 'fas fa-plane'];
                    $i = 0;
                    while($category = mysqli_fetch_assoc($categories_run)):
                ?>
                <div class="col-md-4 mb-4">
                    <div class="category-icon">
                        <i class="<?= $icons[$i++]; ?>"></i>
                    </div>
                    <h4><?= $category['cat_name']; ?></h4>
                    <p><?= $category['post_count']; ?> articles to explore in this category</p>
                    <a href="category.php?id=<?= $category['cat_id']; ?>" class="btn btn-outline-primary">Explore Category</a>
                </div>
                <?php 
                    endwhile;
                else:
                ?>
                <div class="col-md-4 mb-4">
                    <div class="icon-feature">
                        <i class="fas fa-pen-fancy"></i>
                    </div>
                    <h4>Quality Content</h4>
                    <p>Our articles are crafted by experts and passionate writers dedicated to providing valuable insights.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="icon-feature">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Vibrant Community</h4>
                    <p>Join thousands of readers and writers who share your interests and passions.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="icon-feature">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h4>Mobile Friendly</h4>
                    <p>Enjoy our content seamlessly across all your devices, wherever you are.</p>
                </div>
                <?php endif; ?>
            </div>
            <div class="text-center mt-4">
                <a href="home.php" class="btn btn-primary btn-lg">Start Exploring</a>
            </div>
        </div>
    </section>
     -->
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
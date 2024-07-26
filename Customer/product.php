<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Baker - Bakery Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    
    <style>
      body {
        font-family: Arial, sans-serif;
      }

      ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        border: 1px solid #000;
        width: 200px;
      }

      li a {
        display: block;
        color: #000;
        padding: 8px 16px;
        text-decoration: none;
      }
      .menu ul {
        background-color: white
      }
      .menu ul li a{
        padding: 10px;
      }
      .menu ul li a:hover {
        background-color: goldenrod;
        color: white;
      }

      .dropdown-arrow {
        float: right;
        color: orange;
      }
    </style>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->
    <?php 
            require_once "./controllers/product_controller.php";
            $productController = new ProductController();
            require_once "./controllers/loaisanpham_controller.php";
            $LoaiSanPhamController = new LoaisanphamController();
            $categories = $LoaiSanPhamController-> index();
            require_once "./models/product_model.php";
            $categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : null;
            // Gọi phương thức displayProducts với categoryId
            $products = $productController->displayProducts($categoryId);
            $product = array();
            session_start();
            if (isset($_SESSION['user_id'])) {
            // Lấy giá trị `user_id` từ session
            $userId = $_SESSION['user_id'];
            // $userNumber = $_SESSION['user_number'];
            // Xuất giá trị `user_id`
            $message = "Email: $userId";
            // $message2 = "User Number: $userNumber";

            } else {
            // `user_id` không tồn tại trong session
            $message = "Khách hàng chưa đăng nhập vào cửa hàng";
            }
            if(isset($_POST['logout_customer']) && ($_SESSION['user_id'])){
                session_destroy();
                header("Location: dangnhap.php");
                exit();
            }
           
            
            ?>

    <!-- Topbar Start -->
    <div class="container-fluid top-bar bg-dark text-light px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="row gx-0 align-items-center pb-2 d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="small text-light" href="#"><?php echo $message ?></a></li>
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post"> 
                    <?php if (isset($_SESSION['user_id'])) : ?>
                    <li class="breadcrumb-item">
                           
                        <button type="submit" name="logout_customer">Đăng xuất</button>
                        
                    </li>
                    <?php endif; ?>
                    </form>
                </ol>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.php" class="navbar-brand ms-4 ms-lg-0">
            <h1 class="text-primary m-0">Baker</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            
        
        <!-- Tìm kiếm -->
            <form action="timkiem.php" method="get">
                <div class="form-group d-flex align-items-center">
                    <input type="search" class="form-control ms-2" name="search_term" id="search_term" aria-describedby="helpId" placeholder="Tìm kiếm sản phẩm">
                    <button type="submit" class="" style="background: none;border: none;">
                    <i class="fa fa-search text-primary"></i>
                    </button>
                </div>
            </form>                    
            <div class="navbar-nav mx-auto p-4 p-lg-0">
                
                <a href="index.php" class="nav-item nav-link active">Trang chủ</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Loại sản phẩm</a>
                    <div class="dropdown-menu m-0">
                            <?php if(!empty($categories)): ?>
                            <?php foreach($categories as $category):?>
                                <li><a href="product.php?categoryId=<?php echo $category['MaLSP'] ?>"><?php echo $category['TenLSP']?></a> </li> 
                            <?php endforeach;?>
                           <?php else: ?>
                            <p>không có sản phẩm</p>
                            <?php endif;?>
                        
                    </div>
                </div>
                <a href="product.php?page=sanpham" class="nav-item nav-link" >Sản phẩm</a>
                <a href="dangnhap.php" class="nav-item nav-link"><i class="bi bi-person-circle"></i> Tài khoản</a>
                <a href="cart.php" class="nav-item nav-link">
                    <span class="cart-icon-container">
                        <i class="bi bi-cart"></i>
                        <span class="cart-quantity-badge"><?php
                        if (isset($_SESSION['cart'])) {
                    // Lấy số lượng phần tử trong session['cart']
                    $cartCount = count($_SESSION['cart']);

                    // Hiển thị số lượng phần tử
                    echo  $cartCount; }
                        ?></span>
                    Giỏ hàng
                    </span>
                </a>

            </div>
            <div class=" d-none d-lg-flex mr-2">
                     
            </div>
            
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-6 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center pt-5 pb-3">
            <h1 class="display-4 text-white animated slideInDown mb-3">Trang sản phẩm</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Product Start -->
    <div class=" bg-light my-6 py-6 pt-0" style="margin: 12rem 0;">
        <div class="container">
            <div class="bg-primary text-light rounded-bottom p-5 my-6 mt-0 wow fadeInUp" data-wow-delay="0.1s">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <h1 class=" text-light mb-0">HƯỞNG THỨC BÁNH NGON</h1>
                    </div>
                    <div class="col-lg-6 text-lg-end">
                        <div class="d-inline-flex align-items-center text-start">
                            <i class="fa fa-phone-alt fa-4x flex-shrink-0"></i>
                            <div class="ms-4">
                                <p class="fs-5 fw-bold mb-0">Liên hệ với chúng tôi</p>
                                <p class="fs-1 fw-bold mb-0">+012 345 6789</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                                <h1 class="display-6 mb-4">Khám phá các danh mục sản phẩm bánh của chúng tôi</h1>
                            </div>
            <div class="container">
                <div class="row">
                    <div class="menu col-lg-4">
                        <h4 class="home " >DANH MỤC SẢN PHẨM</h4>
                        <ul class="p-0">
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <li><a class="dropdown-item" href="product.php?categoryId=<?php echo $category['MaLSP'] ?>"><?php echo $category['TenLSP'] ?></a></li>
                                    <hr class="m-0" >
                                <?php endforeach; ?>
                                <?php else: ?>
                                <li class="dropdown-item">Không có sản phẩm</li>
                                <?php endif; ?>
                        </ul>
                    </div>
                    <div class="col-lg-8">
                <div class="row g-4">
                    <?php if(!empty($products)):; ?>
                    <?php foreach($products as $product):;?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="product-item d-flex flex-column bg-white rounded overflow-hidden ">
                            <div class="text-center p-4">
                                <div class="d-inline-block border border-primary rounded-pill px-3 mb-3"><?php echo $product['DonGia'];?></div>
                                <h3 class="mb-3"><?php echo $product['TenSP'];?></h3>
                            </div>
                            <div class="position-relative ">
                                <img class="img-fluid" src="<?php echo $product['HinhAnh'] ?>" alt="">
                                <div class="product-overlay">
                                    <a class="btn btn-lg-square btn-outline-light rounded-circle" href="detail.php?id=<?php echo $product['MaSP']; ?>&categoryId=<?php echo $product['MaLSP']; ?>"><i class="fa fa-eye text-primary"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    <?php else: ?>
                            <h1>Không có sản phẩm</h1>
                    <?php endif;?>
                </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Product End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer my-6 mb-0 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Office Address</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Photo Gallery</h4>
                    <div class="row g-2">
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="img/product-1.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="img/product-2.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="img/product-3.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="img/product-2.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="img/product-3.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="img/product-1.jpg" alt="Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Copyright Start -->
    <div class="container-fluid copyright text-light py-4 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                    <br>Distributed By: <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
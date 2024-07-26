<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Baker - Bakery Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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
    <link rel="stylesheet" href="css/detail.css">
</head>

<body>
    <?php 
        require_once "./controllers/loaisanpham_controller.php";
        require_once "./controllers/product_controller.php";
        require_once "./models/product_model.php";
        $LoaiSanPhamController = new LoaisanphamController();
        $productController = new ProductController();
        $categories = $LoaiSanPhamController-> index();
        $product_id = $_GET['id'];
        $detailProducts = $productController->detail($product_id);
        $categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : null;
            // Gọi phương thức displayProducts với categoryId
        $products = $productController->displayProducts($categoryId);
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
    <!-- Spinner Start -->
    
    <!-- Spinner End -->


    <!-- Topbar Start -->
    
    <!-- <div class="container-fluid top-bar bg-dark text-light px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="small text-light" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="small text-light" href="#">Career</a></li>
                    <li class="breadcrumb-item"><a class="small text-light" href="#">Terms</a></li>
                    <li class="breadcrumb-item"><a class="small text-light" href="#">Privacy</a></li>
                </ol>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Follow us:</small>
                <div class="h-100 d-inline-flex align-items-center">
                    <a class="btn-lg-square text-primary border-end rounded-0" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn-lg-square text-primary border-end rounded-0" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn-lg-square text-primary border-end rounded-0" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn-lg-square text-primary pe-0" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Topbar End -->


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
           <form action="timkiem.php" method="get">
                <div class="form-group d-flex align-items-center">
                    <input type="search" class="form-control ms-2" name="search_term" id="search_term" aria-describedby="helpId" placeholder="Tìm kiếm sản phẩm">
                    <button type="submit" class="" style="background: none;border: none;">
                    <i class="fa fa-search text-primary"></i>
                    </button>
                </div>
            </form>     
            <div class="navbar-nav mx-auto p-4 p-lg-0">
                
                <a href="index.php?page=index" class="nav-item nav-link active">Home</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Loại sản phẩm</a>
                    <div class="dropdown-menu m-0">
                            <?php if(!empty($categories)): ?>
                            <?php foreach($categories as $category):?>
                                <li> <a href="product.php?categoryId=<?php echo $category['MaLSP'] ?>"><?php echo $category['TenLSP']?></a> </li> 
                            <?php endforeach;?>
                           </a>
                           <?php else: ?>
                            <p>không có sản phẩm</p>
                            <?php endif;?>
                        
                    </div>
                </div>
                <a href="product.php?page=sanpham" class="nav-item nav-link" >Products</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu m-0">
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
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
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.php?page=index" class="navbar-brand ms-4 ms-lg-0">
            <h1 class="text-primary m-0">Baker</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="form-group">
                  <input type="search" class="form-control " name="" id="" aria-describedby="helpId" placeholder="Tìm kiếm sản phẩm">
                </div>
                <i class="fa fa-search text-primary"></i>
            <div class="navbar-nav mx-auto p-4 p-lg-0">
                
                <a href="" class="nav-item nav-link active">Home</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Loại sản phẩm</a>
                    <div class="dropdown-menu m-0">
                            <?php if(!empty($categories)): ?>
                           <a href="team.html" class="dropdown-item">
                            <?php foreach($categories as $category):?>
                                <li> <a href="product.php?categoryId=<?php echo $category['MaLSP'] ?>"><?php echo $category['TenLSP']?></a> </li> 
                            <?php endforeach;?>
                           </a>
                           <?php else: ?>
                            <p>không có sản phẩm</p>
                            <?php endif;?>
                        
                    </div>
                </div>
                <a href="product.php?page=sanpham" class="nav-item nav-link" >Products</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu m-0">
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
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
    <?php 
        @include('dieuhuong.php');
    ?>
    <!-- About End -->


    <!-- Product Start -->
    <div class="container-xxl bg-light my-6 py-6 pt-5 mt-6">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-6 mb-4">Thông tin của sản phẩm</h1>
            </div>
            <div class="card p-0">
                
                    <div class="container-fliud ">
                        <div class="wrapper row">
                            <div class="preview col-md-6 bg-light ">
                                <?php if(!empty($detailProducts)):; ?>
                                <?php foreach($detailProducts as $detailProduct):;?>
                                <div class="preview-pic tab-content">
                                <div class="tab-pane active" id="pic-1"><img src="<?php echo $detailProduct['HinhAnh'] ?>" /></div>
                                </div>
                                
                            </div>
                            <div class="details col-md-6 pl-3 bg-white" style="">
                                <h3 class="$detailProducts-title" ><?php echo $detailProduct['TenSP'];?></h3>
                                <div class="rating">
                                    <div class="stars">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                    <span class="review-no">41 lượt xem</span>
                                </div>
                                <p class="$detailProducts-description">Suspendisse quos? Tempus cras iure temporibus? Eu laudantium cubilia sem sem! Repudiandae et! Massa senectus enim minim sociosqu delectus posuere.</p>
                                <h4 class="price">giá tiền: <span><?php echo $detailProduct['DonGia'];?></span></h4>
                            <form action="cart.php" method="post">
                                    <input type="<?php 
                                    if($detailProduct['SoLuong'] > 0){
                                    echo "number";
                                    } else {
                                        echo "hidden";
                                    }
                                    ?>" name="soluong" min="0" max="<?php echo $detailProduct['SoLuong'];?>"  value="1">
                                <p><?php 
                                if($detailProduct['SoLuong'] > 0){
                                echo "Còn lại:".$detailProduct['SoLuong'];
                                } else {
                                    echo 'Rất tiếc! Sản phẩm đã được bán hết mời quý khách mua những mặt hàng khác!';
                                }
                                ?></p>
                                <p class="vote"><strong>91%</strong> of buyers enjoyed this $detailProducts! <strong>(87 votes)</strong></p>
                                
                                
                                    <div>
                                        <?php 
                                            if($detailProduct['SoLuong'] > 0){
                                                echo '<input class="like btn btn-default" type="submit" value="Đặt hàng" name="add_to_cart">';
                                            } else{
                                                echo '<input class="like btn btn-default" type="submit" disabled  value="Đặt hàng" name="add_to_cart">';
                                            }
                                        ?>
                                        <!-- <a class="add-to-cart btn btn-default" type="submit" name="add_to_cart">Add to cart</a> -->                                        <input type="hidden" name="tensp" value="<?php echo $detailProduct['TenSP'];?>">
                                        <input type="hidden" name="masp" value="<?php echo $detailProduct['MaSP'];?>">
                                        <input type="hidden" name="hinhanh" value="<?php echo $detailProduct['HinhAnh'] ?>">
                                        <input type="hidden" name="dongia" value="<?php echo $detailProduct['DonGia'];?>">
                                        
                                    </div>
                            </form>
                                
                            </div>
                        </div>
                        <?php endforeach;?>
                        <?php else: ?>
                            <p>không có sản phẩm</p>
                        <?php endif;?>
                    </div>       
                
		    </div>
        </div>
    </div>
    <!-- Product End -->


    <!-- Related Start -->
    <div class=" bg-light my-6 py-6 pt-0" >
        <div class="container">
            
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-6 mb-4">Khám phá các sản phẩm liên quan</h1>
            </div>
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
                            <p>không có sản phẩm</p>
                    <?php endif;?>
                </div>
        </div>
    </div>
    <!-- Related End -->


    <!-- Team Start -->
    <div class="container-xxl py-6">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="text-primary text-uppercase mb-2">// Our Team</p>
                <h1 class="display-6 mb-4">We're Super Professional At Our Skills</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <img class="img-fluid" src="img/team-1.jpg" alt="">
                        <div class="team-text">
                            <div class="team-title">
                                <h5>Full Name</h5>
                                <span>Designation</span>
                            </div>
                            <div class="team-social">
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <img class="img-fluid" src="img/team-2.jpg" alt="">
                        <div class="team-text">
                            <div class="team-title">
                                <h5>Full Name</h5>
                                <span>Designation</span>
                            </div>
                            <div class="team-social">
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <img class="img-fluid" src="img/team-3.jpg" alt="">
                        <div class="team-text">
                            <div class="team-title">
                                <h5>Full Name</h5>
                                <span>Designation</span>
                            </div>
                            <div class="team-social">
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <img class="img-fluid" src="img/team-4.jpg" alt="">
                        <div class="team-text">
                            <div class="team-title">
                                <h5>Full Name</h5>
                                <span>Designation</span>
                            </div>
                            <div class="team-social">
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


    <!-- Testimonial Start -->
    <div class="container-xxl bg-light my-6 py-6 pb-0">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="text-primary text-uppercase mb-2">// Client's Review</p>
                <h1 class="display-6 mb-4">More Than 20000+ Customers Trusted Us</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item bg-white rounded p-4">
                    <div class="d-flex align-items-center mb-4">
                        <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-1.jpg" alt="">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-white rounded p-4">
                    <div class="d-flex align-items-center mb-4">
                        <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-2.jpg" alt="">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-white rounded p-4">
                    <div class="d-flex align-items-center mb-4">
                        <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-3.jpg" alt="">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-white rounded p-4">
                    <div class="d-flex align-items-center mb-4">
                        <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-4.jpg" alt="">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
            </div>
            <div class="bg-primary text-light rounded-top p-5 my-6 mb-0 wow fadeInUp" data-wow-delay="0.1s">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="display-4 text-light mb-0">Subscribe Our Newsletter</h1>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="position-relative">
                            <input class="form-control bg-transparent border-light w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                            <button type="button" class="btn btn-dark py-2 px-3 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


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
                            <img class="img-fluid bg-light rounded p-1" src="img/$detailProducts-1.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="img/$detailProducts-2.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="img/$detailProducts-3.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="img/$detailProducts-2.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="img/$detailProducts-3.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="img/$detailProducts-1.jpg" alt="Image">
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
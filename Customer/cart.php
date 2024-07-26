<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Trang giỏ hàng</title>
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
    <link rel="stylesheet" href="css/cart.css">
</head>

<body>
    <?php
        

// Giả sử bạn đã kết nối cơ sở dữ liệu
require_once './controllers/product_controller.php';
require_once './database.php';
$db = new Database();
$productController = new ProductController();

session_start();
//xóa hết trong giỏ hàng
if (isset($_GET['delcart']) && ($_GET['delcart'] == 1)) {
    unset($_SESSION['cart']);
}
//xóa sản phẩm trong giỏ hàng
if (isset($_GET['delid'])) {
    $delid = (int)$_GET['delid']; // Convert to integer
    if (isset($_SESSION['cart'][$delid])) {
        unset($_SESSION['cart'][$delid]);
    }
}

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
// Xử lý thêm sản phẩm vào giỏ hàng
if (isset($_POST['add_to_cart'])&&($_POST['add_to_cart'])) {
    $tensp=$_POST['tensp'];
    $hinh=$_POST['hinhanh'];
    $dongia=$_POST['dongia'];
    $soluong=$_POST['soluong'];
    $masp = $_POST['masp'];

    //Kiểm tra sản phẩm có trong giỏ hàng hay không
    $flag = 0; //Kieerm tra san pham co trung nhau hay khong
    for($i= 0;$i<sizeof($_SESSION['cart']);$i++) {
      if($_SESSION['cart'][$i][1]==$tensp){
        $flag = 1;
        $soluongnew = $soluong + $_SESSION['cart'][$i][3];
        $_SESSION['cart'][$i][3] = $soluongnew;
        break;
      }
    }
    //neu khong turng san pham trong gio hang thi them moi
    if($flag == 0){
    $sp = [$hinh,$tensp,$dongia,$soluong,$masp];
    $_SESSION['cart'][] = $sp;
    }
}
if(isset($_POST['delid'])){
  
}
global $tong;
function showCart(){
  if(isset($_SESSION['cart'])&&(is_array($_SESSION['cart']))){
    global $tong; // Access global $tong variable
    $tong = 0; // Initialize $tong to 0 
    for($i=0;$i<sizeof($_SESSION['cart']);$i++){
     
      $tt = $_SESSION['cart'][$i][2] * $_SESSION['cart'][$i][3];
      $tong += $tt;
      echo '<div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="d-flex flex-row align-items-center">
                        <div>
                          <img
                            src="'.$_SESSION['cart'][$i][0].'"
                            class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                        </div>
                        <div class="ms-3">
                          <h5>'.$_SESSION['cart'][$i][1].' </h5>
                          <p class="small mb-0">256GB, Navy Blue</p>
                        </div>
                      </div>
                      <div class="d-flex flex-row align-items-center">
                        <div style="width: 50px;">
                          <h5 class="fw-normal mb-0">'.(isset($_SESSION['cart'][$i][3]) ? $_SESSION['cart'][$i][3] : 1).'</h5>
                        </div>
                        <div style="width: 100px;">
                          <h5 class="mb-0">'.number_format($tt, 3, '.', ',').'</h5>
                        </div>
                        <a href="cart.php?delid='.$i.'" name="remove" style="color: #cecece;"><i class="fas fa-trash-alt"></i></a>
                      </div>
                    </div>
                  </div>
                </div>';
    } 
  }
  if($_SESSION['cart'] == null){
    echo '<h3 class="text-danger">Giỏ hàng rỗng hay mua sắm!</h3>';
  }
}
  
  




    ?> 
<section class="h-100 h-custom" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card">
          <div class="card-body p-4">

            <div class="row">

              <div class="col-lg-7">
                <h5 class="mb-3"><a href="index.php" class="text-body"><i
                      class="fas fa-long-arrow-alt-left me-2"></i>Tiếp tục mua sắm</a></h5>
                <hr>
                <h5 class="mb-3"><a href="cart.php?delcart=1" class="text-body"><i class="bi bi-trash"></i> Xóa tất cả</a></h5>
                <hr>

                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <p class="mb-0"><?php if (isset($_SESSION['cart'])) {
                    // Lấy số lượng phần tử trong session['cart']
                    $cartCount = count($_SESSION['cart']);

                    // Hiển thị số lượng phần tử
                    echo "Số lượng sản phẩm trong giỏ hàng: " . $cartCount; }?></p>
                  </div>
                </div>
                <?php showCart(); ?>
                

                

                

                

              </div>
              <div class="col-lg-5">

                <div class="card bg-primary text-white rounded-3">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                      <h5 class="mb-0">Thông tin giỏ hàng</h5>
                    </div>
                    <hr class="my-4">
                    <!-- <div class="d-flex justify-content-between">
                      <p class="mb-2">Shipping</p>
                      <p class="mb-2">$20.00</p>
                    </div> -->

                    <div class="d-flex justify-content-between mb-4">
                      <p class="mb-2">Tổng cộng</p>
                      <p class="mb-2"><?php echo number_format($tong, 3, '.', ','); ?>đ</p>
                    </div>
                    <form action="thanhtoan.php" method="post">
                    <button   type="submit" name="checkout" data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-block btn-lg">
                     
                    <div class="d-flex justify-content-between">
                        <span>Thanh toán <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                        <span>(<?php echo number_format($tong, 3, '.', ','); ?>đ)</span>
                      </div>
                    </button>
                    </form> 
                  </div>
                </div>

              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal thanh toán -->
  <!-- Button trigger modal -->
</section>

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
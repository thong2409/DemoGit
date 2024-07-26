<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/thanhtoan.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1TAeFtQaIWUhLN2YEaQyAYCiYeBytKE+zrE3bi7JlRaFNk1+cGQH2yIOBVSLcwj6TgxrWREjVwSKoqGosOMyMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
 
  <body>
    <div class="form_thongtin2">
      <p style="text-align: center;"><i class="fa fa-credit-card fa-4x" aria-hidden="true"></i></p>
      <h1 style="text-align: center;">Thanh toán</h1>
      <p style="text-align: center;"><small >Vui lòng kiểm tra thông tin Khách hàng, thông tin Giỏ hàng trước khi đặt</small></p>
      
    </div>
      <div class="container">
        <div class="row">
           <?php 
              require_once './database.php';
              $db = new Database();
              session_start();
              
              if(isset($_SESSION['user_id'])){
                $userEmail = $_SESSION['user_id'];
                $userSdt = $_SESSION['user_number'];
                $userName = $_SESSION['user_name'];
                $userAddress = $_SESSION['user_address'];
              }
  if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  }
  if (isset($_POST['checkout'])) {
  if (empty($_SESSION['user_id'])) {
     echo 
      '<script>
        alert("Bạn chưa đăng nhập!Vui lòng đăng nhập để thanh toán!");
      </script>';
     echo '<meta http-equiv="refresh" content="0;URL=./dangnhap.php">';
    // echo '<meta http-equiv="refresh" content="0;URL=./thanhtoan.php">';
  }
}
$error = " ";
if(isset($_POST['order'])) {
  if(isset($_POST['payment_method']) && isset($_POST['payment_method'])){
  $masp;
  $soluongmua;
  // Kết nối cơ sở dữ liệu
  if(isset($_SESSION['cart'])&&(is_array($_SESSION['cart']))){
    $cart = $_SESSION['cart'];
    for($i = 0; $i< count($cart); $i++){
      $masp = $cart[$i]['4'];
      $soluongmua = $cart[$i]['3'];
    }
      // Lấy số lượng hiện tại của sản phẩm
      $sql = "SELECT SoLuong FROM sanpham WHERE MaSP = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $masp);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $soluongcon = $row['SoLuong'];

      // Cập nhật số lượng sản phẩm
      $sql = "UPDATE sanpham SET SoLuong = SoLuong - ? WHERE MaSP = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("ii", $soluongmua, $masp);

      if (!$stmt->execute()) {
          echo "Lỗi cập nhật số lượng sản phẩm: " . $stmt->error;
      } else {
          echo "Cập nhật số lượng thành công!";
      }
    }
    echo 
      '<script>
        alert("Bạn đã đặt hàng thành công! Hãy tiếp tục mua sắm");
      </script>';
     echo '<meta http-equiv="refresh" content="0;URL=./index.php">';
     $_SESSION['cart']= [];
  }else{
  $error = "Vui lòng chọn phương thức thanh toán!";
     }
     
     

  }
 
  if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
function showCart(){
  if(isset($_SESSION['cart'])&&(is_array($_SESSION['cart']))){
    global $tong; // Access global $tong variable
    $tong = 0; // Initialize $tong to 0 
    for($i=0;$i<sizeof($_SESSION['cart']);$i++){
     
      $tt = $_SESSION['cart'][$i][2] * $_SESSION['cart'][$i][3];
      $tong += $tt;
      
                          echo'
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">'.$_SESSION['cart'][$i][1].'</h6>
                                    <small class="text-muted">'.$_SESSION['cart'][$i][2].' x '.$_SESSION['cart'][$i][3].'</small>
                                </div>
                                <span class="text-muted">'.number_format($tt, 3, '.', ',').'đ</span>
                            </li>           
                            ';
    } 
  }
  if($_SESSION['cart'] == null){
    echo '<h3 class="text-danger">Giỏ hàng rỗng hay mua sắm!</h3>';
  }
}
            ?>
            <div class="col-lg-8 form_thongtin">
                <div class="">
                <h1>Thông tin khách hàng</h1>
                    <div class="form-group">
                      <label for="">Tên khách hàng:</label>
                      <input type="text"
                        class="form-control" name="" value="<?php echo $userName ?>" disabled id="" aria-describedby="helpId" placeholder="">
                      <small id="helpId" class="form-text text-muted">Help text</small>
                    </div>
                    <div class="form-group">
                      <label for="">Địa chỉ:</label>
                      <input type="text"
                        class="form-control" name="" value="<?php echo $userAddress ?>" disabled id="" aria-describedby="helpId" placeholder="">
                      <small id="helpId" class="form-text text-muted">Help text</small>
                    </div>
                    <div class="form-group">
                      <label for="">Số điện thoại:</label>
                      <input type="text" disabled
                        class="form-control" name="" value="<?php echo $userSdt ?>" disabled id="" aria-describedby="helpId" placeholder="">
                      <small id="helpId" class="form-text text-muted">Help text</small>
                    </div>
                    <div class="form-group">
                      <label for="">Email:</label>
                      <input type="text"
                        class="form-control" disabled value="<?php echo $userEmail ?>" name="" id="" aria-describedby="helpId" placeholder="">
                      <small id="helpId" class="form-text text-muted">Help text</small>
                    </div>
                <h1>Hình thức thanh toán</h1>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="payment_method" value="cash"> 
                        Tiền mặt
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="payment_method" value="transfer"> Chuyển khoản
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="payment_method"value="cod">Ship COD
                    </label>
                </div>
                <p class="text-danger"><?php echo $error; ?></p>
                <hr>
                <button type="submit" name="order" style="width: 100%;" class="btn btn-primary">Đặt hàng</button>
                </form>
                </div>
            </div>
            <div class="col-lg-4 form_giohang">
                    <div class="row">
                      
                        <div class="col-md-6">
                            <h2>Giỏ hàng</h2> 
                        </div>
                        <div class="col-md-6">
                          <span class="badge badge-secondary badge-pill" style="float:right">
                          <?php if (isset($_SESSION['cart'])) {
                          // Lấy số lượng phần tử trong session['cart']
                          $cartCount = count($_SESSION['cart']);

                          // Hiển thị số lượng phần tử
                          echo  $cartCount; }?>  
                          </span>
                        </div>
                        
                    </div>    
                    <ul class="list-group mb-3">
                    <?php showCart()?>
                    <li class="list-group-item d-flex justify-content-between">
                                <span>Tổng thành tiền</span>
                                <strong><?php echo ''.number_format($tong, 3, '.', ',').'đ' ?></strong>
                            </li>
                    </ul>
                </div>
            </div>
        </div>
      </div>
          <h5 class="mb-3"><a href="index.php" class="text-body"><i class="bi bi-arrow-bar-left"></i>Continue shopping</a></h5>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

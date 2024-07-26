<!doctype html>
<html lang="en">
  <head>
	<title>Title</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <?php
session_start();
		
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] != true) {
    header('Location: login.php'); // Chuyển hướng đến trang login
    exit;
}

if(isset($_POST['checkout']) && ($_SESSION['staffEmail'])){
	session_destroy();
    header("Location: login.php");
    exit();
}
?>
  <body>
	<div>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<?php 
			if(isset($_SESSION['staffEmail']) && ($_SESSION['is_logged_in']) == true){
			echo 'Xin chào, '.$_SESSION['staffName'];
			} ?>
			<br>
			<button type="submit" name="checkout" class="btn btn-primary">Đăng xuất</button>
		</form>
	</div>
	  <div class="container">
			<div class="card" style="width:40%">
				<div class="card-header">
				<h2>Các trang quản lý</h2>	
				</div>
				<div class="card-body">
					<ul style="padding-left: 20px; color: blue;" type="none">
						<li style="margin-bottom: 10px;"><a href="QLSP.php?page=quanlysanpham">Trang Quản lý sản phẩm</a></li>
						<li style="margin-bottom: 10px;"><a href="QLKH.php?page=quanlykhachhang">Trang Quản lý Khách Hàng</a></li>
						<?php 
							if(isset($_SESSION['role']) && $_SESSION['role'] == 1){
    							echo '<li style="margin-bottom: 10px;"><a href="QLNV.php?page=quanlynhanvien">Trang Quản lý Nhân Viên</a></li>';
							}
							
						?>
					</ul>
				</div>
			</div>
	  </div>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
<!DOCTYPE html>
<html lang="en">

<?php
session_start();
		
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] != true) {
    header('Location: login.php'); // Chuyển hướng đến trang login
    exit;
}
?>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="Zenix - Crypto Admin Dashboard">
	<meta property="og:title" content="Zenix - Crypto Admin Dashboard">
	<meta property="og:description" content="Zenix - Crypto Admin Dashboard">
	<meta property="og:image" content="https://zenix.dexignzone.com/xhtml/social-image.png">
	<meta name="format-detection" content="telephone=no">
	<title>Trang sản phẩm</title>
	
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
	<link rel="stylesheet" href="vendor/chartist/css/chartist.min.css">
	<link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	
</head>

<body>
	<h5 class="mb-3"><a href="index.php" class="text-body"><i class="bi bi-arrow-bar-left"></i>Về trang quản lý</a></h5>
		
		
		<div class="content-body m-0">
			
			
			<!-- NộiDung -->
			<div class="col-lg-12">
				<?php
				require_once 'qlsp_controller.php';
				$productController = new ProductController();
				// lấy danh sách sẩn phẩm
				$products = $productController->displayProducts();
				// lấy tên loại sản phẩm
				$categories = $productController->displayCategories();
				$message = '';
				$error = '';
				$delay = 1; // Thời gian chờ (5 giây trong ví dụ này)
				$redirect_url = "QLSP.php?page=quanlysanpham";
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					if (isset($_POST['add_product'])) {
						$result = $productController->handleAddproduct();
						// header("Location: $delay;url=$redirect_url");
						if ($result) {

							$message = " thêm sản phẩm thành công";
						} else {
							$error = "chỉnh sửa sản phẩm thất bại";
						}
					} elseif (isset($_POST['edit_product'])) {
						$result = $productController->handleEditproduct();
						// header("Location: $delay;url=$redirect_url");
						if ($result) {

							$message = " chỉnh sửa sản phẩm thành công";
						} else {
							$error = "chỉnh sửa sản phẩm thất bại";
						}
					} elseif (isset($_POST['delete_product'])) {
						$result = $productController->handleDeleteProduct();

						if ($result) {

							$message = "Xóa sản phẩm thành công";
						} else {
							$error = "Xóa sửa sản phẩm thất bại";
						}
					}
					header('Location: QLSP.php?page=quanlysanpham');
				}
				?>
			</div>
	
				<div class="card-header">
					<div class="d-flex align-items-center flex-wrap mr-auto">
						<h4 class="card-title">Danh sách sản phẩm</h4>
						<?php if ($message) : ?>
							<div class="alert alert-success">
								<?php echo $message; ?>
							</div>
						<?php elseif ($error) : ?>
							<div class="alert alert-danger">
								<?php echo $error; ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="d-flex align-items-center">
						<div class="input-group search-area right d-lg-inline-flex d-none m-2 me-2" style="border: 1px solid #1afb47;">
							<input type="text" class="form-control" placeholder="Tìm sản phẩm">
							<div class="input-group-append">
								<span class="input-group-text">
									<a href="#">
										<i class="flaticon-381-search-2"></i>
									</a>
								</span>
							</div>
						</div>
						<!-- //modal thêm sản phẩm -->
						<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target=".bd-example-modal-lg">Thêm mới</button>
						<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Thêm mới sản phẩm</h5>
										<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
										</button>
									</div>

									<div class="modal-body">
										<div class="basic-form">
											<form action="" method="POST" enctype="multipart/form-data">
												<div class="row">
													<div class="col-sm-6 mt-2">
														<div class="form-group">
															<label>Chọn tên sản phẩm</label>
															<input type="text" name="name" class="form-control" placeholder="Tên sản phẩm" required>
														</div>
													</div>
													<div class="col-sm-6 mt-2">
														<div class="form-group">
															<label>Loại sản phẩm</label>
															<select name="category" class="form-control default-select" required>
																<?php foreach ($categories as $category) : ?>
																	<option value="<?php echo $category['MaLSP']; ?>"><?php echo $category['TenLSP']; ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>
													<div class="col-sm-6 mt-2">
														<div class="form-group">
															<label>Chọn đơn vị tính</label>
															<select name="unit" class="form-control default-select" required>
																<option value="Cái">Cái</option>
																<option value="Chiếc">Chiếc</option>
																<option value="Kg">Kg</option>
															</select>
														</div>
													</div>
													<!-- <div class="col-sm-6 mt-2">
														<div class="form-group">
															<label>Chọn số lượng</label>
															<input type="number" name="quantity" class="form-control" placeholder="Số lượng" required>
														</div>
													</div> -->
													<div class="col-sm-6 mt-2">
														<div class="form-group">
															<label>Chọn đơn giá</label>
															<input type="number" name="price" step="0.01" class="form-control" placeholder="Đơn giá" required>
														</div>
													</div>
													<div class="col-sm-6 mt-2">
														<div class="form-group">
															<label>Số lượng:</label>
															<input type="number" name="quantity" step="0.01" class="form-control" placeholder="Số lượng" required>
														</div>
													</div>
													<div class="col-sm-6 mt-2">
														<div class="form-group">
															<label>Chọn hình ảnh</label>
															<input type="file" name="image" class="form-control" required>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger light" data-dismiss="modal">Hủy</button>
													<button type="submit" name="add_product" class="btn btn-primary">Thêm mới</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Hiển thị danh sách sản phẩm -->
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-md">
							<thead>
								<tr>
									<th><strong>Tên sản phẩm</strong></th>
									<th><strong>Loại sản phẩm</strong></th>
									<th><strong>Hình ảnh</strong></th>
									<th><strong>Đơn vị tính</strong></th>
									<th><strong>Số lượng</strong></th>
									<th><strong>Đơn giá</strong></th>
									<th><strong>Hành động</strong></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($products)) : ?>
									<?php foreach ($products as $product) : ?>
										<tr>
											<td><strong><?php echo $product['TenSP']; ?></strong></td>
											<td>
												<div class="d-flex align-items-center"></i> <?php echo $product['TenLSP']; ?> </div>
											</td>
											<td>
												<div class="d-flex align-items-center"><img src="<?php echo  $product['HinhAnh']; ?>" class="rounded-lg mr-2" width="96" alt=""></div>
											</td>
											<td>
												<div class="d-flex align-items-center"></i> <?php echo $product['DonViTinh']; ?> </div>
											</td>
											<td>
												<div class="d-flex align-items-center"></i> <?php echo $product['SoLuong']; ?> </div>
											</td>
											<td>
												<div class="d-flex align-items-center"></i> <?php echo number_format($product['DonGia'], 3, '.', ','); ?> </div>
											</td>
											<td>
												<div class="d-flex">
													<!-- Edit -->
													<a href="#" class="btn btn-primary shadow btn-xs sharp mr-1 btn-edit" data-id="<?php echo $product['MaSP']; ?>" data-name="<?php echo $product['TenSP']; ?>" data-category="<?php echo $product['MaLSP']; ?>" data-unit="<?php echo $product['DonViTinh']; ?>" data-price="<?php echo $product['DonGia']; ?>" data-image="<?php echo  $product['HinhAnh']; ?>" data-toggle="modal" data-target="#edit-example-modal-lg"><i class="fa fa-pencil"></i></a>
													<!-- Xóa -->
													<form action="QLSP.php" method="POST" style="display: inline-block;">
														<input type="hidden" name="product_id" value="<?php echo $product['MaSP']; ?>">
														<button type="submit" name="delete_product" href="#" class="btn btn-danger shadow btn-xs sharp mr-1 " onclick="return confirm('bạn có chắc muốn xóa không');"><i class="fa fa-trash"></i></button>

													</form>

													<a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-info-circle"></i></a>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else : ?>
									<tr>
										<td colspan="12">Không có sản phẩm nào.</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>

				<!-- End nội dung -->

			</div>

			<!--**********************************
            Content body end
        ***********************************-->

			<!--**********************************
            Footer start
        ***********************************-->
			<div class="footer">
				<div class="copyright">
					<p>Copyright © Designed &amp; Developed by <a href="../index.htm" target="_blank">DexignZone</a> 2021</p>
				</div>
			</div>
			<!--**********************************
            Footer end
        ***********************************-->





			<!--**********************************
           Support ticket button start
        ***********************************-->

			<!--**********************************
           Support ticket button end
        ***********************************-->


		</div>
		<!--**********************************
        Main wrapper end
    ***********************************-->

		<!--**********************************
        Scripts
    ***********************************-->
		<!-- Required vendors -->
		<script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
		<script src="vendor/global/global.min.js"></script>
		<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
		<script src="vendor/chart.js/Chart.bundle.min.js"></script>

		<!-- Chart piety plugin files -->
		<script src="vendor/peity/jquery.peity.min.js"></script>

		<!-- Apex Chart -->
		<script src="vendor/apexchart/apexchart.js"></script>

		<!-- Dashboard 1 -->
		<script src="js/dashboard/dashboard-1.js"></script>

		<script src="vendor/owl-carousel/owl.carousel.js"></script>
		<script src="js/custom.min.js"></script>
		<script src="js/deznav-init.js"></script>
		<script src="js/demo.js"></script>
		<script src="js/styleSwitcher.js"></script>




		<!-- modal Edit -->
		<div class="modal fade" id="edit-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Thay đổi thông tin sản phẩm</h5>
						<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
					</div>
					<div class="modal-body">
						<div class="basic-form">
							<form action="QLSP.php" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="id" id="edit-id">
								<input type="hidden" name="existing_image" id="edit-existing_image">
								<div class="row">
									<div class="col-sm-6 mt-2">
										<div class="form-group">
											<label>Chọn tên sản phẩm</label>
											<input type="text" name="name" class="form-control" id="edit-name" required>
										</div>
									</div>
									<div class="col-sm-6 mt-2">
										<div class="form-group">
											<label>Loại sản phẩm</label>
											<select name="category" class="form-control default-select" id="edit-category" required>
												<?php foreach ($categories as $category) : ?>
													<option value="<?php echo $category['MaLSP']; ?>"><?php echo $category['TenLSP']; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-sm-6 mt-2">
										<div class="form-group">
											<label>Chọn đơn vị tính</label>
											<select name="unit" class="form-control default-select" id="edit-unit" required>
												<option value="Cái">Cái</option>
												<option value="Chiếc">Chiếc</option>
												<option value="Kg">Kg</option>
											</select>
										</div>
									</div>
									<!-- <div class="col-sm-6 mt-2">
											<div class="form-group">
												<label>Chọn số lượng</label>
												<input type="number" name="quantity" class="form-control" id="edit-quantity" required>
											</div>
										</div> -->
									<div class="col-sm-6 mt-2">
										<div class="form-group">
											<label>Chọn đơn giá</label>
											<input type="number" name="price" step="0.01" class="form-control" id="edit-price" required>
										</div>
									</div>
									<div class="col-sm-6 mt-2">
										<div class="form-group">
											<label>Số lượng:</label>
											<input type="number" name="quantity" step="0.01" class="form-control" placeholder="Số lượng" required>
										</div>
									</div>
									<div class="col-sm-6 mt-2">
										<div class="form-group">
											<label>Chọn hình ảnh</label>
											<input type="file" name="image" class="form-control" id="edit-image">
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger light" data-dismiss="modal">Hủy</button>
									<button type="submit" name="edit_product" class="btn btn-primary">Thay đổi</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>


	<!-- đoạn script xử lý lấy giá trị trên từng thuộc tính -->
	<script>
		document.querySelectorAll('.btn-edit').forEach(button => {
			button.addEventListener('click', event => {
				event.preventDefault();
				// Đoạn mã const productId = button.getAttribute('data-id'); 
				// có mục đích lấy giá trị của thuộc tính data-id từ phần tử button và gán nó vào biến productId.

				// Trong HTML, data-* là một loại thuộc tính tùy chỉnh cho phép bạn
				// lưu trữ dữ liệu bổ sung trực tiếp trên một phần tử (như một nút hoặc một mục danh sách)
				// mà không cần sử dụng các cấu trúc dữ liệu phức tạp như cookie hoặc cơ sở dữ liệu cục bộ.
				// Trong trường hợp này, data-id có thể chứa ID của một sản phẩm,
				//     giúp bạn xác định sản phẩm mà người dùng đã tương tác trong giao diện người dùng.

				// Ví dụ, nếu bạn có một nút mua hàng cho mỗi sản phẩm trên trang web của mình,
				// bạn có thể sử dụng data-id để lưu trữ ID sản phẩm tương ứng với mỗi nút.
				// Khi người dùng nhấp vào nút, bạn có thể sử dụng đoạn mã trên để lấy ID 
				// sản phẩm và thực hiện hành động phù hợp (như thêm sản phẩm vào giỏ hàng).
				const productId = button.getAttribute('data-id');
				const productName = button.getAttribute('data-name');
				const productCategory = button.getAttribute('data-category');
				const productUnit = button.getAttribute('data-unit');
				// const productQuantity = button.getAttribute('data-quantity');
				const productPrice = button.getAttribute('data-price');
				const productImage = button.getAttribute('data-image');

				document.getElementById('edit-id').value = productId;
				document.getElementById('edit-name').value = productName;
				document.getElementById('edit-category').value = productCategory;
				document.getElementById('edit-unit').value = productUnit;
				// document.getElementById('edit-quantity').value = productQuantity;
				document.getElementById('edit-price').value = productPrice;
				document.getElementById('edit-existing_image').value = productImage;
			});
		});
	</script>
	<!-- modal giỏ hàng -->
	<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Giỏ hàng</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<table class="table table-bordered mb-0">
						<tr >
							<td></td>
							<td style="width:120px">QTY:
								<input  class="form-control input-qty" type="number" min="1">
							</td>
							<td class="text-right"></td>
							<td>
								<button ><span class="fa fa-trash"></span></button>
							</td>
						</tr>
						<tr >
							<td colspan="4" class="text-center">Cart is empty</td>
						</tr>
						<tr >
							<td></td>
							<td class="text-right">Cart Total </td>
							<td class="text-right text-danger font-weight-bold"></td>
							<td></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

				</div>
			</div>
		</div>
	</div>
</body>

</html>
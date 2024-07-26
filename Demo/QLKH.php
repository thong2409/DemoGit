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
	<title>Dashboard</title>
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1TAeFtQaIWUhLN2YEaQyAYCiYeBytKE+zrE3bi7JlRaFNk1+cGQH2yIOBVSLcwj6TgxrWREjVwSKoqGosOMyMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="vendor/chartist/css/chartist.min.css">
	<link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	
</head>

<body>
<h5 class="mb-3"><a href="index.php" class="text-body"><i class="bi bi-arrow-bar-left"></i>Về trang quản lý</a></h5>
	<div id="main-wrapper">

		<div class="content-body m-0">
			<div class="container-fluid">
				<div class="form-head mb-sm-5 mb-3 d-flex flex-wrap align-items-center">
					<h2 class="font-w600 title mb-2 mr-auto ">Quản Lý Khách Hàng</h2>
					<div class="weather-btn mb-2">
						<span class="mr-3 font-w600 text-black"><i class="fa fa-cloud mr-2"></i>21</span>
						<select class="form-control style-1 default-select  mr-3 ">
							<option>Medan, IDN</option>
							<option>Jakarta, IDN</option>
							<option>Surabaya, IDN</option>
						</select>
					</div>

					<!-- <button type="submit" class="text-danger"><a href="AddProducts.php">Thêm sản phẩm</a></button> -->
				</div>
				<!-- NộiDung -->
				<div class="col-lg-12">
					<?php
					require_once 'qlkh_controller.php';
					$customerController = new CustomerController();
					$customers = $customerController->displayCustomers();
					$message = '';
					$error = '';
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						if (isset($_POST['add_customer'])) {
							$result = $customerController->handleAddcustomer();

							if ($result) {
								
								$message = " thêm khách hàng thành công";
							} else {
								$error = "chỉnh sửa khách hàng thất bại";
							}
						} elseif (isset($_POST['edit_customer'])) {
							$result = $customerController->handleEditcustomer();

							if ($result) {
								
								$message = " chỉnh sửa khách hàng thành công";
							} else {
								$error = "chỉnh sửa khách hàng thất bại";
							}
						} elseif (isset($_POST['delete_customer'])) {
							$result = $customerController->handleDeleteCustom();

							if ($result) {
								
								$message = "Xóa sản phẩm thành công";
							} else {
								$error = "Xóa sửa sản phẩm thất bại";
							}
						}
					}
					?>

					<div class="card-header">
						<div class="d-flex align-items-center flex-wrap mr-auto">
							<h4 class="card-title">Danh sách khách hàng</h4>
						</div>
						<div class="d-flex align-items-center">
							<div class="input-group search-area right d-lg-inline-flex d-none m-2 me-2" style="border: 1px solid #1afb47;">
								<input type="text" class="form-control" placeholder="Tìm tên khách hàng">
								<div class="input-group-append">
									<span class="input-group-text">
										<a href="#">
											<i class="flaticon-381-search-2"></i>
										</a>
									</span>
								</div>
							</div>
							<!-- //modal thêm khách hàng -->
							<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target=".bd-example-modal-lg">Thêm mới</button>
							<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Thêm khách hàng</h5>
											<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<div class="card-body">
												<div class="basic-form">
													<form action="" method="POST" id="add_customer_form" enctype="multipart/form-data">

														<div class="form-row">

															<div class="form-group col-md-6">
																<label>Tên khách hàng</label>
																<input type="text" name="TenKH" class="form-control" placeholder="tên khách hàng">
															</div>
															<div class="form-group col-md-6">
																<label>Địa chỉ</label>
																<input type="text" name="DiaChi" class="form-control" placeholder="Nhập địa chỉ">
															</div>
															<div class="form-group col-md-6">
																<label>Điện thoại</label>
																<input type="text" name="SDT" class="form-control" placeholder="Nhập số điện thoại">
															</div>
															<div class="form-group col-md-6">
																<label for="">Email</label>
																<input type="text" name="Email" class="form-control" placeholder="Nhập email">
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-danger light" data-dismiss="modal">Hủy</button>
															<button type="submit" name="add_customer" id="add_customer_btn" class="btn btn-primary">Thêm khách hàng</button>
														</div>
													</form>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-responsive-md" id="customer-list">
								<thead>
									<tr>
										<th><strong>MaKH</strong></th>
										<th><strong>TenKH</strong></th>
										<th><strong>Diachi</strong></th>
										<th><strong>Đienthoai</strong></th>
										<th><strong>Email</strong></th>

									</tr>
								</thead>
								<tbody>
									<?php if (!empty($customers)) : ?>
										<?php foreach ($customers as $customer) : ?>
											<tr>

												<td>
													<div class="d-flex align-items-center"></i> <?php echo $customer['MaKH']; ?> </div>
												</td>
												<td>
													<div class="d-flex align-items-center"></i><?php echo $customer['TenKH']; ?></div>
												</td>
												<td>
													<div class="d-flex align-items-center"></i> <?php echo $customer['DiaChi']; ?> </div>
												</td>
												<td>
													<div class="d-flex align-items-center"></i> <?php echo $customer['DienThoai']; ?> </div>
												</td>
												<td>
													<div class="d-flex align-items-center"></i> <?php echo $customer['Email']; ?> </div>
												</td>

												<td>
													<div class="d-flex">
														<a href="#" class="btn btn-primary shadow btn-xs sharp mr-1 btn-edit" data-id="<?php echo $customer['MaKH']; ?>" data-name="<?php echo $customer['TenKH']; ?>" data-diachi="<?php echo $customer['DiaChi']; ?>" data-dienthoai="<?php echo $customer['DienThoai']; ?>" data-email="<?php echo  $customer['Email']; ?>" data-toggle="modal" data-target="#edit-example-modal-lg"><i class="fa fa-pencil"></i></a>
														<form action="QLKH.php" method="POST" style="display: inline-block;">
															<input type="hidden" name="customer_id" value="<?php echo $customer['MaKH']; ?>">
															<button type="submit" name="delete_customer" href="#" class="btn btn-danger shadow btn-xs sharp mr-1 " onclick="return confirm('bạn có chắc muốn xóa không');"><i class="fa fa-trash"></i></button>

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


				<!-- modal Edit -->
				<div class="modal fade" id="edit-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Thay đổi thông tin khách hàng</h5>
								<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
							</div>
							<div class="modal-body">
								<div class="basic-form">
									<form action="QLKH.php" method="POST" enctype="multipart/form-data">
										<input type="hidden" name="id" id="edit-id">
										<!-- <input type="hidden" name="existing_image" id="edit-existing_image"> -->
										<div class="row">
											<div class="col-sm-6 mt-2">
												<div class="form-group">
													<label>Chọn tên khách hàng</label>
													<input type="text" name="name" class="form-control" id="edit-name" required>
												</div>
											</div>
											<div class="col-sm-6 mt-2">
												<div class="form-group">
													<label>Địa chỉ</label>
													<input type="text" name="diachi" class="form-control" id="edit-diachi" required>
												</div>
											</div>
											<div class="col-sm-6 mt-2">
												<div class="form-group">
													<label>Điện Thoại</label>
													<input type="text" name="dienthoai" class="form-control" id="edit-dienthoai" required>
												</div>
											</div>

											<div class="col-sm-6 mt-2">
												<div class="form-group">
													<label>Email</label>
													<input type="email" name="email" step="0.01" class="form-control" id="edit-email" required>
												</div>
											</div>

										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger light" data-dismiss="modal">Hủy</button>
											<button type="submit" name="edit_customer" class="btn btn-primary">Thay đổi</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>


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
						const customId = button.getAttribute('data-id');
						const customName = button.getAttribute('data-name');
						const customDiaChi = button.getAttribute('data-diachi');
						const customDienThoai = button.getAttribute('data-dienthoai');

						const customEmail = button.getAttribute('data-email');


						document.getElementById('edit-id').value = customId;
						document.getElementById('edit-name').value = customName;
						document.getElementById('edit-diachi').value = customDiaChi;
						document.getElementById('edit-dienthoai').value = customDienThoai;

						document.getElementById('edit-email').value = customEmail;

					});
				});
			</script>
			<!-- đoạn này xử lý refresh dữ liệu -->
			<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
			<script>
				
				$(document).ready(function() {
					$('#add_customer_btn').click(function(event) {
						event.preventDefault(); // Ngăn chặn submit form mặc định

						// Gửi dữ liệu form "thêm" bằng Ajax
						var formData = $('#add_customer_form').serialize();
						$.ajax({
							url: 'QLKH.php', // URL xử lý form "thêm"
							method: 'POST',
							data: formData,
							success: function(response) {
								// Xử lý khi thêm thành công
								if (response.success) {
									// Refresh dữ liệu trang QLKH.php
									refreshCustomerList(); // Hàm refresh dữ liệu
									// $('#add_customer_form')[0].reset(); // Xóa dữ liệu trong form "thêm"
									alert(response.message); // Hiển thị thông báo thành công
								} else {
									alert(response.error); // Hiển thị thông báo lỗi
								}
							},
							error: function(error) {
								console.error('Lỗi Ajax:', error);
								alert('Lỗi khi thêm khách hàng.');
							}
						});
					});
				});
				// Tạo hàm refreshCustomerList():
				function refreshCustomerList() {
					$.ajax({
						url: 'QLKH.php', // URL lấy danh sách khách hàng
						method: 'GET',
						success: function(response) {
							// Cập nhật nội dung HTML của bảng khách hàng
							$('#customer-list').html(response.data);
						},
						error: function(error) {
							console.error('Lỗi Ajax:', error);
							alert('Lỗi khi lấy danh sách khách hàng.');
						}
					});
				}
				// $(document).ready(function() {
				// 	refreshCustomerList(); // Gọi hàm refresh khi trang load
				// });
			</script> -->
</body>

</html>
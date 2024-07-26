<?php
require_once 'qlsp_controller.php';
$productController = new ProductController();

// Kiểm tra và xử lý thêm sản phẩm
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $result = $productController->handleAddProduct();
        if ($result) {
            $message = "Thêm sản phẩm thành công";
        } else {
            $error = "Thêm sản phẩm thất bại";
        }
    // } elseif (isset($_POST['edit_product'])) {
    //     $result = $productController->handleEditProduct();
    //     if ($result) {
    //         $message = "Chỉnh sửa sản phẩm thành công";
    //     } else {
    //         $error = "Chỉnh sửa sản phẩm thất bại";
    //     }
    }
    header('Location: index.php?page=quanlysanpham');
}

// Lấy danh sách sản phẩm
$products = $productController->displayProducts();
// Lấy danh sách loại sản phẩm
// $categories = $productController->layTatCaLoaiSanPham();
?>

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
        <input type="button" class="btn btn-success m-2 mx-2" data-toggle="modal" data-target=".themmoisanpham" value="Thêm mới">
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-responsive-md">
            <thead>
                <tr>
                    <th><strong>Tên sản phẩm</strong></th>
                    <th><strong>Loại sản phẩm</strong></th>
                    <th><strong>Hình ảnh</strong></th>
                    <th><strong>Đơn vị tính</strong></th>
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
                                <div class="d-flex align-items-center"><img src="<?php echo $product['HinhAnh']; ?>" class="rounded-lg mr-2" width="96" alt=""></div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center"></i> <?php echo $product['DonViTinh']; ?> </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center"></i> <?php echo number_format($product['DonGia'], 3, '.', ','); ?> </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <!-- <a href="#" data-toggle="modal" data-target=".suasanpham" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a> -->
                                    <button class="btn btn-primary btn-edit shadow btn-xs sharp mr-1" data-toggle="modal" data-target="#suasanpham" data-id="<?php echo $product['MaSP']; ?>" data-name="<?php echo htmlspecialchars($product['TenSP']); ?>" data-category="<?php echo $product['MaLSP']; ?>" data-unit="<?php echo $product['DonViTinh']; ?>" data-quantity="<?php echo $product['SoLuong']; ?>" data-price="<?php echo $product['DonGia']; ?>" data-image="<?php echo $product['HinhAnh']; ?>">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <a href="#" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
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

<!-- thêm sản phẩm model -->
<div class="modal fade themmoisanpham" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <div class="col-sm-6 mt-2">
                                <div class="form-group">
                                    <label>Chọn số lượng</label>
                                    <input type="number" name="quantity" class="form-control" placeholder="Số lượng" required>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="form-group">
                                    <label>Chọn đơn giá</label>
                                    <input type="number" name="price" step="0.01" class="form-control" placeholder="Đơn giá" required>
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
<!-- end thêm sản phẩm modal -->

<!-- thay đổi thông tin sản phẩm Modal -->
<div class="modal fade" id="suasanpham" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thay đổi thông tin sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="basic-form">
                    <form action="quanlysanpham.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="edit-id">
                        <input type="hidden" name="existing_image" id="edit-existing_image">
                        <div class="row">
                            <div class="col-sm-6 mt-2">
                                <div class="form-group">
                                    <label>Chọn tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control" id="edit-name" placeholder="Tên sản phẩm" required>
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
                            <div class="col-sm-6 mt-2">
                                <div class="form-group">
                                    <label>Chọn số lượng</label>
                                    <input type="number" name="quantity" class="form-control" id="edit-quantity" placeholder="Số lượng" required>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="form-group">
                                    <label>Chọn đơn giá</label>
                                    <input type="number" name="price" step="0.01" class="form-control" id="edit-price" placeholder="Đơn giá" required>
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

<script>
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', event => {
            const productId = button.getAttribute('data-id');
            const productName = button.getAttribute('data-name');
            const productCategory = button.getAttribute('data-category');
            const productUnit = button.getAttribute('data-unit');
            const productQuantity = button.getAttribute('data-quantity');
            const productPrice = button.getAttribute('data-price');
            const productImage = button.getAttribute('data-image');

            document.getElementById('edit-id').value = productId;
            document.getElementById('edit-name').value = productName;
            document.getElementById('edit-category').value = productCategory;
            document.getElementById('edit-unit').value = productUnit;
            document.getElementById('edit-quantity').value = productQuantity;
            document.getElementById('edit-price').value = productPrice;
            document.getElementById('edit-existing_image').value = productImage;
        });
    });
</script>
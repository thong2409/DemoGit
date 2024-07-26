<?php
require_once 'qlsp_model.php';

class ProductController
{
    private $model;

    public function __construct()
    {
        $this->model = new ProductModel();
    }

    public function displayProducts()
    {
        // Trả về danh sách sản phẩm từ model
        return $this->model->getAllProducts();
    }
    public function displayCategories()
    {
        return $this->model->getAllCategories();
    }
    public function handleAddproduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            echo $name;
            $category = $_POST['category'];
            $unit = $_POST['unit'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $image = $_FILES['image'];
            
            $imagePath = 'images/' . basename($image['name']);

            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                $this->model->insertProduct($name, $category, $unit, $price, $imagePath, $quantity);
                return true;
            }
        }
        return false;
    }
   
    public function handleEditProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $category = $_POST['category'];
            $unit = $_POST['unit'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $existingImage = $_POST['existing_image'];

            // Kiểm tra và tải lên hình ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = 'images/' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            } else {
                $imagePath = $existingImage;
            }

            // Cập nhật sản phẩm trong cơ sở dữ liệu
            $this->model->updateProduct($id, $name, $category, $unit, $price, $imagePath,$quantity  );
            return true;
        }
        return false;
    }
    public function handleDeleteProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
            $productid = $_POST['product_id'];
            return $this->model->deleteProduct($productid);
            
        }
        return false;
    }
}

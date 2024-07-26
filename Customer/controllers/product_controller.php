<?php 
    require_once __DIR__ . '/../models/product_model.php';
    class ProductController {
        private $model;
        public function __construct(){
            $db = new Database();
            $this->model = new ProductModel($db);
        }
        public function displayProducts($categoryId = null)
        {
        if ($categoryId) {
            return $this->model->getProductsByCategory($categoryId);
        } else {
            return $this->model->getProducts();
        }
        }
        public function detail($id) {
        //   return $this->model->getProductById($id);
        return $this->model->getProductById($id);
        }
        public function search($search){
            return $this->model->getProductBySearch($search);
        }
        
    }
?>
<?php
    require_once __DIR__. '/../models/loaisanpham_model.php';
    class LoaisanphamController {
        private $model;
        public function __construct(){
            $db = new Database();
            $this->model = new LoaisanphamModel($db);
        }
        public function index(){
            $categories = $this->model->getAllCategories();
            return $categories;
        }
    }
?>
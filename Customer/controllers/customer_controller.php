<?php 
    require_once __DIR__. '/../models/customer_model.php';

class CustomerController
{
    private $model;

    public function __construct()
    {
        $this->model = new CustomerModel();
    }
    public function handleAddCustomer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hoKH= $_POST['TenNV'];
            $DiaChi= $_POST['diaChi'];
            $DienThoai= $_POST['dienThoai'];
            $Email= $_POST['email'];
            $this->model->insertCustomer($hoKH, $DiaChi, $DienThoai, $Email);
            return true;
        }
        return false;
    }
}
?>
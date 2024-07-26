<?php
require_once 'qlkh_model.php';

class CustomerController
{
    private $model;

    public function __construct()
    {
        $this->model = new CustomerModel();
    }

    public function displayCustomers()
    {
        // Trả về danh sách sản phẩm từ model
        return $this->model->getAllCustomers();
    }
    public function handleAddcustomer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['TenKH'];
            $diachi = $_POST['DiaChi'];
            $sdt = $_POST['SDT'];
            $email = $_POST['Email'];
            $this->model->insertCustomer($name,$diachi, $sdt,$email);
            return true;
        }
        return false;
    }
    public function handleEditcustomer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_customer'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $diachi = $_POST['diachi'];
            $dienthoai = $_POST['dienthoai'];
            
            $email = $_POST['email'];
            


            // Cập nhật sản phẩm trong cơ sở dữ liệu
            $this->model->updateCustomer($id, $name, $diachi, $dienthoai, $email);
            return true;
        }
        return false;
    }
    public function handleDeleteCustom()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_customer'])) {
            $customerid = $_POST['customer_id'];
            return $this->model->deleteCustomer($customerid);
            
        }
        return false;
    }
}
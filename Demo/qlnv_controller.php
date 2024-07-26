<?php
require_once 'qlnv_model.php';

class StaffController
{
    private $model;

    public function __construct()
    {
        $this->model = new StaffModel();
    }

    public function displayStaffs()
    {
        // Trả về danh sách sản phẩm từ model
        return $this->model->getAllStaffs();
    }
    public function handleAddstaff()
    {
        
            $hoNV = $_POST['HoNV'];
            $tenNV= $_POST['TenNV'];
            $gioiTinh= $_POST['gioiTinh'];
            $ngaySinh= $_POST['ngaySinh'];
            $diaChi= $_POST['diaChi'];
            $dienThoai= $_POST['dienThoai'];
            $email= $_POST['email'];
            $matKhau=$_POST['password'];
            $this->model->insertStaff($hoNV,$tenNV, $gioiTinh,$ngaySinh,$diaChi, $dienThoai, $email, $matKhau);
            return true;
    }
    public function handleEditStaff()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_staff'])) {
            $id = $_POST['id'];
            $hname = $_POST['hname'];
            $tname = $_POST['tname'];
            $gioitinh = $_POST['gioitinh'];
            $diachi=   $_POST['diachi'];
            $dienthoai = $_POST['dienthoai'];
            $email = $_POST['email'];
            $matkhau=$_POST['matkhau'];

            // Cập nhật sản phẩm trong cơ sở dữ liệu
            $this->model->updateStaff($id, $hname, $tname, $gioitinh, $diachi, $dienthoai, $email, $matkhau);
            return true;
        }
        return false;
    }
    public function handleDeleteStaff()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_staff'])) {
            $staffid = $_POST['staff_id'];
            return $this->model->deleteStaff($staffid);
            
        }
        return false;
    }
}
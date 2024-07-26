<?php
require_once 'database.php';

class CustomerModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllCustomers()
    {
        $sql = "SELECT *
                FROM khachhang";
        // $sql = "SELECT * FROM sanpham";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function insertCustomer($tenKH, $diaChi, $sDT, $eMail)
    {
        $sql = "INSERT INTO khachhang(TenKH, DiaChi, DienThoai, Email)
        VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssis", $tenKH, $diaChi, $sDT, $eMail);
        return $stmt->execute();
    }
    public function updateCustomer($id, $name, $diachi, $sdt, $email)
    {
        $sql = "UPDATE khachhang SET TenKH = ?, DiaChi = ?, DienThoai = ?, Email = ? WHERE MaKH = ?";
        $stmt = $this->db->prepare($sql);
        // prepare ngăn lỗi
        $stmt->bind_param("ssisi", $name, $diachi, $sdt, $email, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteCustomer($customerid)
    {
        $sqlDetails="DELETE FROM hoadon   WHERE MaKH = ?";
        $stmtDetails= $this->db->prepare($sqlDetails);
        $stmtDetails->bind_param("i", $customerid);
        $stmtDetails->execute(); 
        // sau đó xóa khách hàng từ bảng khachhang
        $sqlCustom="DELETE FROM khachhang WHERE MaKH = ? ";
        $stmtCustom= $this->db->prepare($sqlCustom);
        $stmtCustom->bind_param("i", $customerid);
        return $stmtCustom->execute(); 
    }
}
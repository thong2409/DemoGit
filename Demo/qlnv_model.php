<?php
require_once 'database.php';

class StaffModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllStaffs()
    {
        $sql = "SELECT *
                FROM nhanvien";
        // $sql = "SELECT * FROM sanpham";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function insertStaff($hoNV, $tenNV, $gioiTinh, $ngaySinh,  $diaChi, $dienThoai, $email, $matKhau)
    {
        $sql = "INSERT INTO nhanvien(HoNhanVien, TenNhanVien, GioiTinh, NgaySinh,  DiaChi, DienThoai, Email, MatKhau)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssssiss", $hoNV, $tenNV, $gioiTinh, $ngaySinh,  $diaChi, $dienThoai, $email, $matKhau);
        return $stmt->execute();
    }
    public function updateStaff($id, $hname, $tname,$gioitinh, $diachi, $dienthoai, $email, $matKhau)
    {
        $sql = "UPDATE nhanvien SET HoNhanVien = ?, TenNhanVien = ?, GioiTinh = ?, DiaChi = ?, DienThoai = ?, Email= ?, MatKhau=?  WHERE MaNhanVien = ?";
        $stmt = $this->db->prepare($sql);
        // prepare ngăn lỗi
        $stmt->bind_param("ssssissi",  $hname, $tname,$gioitinh, $diachi, $dienthoai, $email, $matKhau,$id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteStaff($staffid)
    {
        $sqlDetails="DELETE FROM hoadon   WHERE MaNV = ?";
        $stmtDetails= $this->db->prepare($sqlDetails);
        $stmtDetails->bind_param("i", $staffid);
        $stmtDetails->execute(); 
        // sau đó xóa sản phẩm từ bảng nhanvien
        $sqlStaff="DELETE FROM nhanvien WHERE MaNhanVien = ? ";
        $stmtStaff= $this->db->prepare($sqlStaff);
        $stmtStaff->bind_param("i", $staffid);
        return $stmtStaff->execute(); 
    }
}
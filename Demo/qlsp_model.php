<?php
require_once 'database.php';

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllProducts()
    {
        $sql = "SELECT sanpham.*, loaisanpham.TenLSP FROM sanpham
                JOIN loaisanpham ON sanpham.MaLSP = loaisanpham.MaLSP";
        // $sql = "SELECT * FROM sanpham";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function insertProduct($tenSp, $maLSP, $donViTinh, $dongia, $imagePath, $soLuong) {
    $sql = "INSERT INTO sanpham(tenSp, maLSP, donViTinh, dongia, HinhAnh, SoLuong)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("sssisi", $tenSp, $maLSP, $donViTinh, $dongia, $imagePath, $soLuong);
    return $stmt->execute();
}
    
    public function updateProduct($id, $name, $category, $unit, $price, $imagePath,$soLuong)
    {
        $sql = "UPDATE sanpham SET TenSP = ?, MaLSP = ?, DonViTinh = ?, DonGia = ?, HinhAnh = ?, SoLuong = ? WHERE MaSP = ?";
        $stmt = $this->db->prepare($sql);
        // prepare ngăn lỗi
        $stmt->bind_param("sisdsii", $name, $category, $unit, $price, $imagePath,$soLuong, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllCategories()
    {
        $sql = "SELECT MaLSP, TenLSP FROM loaisanpham";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function deleteProduct($productid)
    {
        $sqlDetails="DELETE FROM chitiethoadon   WHERE MaSP = ?";
        $stmtDetails= $this->db->prepare($sqlDetails);
        $stmtDetails->bind_param("i", $productid);
        $stmtDetails->execute(); 
        // sau đó xóa sản phẩm từ bảng sanpham
        $sqlProduct="DELETE FROM sanpham WHERE MaSP = ? ";
        $stmtProduct= $this->db->prepare($sqlProduct);
        $stmtProduct->bind_param("i", $productid);
        return $stmtProduct->execute(); 
    }
}

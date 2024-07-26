<?php 
    require_once __DIR__ . '/../database.php';
class CustomerModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function insertCustomer($hoKH, $DiaChi, $DienThoai, $Email)
    {
        $sql = "INSERT INTO khachhang(TenKH, DiaChi, DienThoai, Email)
        VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssis", $hoKH, $DiaChi, $DienThoai, $Email);
        return $stmt->execute();
    }
}
?>
<?php 
    require_once __DIR__ . '/../database.php';
    class ProductModel 
    {
        private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getProducts()
    {
        $sql = "SELECT sanpham.*, loaisanpham.TenLSP FROM sanpham
                JOIN loaisanpham ON sanpham.MaLSP = loaisanpham.MaLSP";
        // $sql = "SELECT * FROM sanpham";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getProductsByCategory($categoryId)
    {
        $sql = "SELECT sanpham.*, loaisanpham.TenLSP FROM sanpham
                JOIN loaisanpham ON sanpham.MaLSP = loaisanpham.MaLSP
                WHERE sanpham.MaLSP = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM sanpham WHERE MaSP = ?");
        $stmt->execute([$id]);
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getProductBySearch($search){
        $stmt = $this->db->prepare("SELECT * FROM sanpham WHERE TenSP = ?");
        $stmt->execute([$search]);
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
?>
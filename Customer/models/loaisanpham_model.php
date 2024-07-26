<?php 
    require_once __DIR__ . '/../database.php';
    class LoaiSanPhamModel 
    {
        private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getAllCategories(){
        $sql = "SELECT * FROM loaisanpham";
        $result = $this->db->query($sql);
        $categories = [];
        if($result->num_rows >0){
            while ($row = $result->fetch_assoc()){
                $categories[] = $row;
            }
        }
        return $categories;
    }
    

    }
?>
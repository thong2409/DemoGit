<?php
$page= isset($_GET['page']) ? $_GET['page'] :'';
switch ($page){
    case 'sanpham':
        include 'product.php';
        break;
    case 'index':
        include 'index.php';
        break;
    // case 'quanlynhanvien':
    //     include 'QLNV.php';
    //     break;
    // case 'themsanpham':
    //     include 'AddProducts.php';
    //     break;
    // case '':
    //     break;       
    default:
        // echo "<h1>Trang không tồn tại</h1>";
        break;
    }
?>
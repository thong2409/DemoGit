<?php
$page= isset($_GET['page']) ? $_GET['page'] :'';
switch ($page){
    case 'quanlysanpham':
        include 'QLSP.php';
        break;
    case 'quanlykhachhang':
        include 'QLKH.php';
        break;
    case 'quanlynhanvien':
        include 'QLNV.php';
        break;
    case 'themsanpham':
        include 'AddProducts.php';
        break;
    case '':
        break;       
    default:
        echo "<h1>Trang không tồn tại</h1>";
        break;
    }
?>
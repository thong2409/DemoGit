<?php
require_once 'database.php';
session_start();
$db = new Database();
$taikhoan=isset($_POST['taikhoan'])?$_POST['taikhoan']:"";
$matkhau=isset($_POST['matkhau'])?$_POST['matkhau']:"";
if(!empty($taikhoan) && !empty($matkhau))
{
    $sql="SELECT HoNhanVien,TenNhanVien,Email,MatKhau,Author FROM nhanvien where Email=? and Matkhau=? ";
    $stmt=$db->prepare($sql);
    $stmt->bind_param("ss",$taikhoan,$matkhau);
    $stmt->execute();
    $result=$stmt->get_result();
    $user=$result->fetch_assoc();
    if($user)
    {
        $_SESSION['staffEmail']=$user['Email'];
        $_SESSION['staffPass']=$user['MatKhau'];
        $_SESSION['staffFirtsName']=$user['HoNhanVien'];
        $_SESSION['staffName']=$user['TenNhanVien'];
        $_SESSION['is_logged_in'] = true;
        $_SESSION['role'] = $user['Author'];
        header("Location: index.php");
        exit();
    }
    else
    {
        echo '<script> alert("tên đăng nhập hoặc mật khẩu không đúng "); window.location.href="login.php";</script>';
        exit();
    }
}
?>
 
<?php 
    require_once __DIR__ . '/../database.php';
    session_start();
    $db = new Database();
    $taikhoan=isset($_POST['taikhoan'])?$_POST['taikhoan']:"";
    $matkhau=isset($_POST['matkhau'])?$_POST['matkhau']:"";
    if(!empty($taikhoan) && !empty($matkhau))
    {
        $sql="SELECT TenKH,DiaChi,DienThoai,Email FROM khachhang where Email=? and DienThoai=? ";
        $stmt=$db->prepare($sql);
        $stmt->bind_param("si",$taikhoan,$matkhau);
        $stmt->execute();
        $result=$stmt->get_result();
        $user=$result->fetch_assoc();
        if($user)
        {
            $_SESSION['user_id'] = $user['Email'];
            $_SESSION['user_number'] = $user['DienThoai'];
            $_SESSION['user_name'] = $user['TenKH'];
            $_SESSION['user_address'] = $user['DiaChi'];
            header("Location: ../index.php");
            exit();
        }
        else
        {
            echo '<script> alert("tên đăng nhập hoặc mật khẩu không đúng "); window.location.href="../dangnhap.php";</script>';
            exit();
        }
    }   
?>
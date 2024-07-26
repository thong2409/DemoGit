<!doctype html>
<html lang="en">
  <head>
	<title>Title</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/dangky.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <?php 
    require_once 'database.php';
    require_once 'controllers/login_controller.php';
    require_once 'controllers/customer_controller.php';
    $customerController = new CustomerController();
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['add_customer'])){
            $result = $customerController->handleAddCustomer();
        }
        if ($result) {   
            echo '<div class="alert alert-success">Đăng ký thành công!</div>';
        } else {
            echo '<div class="alert alert-success">Đăng ký thất bại :(((</div>';
        }
    }

  ?>
  <body>
    <h5 class="mb-3"><a href="index.php" class="text-body"><i class="bi bi-arrow-bar-left"></i>Continue shopping</a></h5>
   <!-- Form đăng ký -->
	  <h2>Sign in/up Form</h2>
    <div class="container" id="container">
          <!-- Đăng ký -->
          
        <div class="form-container sign-up-container">
            <form action="#" method="post" enctype="multipart/form-data" id="signupForm">
                <!-- <h1>Create Account</h1>
                <span>or use your email for registration</span>
                <input type="text" name="TenNV" placeholder="HỌ VÀ TÊN" />
                <input type="text" name="diaChi" placeholder="ĐỊA CHỈ" />
                <input type="number" name="dienThoai" pattern="[0-9]*" inputmode="numeric" placeholder="Số điện thoại" required>
                <input type="email" name="email" placeholder="Email" />
                <button name="add_customer">Sign Up</button> -->
                <h1>Tạo tài khoản</h1>
                <input type="text" name="TenNV" id="TenNV" placeholder="HỌ VÀ TÊN" required />
                <span id="tenNVError" class="error-message text-danger"></span>

                <input type="text" name="diaChi" id="diaChi" placeholder="ĐỊA CHỈ" required />
                <span id="diaChiError" class="error-message text-danger"></span>

                <input type="number" name="dienThoai" id="dienThoai" pattern="[0-9]{10}" inputmode="numeric" placeholder="Số điện thoại (10 chữ số)" required />
                <span id="dienThoaiError" class="error-message text-danger"></span>

                <input type="email" name="email" id="email" placeholder="Email" required />
                <span id="emailError" class="error-message text-danger"></span>

                <button type="submit" name="add_customer">Đăng ký</button>
            </form>
        </div>

        <!-- Đăng nhập -->
        <div class="form-container sign-in-container">
            <form action="controllers/login_controller.php" method="POST">
                <h1>Sign in</h1>
                <span>or use your account</span>
                <input type="email" name="taikhoan"  placeholder="Email" />
                <p id="error-email"></p>
                <input type="number" name="matkhau"  pattern="[0-9]*" inputmode="numeric" placeholder="Số điện thoại" required>
                <p id="error-phone"></p>
                <a href="#">Forgot your password?</a>
                <button>Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');
        
        const signupForm = document.getElementById('signupForm');
        const tenNVInput = document.getElementById('TenNV');
        const diaChiInput = document.getElementById('diaChi');
        const dienThoaiInput = document.getElementById('dienThoai');
        const emailInput = document.getElementById('email');
        const tenNVError = document.getElementById('tenNVError');
        const diachiError =document.getElementById('diaChiError');
        const dienThoaiError = document.getElementById('dienThoaiError');
        const emailError = document.getElementById('emailError');
    signupForm.addEventListener('input', () => {
        //kiểm tra địa chỉ
        const diaChi = diaChiInput.value.trim();
        if (!diaChi) {
        diachiError.textContent = 'Địa chỉ không được để trống';
        }else {
        diachiError.textContent = ' ';
        }
      // Kiểm tra TênNV
      const tenNV = tenNVInput.value.trim();
      if (!tenNV) {
        tenNVError.textContent = 'Họ và tên không được để trống';
      } else {
        const tenNVWords = tenNV.split(' ');
        for (let word of tenNVWords) {
          word = word.charAt(0).toUpperCase() + word.slice(1);
          tenNVInput.value = tenNVWords.join(' ');
        }

        if (!/^[A-ZÀÁẠẢÃÄÈÉẸẺẼÊÌÍĨỊỈÒÓỌỎÕƠƯỨỮỤỦÝỲỴỸĂÂĐĐÈÉẸẺẼÊÌÍĨỊỈÒÓỌỎÕƠƯỨỮỤỦÝỲỴỸ]/.test(tenNV)) {
          tenNVError.textContent = 'Mỗi chữ cái đầu phải viết hoa';
        } else {
          tenNVError.textContent = '';
        }
      }

      // Kiểm tra số điện thoại
      const dienThoai = dienThoaiInput.value.trim();
      if (!dienThoai) {
        dienThoaiError.textContent = 'Số điện thoại không được để trống';
      } else if (!/^\d{10}$/.test(dienThoai)) {
        dienThoaiError.textContent = 'Số điện thoại không hợp lệ (10 chữ số)';
      } else {
        dienThoaiError.textContent = '';
      }

      // Kiểm tra email
      const email = emailInput.value.trim();
      if (!email) {
        emailError.textContent = 'Email không được để trống';
      } else if (!/^[\w-.]+@([\w-]+\.)+[a-zA-Z]{2,4}$/.test(email)) {
        emailError.textContent = 'Email không hợp lệ';
      } else {
        emailError.textContent = '';
      }
    });
        signUpButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });
        

        
    </script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
<?php

session_start();
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {

    // اگر ارجاع‌دهنده وجود نداشت (کاربر مستقیماً وارد شده است)
    session_unset(); // حذف تمام متغیرهای سشن
    session_destroy(); // پایان جلسه
    session_start(); // شروع مجدد جلسه
    header("Location: Ghalam_Login1.html"); // بازگشت به صفحه اول اگر اطلاعات ناقص باشد
    exit;
}

if (isset($_SESSION['is_login'])) {
    session_unset(); 
    session_destroy();
    header("Location: Ghalam_Login1.html"); // بازگشت به صفحه اول اگر اطلاعات ناقص باشد
    exit;
}
// اطلاعات اتصال به پایگاه داده
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ghalam";

// اتصال به پایگاه داده
$conn = new mysqli($servername, $username, $password, $dbname);

// بررسی اتصال
if ($conn->connect_error) {
    die("خطا در اتصال به پایگاه داده: " . $conn->connect_error);
}

// تعریف متغیرها
$errors = [];
$username = "";
$password = "";

// بررسی ارسال فرم
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت اطلاعات ورودی
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // اعتبارسنجی ورودی‌ها
    if (empty($username)) {
        $errors[] = "نام کاربری نمی‌تواند خالی باشد.";
    }
    if (empty($password)) {
        $errors[] = "رمز عبور نمی‌تواند خالی باشد.";
    }

    // اگر خطایی وجود نداشت
    if (empty($errors)) {
        // بررسی نام کاربری در دیتابیس
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $db_username, $db_password);
            $stmt->fetch();

            // بررسی رمز عبور
            if (password_verify($password, $db_password)) {
                // ورود موفقیت‌آمیز
                $_SESSION['user_id'] = $id; // ذخیره شناسه کاربر در سشن
                $_SESSION['is_login']=true;

                // هدایت به صفحه اصلی یا داشبورد
                header("Location: http://localhost/Ghalam/Home/Home.php");
                exit;
            } else {
                $errors[] = "رمز عبور اشتباه است.";
            }
        } else {
            $errors[] = "نام کاربری یافت نشد.";
        }

        $stmt->close();
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه ورود - قلم</title>
    <style>

        * {
	box-sizing: border-box;
	margin: 0;
	font-family: Samim, sans-serif;
	top: 0rem;
	position: relative;
	text-align: center;
        }

        body {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	min-height: 100vh;
	text-align: right;
	background: #ffffff;
	height: 64rem;
	position: relative;
        }

        .error-box {
            width: 430px;
            padding: 15px;
            margin-bottom: 20px;
            margin-top: 15px;
            background-color: #3f51b5; 
            border: 1px solidrgb(255, 255, 255); 
            border-radius: 16px;
            color:rgb(255, 255, 255); 
            font-size: 1rem;
            direction: rtl; 
            text-align: right; 
            box-shadow: 6px 4px 6px rgba(21, 20, 20, 0.1);
        }

        .error-box ul {
            padding-right: 15px;
            padding-left: 15px;
            text-align: right;
        }

        .error-box ul li {
            list-style-type: disc; 
        }

        .logo {
            font-size: 2.5rem;
            color: #3f51b5;
            font-weight: bold;
            margin-bottom: 20px;
        }

	.image-2 {
        position: absolute;
        top: -113.8px;
	    left: -51px;
        text-align: center;
        }
		
        .image-3 {
	position: absolute;
	top: -0.8rem;
	left: -2.5rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group input {
	width: 100%;
	padding: 10px;
	width: 433px;
	height: 3.6875rem;
	padding-right: 40px;
	border: 1px solid #FFFFFF;
	border-radius: 3.75rem;
	font-size: 1.1rem;
	outline: none;
	text-align: center;
	line-height: 0ex;
	text-indent: 27px;
	background-color: rgba(228,239,247,1.00);
        }

        .input-group .icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #465bb8;
            border-radius: 3.75rem;
            width: 27.0625rem;
            height: 3.6875rem;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #7986cb;
            border-radius: 3.75rem;
        }

        .links {
            margin-top: 15px;
            font-size: 0.9rem;
            color: rgba(70, 91, 184, 0.6);
            text-align: center;
            font-weight: 500
        }

        .links a {
            text-decoration: none;
            color: hwb(229 27% 28%);;
            font-weight: 700;
        }
        
        input {
            color: #465bb8;
            font-weight: 700;
            font-size: 20;
        }

        input::placeholder {
            color: #8da6e4;
            font-weight: 700;
        }

        .ForgeID{

            color: rgba(70, 91, 184, 0.6);
            text-align: center;
            font-size: Infinityrem;
            font-weight: 500;
        }

        .Line1{
            position: relative;
            top: -3px;
        }

        .Distance{
            text-decoration: underline;
            position: relative;
            bottom: 0px;
            padding-bottom: 15rem;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .illustration {
            margin-top: -9px;
        }

        .illustration img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

    <div class="Distance">
    </div>
	<div class="image-20">
		<img  class="image-2" src="image-20.png" alt="تصویر توضیحی">
	</div>	
    <div class="container">

    <form action="login.php" method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="نام کاربری خود را وارد کنید" value="<?php echo htmlspecialchars($username); ?>" id="username">
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="رمز ورود خود را وارد کنید" value="<?php echo htmlspecialchars($password); ?>" id="password">
                <span class="icon" onclick="togglePassword()"><img id="toggle-icon" class="image-3" src="show.png"></span>
            </div>
            <button type="submit" name="done" class="btn">ورود</button>
        </form>
        
        <div class="error-message">
            <?php
            // نمایش خطاها
            if (!empty($errors)) {
                echo '<div class="error-box">';
                echo '<ul>';
                foreach ($errors as $error) {
                    echo "<li>$error</li>";
                }
                echo '</ul>';
                echo '</div>';
            }
            ?>
        </div>

        <div class="links">
            <img class="Line1" src="Line 1.png" />
           <div> اکانتی ندارید؟ <a href="register1.php">ثبت نام</a></div>
        </div>
    </div>


    <div class="illustration">
        <img src="tiny-screenwriter-sitting-on-retro-typewriter-10.png" alt="تصویر توضیحی">
    </div>


    <script>
       function togglePassword() {
            const passwordField = document.getElementById('password'); // گرفتن فیلد رمز عبور
            const toggleIcon = document.getElementById('toggle-icon'); // گرفتن تصویر نمایش/مخفی

            // بررسی نوع فیلد رمز عبور
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // تغییر تصویر بر اساس حالت فیلد رمز عبور
            if (type === 'password') {
                toggleIcon.src = "show.png"; // حالت مخفی
            } else {
                toggleIcon.src = "hide.png"; // حالت نمایش
            }
        }
        function addFadeOutEffect(callbackUrl) {
        
        document.body.style.transition = "opacity 0.5s ease-out";
        document.body.style.opacity = "0";
        setTimeout(() => {
          window.location.href = callbackUrl;
        }, 800); 
      }

     
      document.addEventListener("DOMContentLoaded", () => {
       
        const loginButton = document.querySelector(".nav-link");
        loginButton.addEventListener("click", function (e) {
          e.preventDefault(); 
          addFadeOutEffect("register1.php");
        });
      });
        
    </script>
</body>
</html>
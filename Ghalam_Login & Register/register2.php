<?php
// شروع جلسه برای انتقال اطلاعات بین صفحات

session_start();
if (!isset($_SESSION['name']) || !isset($_SESSION['family'])) {
    header("Location: register1.php"); // بازگشت به صفحه اول اگر اطلاعات ناقص باشد
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
$email = isset($_SESSION['email']) ? $_SESSION['email'] : "";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
$password = isset($_SESSION['password']) ? $_SESSION['password'] : "";
$errors = [];

// بررسی ارسال فرم صفحه دوم
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
    // دریافت مقادیر ورودی
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // اعتبارسنجی ورودی‌ها
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "لطفاً یک ایمیل معتبر وارد کنید.";
    }
    if (empty($password) || strlen($password) < 8) {
        $errors[] = "رمز عبور باید حداقل 8 کاراکتر باشد.";
    }
    if (empty($username)) {
        $errors[] = "نام کاربری نمی‌تواند خالی باشد.";
    }else{
        // بررسی وجود نام کاربری در جدول users
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "نام کاربری قبلاً ثبت شده است.";
            $_SESSION['username'] = $username;
        }

        $stmt->close();
    }
    

    // اگر خطایی وجود نداشت، به صفحه بعد برو
    if (empty($errors)) {
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
    
        

        // هدایت به صفحه سوم
        header("Location: register3.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه ثبت نام - قلم</title>
    <style>

        * {
	box-sizing: border-box;
	margin: 0;
	font-family: Samim, sans-serif;
	top: 0px;
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
            background-color: #3f51b5; 
            border: 1px solidrgb(255, 255, 255); 
            border-radius: 16px;
            color:rgb(255, 255, 255); 
            font-size: 1rem;
            direction: rtl; /* راست‌چین کردن متن */
            text-align: right; /* چینش متن به سمت راست */
            box-shadow: 6px 4px 6px rgba(21, 20, 20, 0.1);
        }

        .error-box ul {
            padding-right: 15px;
            padding-left: 15px;
            text-align: right;
        }

        .error-box ul li {
            list-style-type: disc; /* دایره برای لیست */
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
	width: 13.3125rem;
	height: 3.6875rem;
	border: none;
	color: #fff;
	font-size: 1.5rem;
	font-weight: 700;
	cursor: pointer;
	position: relative;
	left: 13.7rem;
        }
        
        .btn:hover {
	background-color: #7986cb;
	border-radius: 3.75rem;
	position: relative;
	left: 13.7rem;
        }

        .btn2 {
	width: 100%;
	padding: 10px;
	background: #F79742;
	border-radius: 3.75rem;
	width: 13.3125rem;
	height: 3.6875rem;
	border: none;
	color: #fff;
	font-size: 1.5rem;
	font-weight: 700;
	cursor: pointer;
	position: relative;
	right: 13.7rem;
        }
        
        .btn2:hover {
	background-color: #f1ab6e;
	border-radius: 3.75rem;
	position: relative;
	right: 13.7rem;
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
            color: rgba(70, 91, 184, 1);
            font-size: 18px;
            font-weight: 500;
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
		
        .Line1{
            position: relative;
            top: -7px;
        }

        .Distance{
	text-decoration: underline;
	position: relative;
	bottom: 0px;
	padding-bottom: 19rem;
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
	position: relative;
	top: -4rem;
    z-index: -1;
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
    <form action="register2.php" method="POST">
    
        <div class="input-group">
            <input type="email" name="email" placeholder="آدرس ایمیل خود را وارد کنید" value= "<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="input-group">
            <input type="text" name="username" placeholder="نام کاربری دلخواه خود را انتخاب کنید" value= "<?php echo htmlspecialchars($username); ?>">
        </div>
        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="رمز ورود خود را وارد کنید" value= "<?php echo htmlspecialchars($password); ?>" >
            <span class="icon" onclick="togglePassword()"><img id="toggle-icon" class="image-3" src="show.png"></span>
        </div>
        <button type="submit" name="done" class="btn">مرحله بعد</button>
         <button class="btn2" type="button" onclick="window.location.href='register1.php'">مرحله قبل</button>

        
    </form>
   
    <div class="vector">
        <img class="vector-8" src="vector 8.png" />
        <img class="vector-10" src="vector 10.png" />
        <img class="vector-10" src="vector 10.png" />
        </div>
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
       <br>
       اکانت فعالی دارید؟ <a href="login.php?clear_sessions=true">ورود</a>
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
    </script>

    
</body>
</html>

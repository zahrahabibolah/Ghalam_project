<?php
session_start(); 

if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    
    session_unset(); 
    session_destroy(); 
    session_start(); 
} else {
    
    $referer = $_SERVER['HTTP_REFERER'];
    if (strpos($referer, 'Ghalam_Login1.html') !== false) {
        
        session_unset();
        session_destroy();
        session_start();
    }
}
if (isset($_GET['clear_sessions']) && $_GET['clear_sessions'] === 'true') {
    session_unset(); 
    session_destroy(); 
    session_start(); 
}
// مقداردهی اولیه متغیرها
$name = isset($_SESSION['name']) ? $_SESSION['name'] : "";
$family = isset($_SESSION['family']) ? $_SESSION['family'] : "";
$errors = [];

// بررسی ارسال فرم
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // گرفتن مقادیر فرم
    $name = trim($_POST['name']);
    $family = trim($_POST['family']);

    // اعتبارسنجی
    if (empty($name)) {
        $errors[] = "نام نمی‌تواند خالی باشد.";
    }
    if (empty($family)) {
        $errors[] = "نام خانوادگی نمی‌تواند خالی باشد.";
    }

   
    if (empty($errors)) {
        
        $_SESSION['name'] = $name;
        $_SESSION['family'] = $family;

    

        // انتقال به صفحه بعد
        header("Location: register2.php");
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
    
        <form action="register1.php" method="POST">
            <div class="input-group">
                <input type="text" name="name" placeholder="نام خود را وارد کنید" value="<?php echo htmlspecialchars($name); ?>">
            </div>
            <div class="input-group">
                <input type="text" name="family" placeholder="نام خانوادگی خود را وارد کنید" value="<?php echo htmlspecialchars($family); ?>">
            </div>
            <button type="submit" name="done" class="btn">مرحله بعد</button>
        </form>
        
       

        <div class="vector">
        <img class="vector-8" src="vector 8.png" />
        <img class="vector-9" src="vector 9.png" />
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
   
</body>

</html>

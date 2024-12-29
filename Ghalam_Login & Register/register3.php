<?php
// شروع جلسه برای دسترسی به اطلاعات صفحات قبلی
session_start();

if (isset($_SESSION['registered'])) {
    // پاک کردن سشن‌ها و بازگشت به صفحه ثبت نام
    session_unset();
    session_destroy();
    header("Location: register1.php");
    exit;
}
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    // اگر ارجاع‌دهنده وجود نداشت (کاربر مستقیماً وارد شده است)
    session_unset(); // حذف تمام متغیرهای سشن
    session_destroy(); // پایان جلسه
    session_start(); // شروع مجدد جلسه
    header("Location: register1.php"); // بازگشت به صفحه اول اگر اطلاعات ناقص باشد
    exit;
}


// تعریف متغیرها
$biography = isset($_POST['biography']) ? trim($_POST['biography']) : ""; // مقدار پیش‌فرض
$errors = [];

// بررسی ارسال فرم صفحه سوم
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['biography'])) {
    // دریافت اطلاعات ورودی
    $biography =$_POST['biography'];

    // اعتبارسنجی ورودی‌ها
    if (empty($biography)) {
        $errors[] = "بایوگرافی نمی‌تواند خالی باشد.";
    }

    // پردازش تصویر پروفایل
    
    if (isset($_FILES['profile_image'])&& $_FILES['profile_image']['error'] === 0) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileSize = $_FILES['profile_image']['size'];
        $fileType = $_FILES['profile_image']['type'];

        // تنظیم مسیر ذخیره‌سازی تصویر
        $uploadDir = 'C:/wamp64/www/Ghalam/uploads/image/';
        $uploadFilePath = $uploadDir . uniqid() . "_" . basename($fileName);

    } else {
        $errors[] = "لطفاً یک تصویر پروفایل انتخاب کنید.";
    }

    // اگر خطایی وجود نداشت
    if (empty($errors)) {
        // اتصال به پایگاه داده
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ghalam";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // بررسی اتصال
        if ($conn->connect_error) {
            die("خطا در اتصال به پایگاه داده: " . $conn->connect_error);
        }
        if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
        // هش کردن رمز عبور
        $hashed_password = password_hash($_SESSION['password'], PASSWORD_BCRYPT);

        $localPath = "C:/wamp64/www/Ghalam/uploads/image/_96669506-1c9b-4558-92c2-7b78a7fa26fb.jpg";

            // مسیر اصلی که در محلی داریم
        $localBasePath = "C:/wamp64/www";

            // آدرس URL مربوطه که می‌خواهید مسیر تبدیل شود
        $urlBasePath = "http://localhost";

            // تبدیل مسیر محلی به URL
        $image_path = str_replace($localBasePath, $urlBasePath, $uploadFilePath);
        // ذخیره در دیتابیس
        $sql = "INSERT INTO users (name, family, email, username, password, biography, profile_image)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssss",
            $_SESSION['name'],
            $_SESSION['family'],
            $_SESSION['email'],
            $_SESSION['username'],
            $hashed_password,
            $biography,
            $image_path
        );
      //  $stmt->send_long_data(6, file_get_contents($_FILES['profile_image']['tmp_name'])); 
        if ($stmt->execute()) {
            
            $sql_id = "SELECT id FROM users WHERE username = ?";
            $stmt_id = $conn->prepare($sql_id);
            $stmt_id->bind_param("s", $_SESSION['username']);
            $stmt_id->execute();
            $stmt_id->store_result();
            if ($stmt_id->num_rows > 0) {
                $stmt_id->bind_result($id);
                $stmt_id->fetch();
    
            $_SESSION['user_id'] = $id;
            $_SESSION['is_signup']==true; 
            $_SESSION['registered'] = true;
            // هدایت به صفحه ورود یا موفقیت
            header("Location: http://localhost/Ghalam/Home/Home.php");
            exit;
            

        }
            
            
        } else {
            $errors[] = "خطا در ذخیره اطلاعات: " . $stmt->error;
        }

        // بستن اتصال
        $stmt->close();
        $conn->close();
    }
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
	font-size:20px;
	
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
	top: -4.8rem;
	text-align: center;
	left: -54px;
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

                .profile-upload {
	width: 139px;
	height: 139px;
	margin: 10px auto;
	position: relative;
	overflow: hidden;
	cursor: pointer;
	display: flex;
	align-items: center;
	justify-content: center;
	text-align: center;
	background-color: rgba(228,239,247,1.00);
	border-radius: 60px;
        }

        input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-label {
            position: absolute;
            z-index: 1;
            color: #8da6e4;
            font-family: "SamimFd-Bold", sans-serif;
            font-size: 16px;
            font-weight: 700;
            pointer-events: none;
            text-align: center;
        }

        .label-text {
	text-align: center;
	line-height: 1.5;
	position: relative;
	top: 41px;
    font-weight: 500;
        }

        .profile-upload img {
            position: absolute;
            top: 0;
            left: 0;
            width: 139px;
	        height: 139px;
            object-fit: cover; 
            border-radius: 60px;
            display: none;
            z-index: 2; 
        }

        .profile2
        {
            font-weight: 700;

            
        }

        .btn {
	width: 100%;
	padding: 10px;
	background: #465bb8;
	border-radius: 3.75rem;
	width: 213px;
	height: 59px;
	border: none;
	color: #fff;
	font-size: 24px;
	font-weight: 700;
	cursor: pointer;
	position: relative;
	left: 218.7px;
        }
        
        .btn:hover {
	background-color: #7986cb;
	border-radius: 3.75rem;
	position: relative;
	left: 218.7px;
        }

        .btn2 {
	width: 100%;
	padding: 10px;
	background: #F79742;
	border-radius: 3.75rem;
	width: 213px;
	height: 59px;
	border: none;
	color: #fff;
	font-size: 24px;
	font-weight: 700;
	cursor: pointer;
	position: relative;
	right: 218.7px;
        }
        
        .btn2:hover {
	background-color: #f1ab6e;
	border-radius: 3.75rem;
	position: relative;
	right: 218.7px;
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
	color: #8DA6E4;
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
	padding-bottom: 3.2rem;
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
    <form action="register3.php" method="POST" enctype="multipart/form-data">
       
        <div class="profile-upload" id="profile-upload">
        <label for="file-input" class="upload-label">
                <span class="label-text">
                    انتخاب <br><div class="profile2">پروفایل</div>

                </span>
            </label>
            <input type="file" name="profile_image" accept="image/*" id="file-input">
            <img id="profile-pic" alt="پروفایل شما">

        </div>
        <div class="input-group">
            <input type="text" name="biography" placeholder="بایوگرافی خود را وارد کنید" value= "<?php echo htmlspecialchars($biography); ?>" >
        </div>
        <button type="submit" name="done" class="btn">ثبت نام</button>
        <button class="btn2" type="button" onclick="window.location.href='register2.php'">مرحله قبل</button>
    </form>
    <div class="vector">
        <img class="vector-10" src="vector 10.png" />
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
        const fileInput = document.getElementById('file-input');
        const profilePic = document.getElementById('profile-pic');
        const profileUpload = document.getElementById('profile-upload');
        const uploadLabel = document.querySelector('.upload-label');

        let isImageSelected = false; // فلگ برای بررسی انتخاب تصویر

        // زمانی که عکسی انتخاب شد
        fileInput.addEventListener('change', function () {
            const file = this.files[0]; // گرفتن فایل انتخاب شده
            if (file) {
                const reader = new FileReader(); // خواندن فایل
                reader.onload = function (event) {
                    profilePic.src = event.target.result; // نمایش عکس
                    profilePic.style.display = "block"; // نمایش تصویر
                    uploadLabel.style.display = "none"; // مخفی کردن متن "انتخاب عکس"
                    isImageSelected = true; // فعال کردن فلگ
                };
                reader.readAsDataURL(file); // خواندن فایل به‌صورت داده‌های URL
            }
        });

        // زمانی که روی عکس کلیک شد برای جایگزینی
        profileUpload.addEventListener('click', function (event) {
            // جلوگیری از اجرای کلیک اولیه پس از اولین انتخاب
            if (isImageSelected) {
                fileInput.value = ""; // پاک کردن مقدار قبلی input
                fileInput.click(); // باز کردن انتخابگر فایل
            }
        });
    </script>
</body>
</html>
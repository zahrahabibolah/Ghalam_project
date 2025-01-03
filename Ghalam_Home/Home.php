<?php
session_start(); // شروع جلسه

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

// بررسی وجود سشن
if (!isset($_SESSION['user_id'])) {
    die("لطفاً ابتدا وارد شوید.");
}else{
    $user_id = $_SESSION['user_id'];
    
}

// گرفتن ID کاربر از سشن

// دریافت اطلاعات کاربر از دیتابیس
$sql = "SELECT name, family, profile_image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name, $family, $profile_image);
$stmt->fetch();

// بررسی اینکه آیا کاربر پیدا شد
if (!$stmt->num_rows) {
    die("کاربر یافت نشد.");
}
// بستن اتصال به پایگاه داده
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه خانه - قلم</title>
    <style>
* {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      border: none;
      text-decoration: none;
      background: none;
      font-family: "SamimFd-Bold", sans-serif;
      -webkit-font-smoothing: antialiased;
      font-family: Samim, sans-serif;
   }
   

.desktop-16 * {
  box-sizing: border-box;
  font-family: Samim, sans-serif;
  text-align: left;
  direction: ltr;
  }
.desktop-16 {
  background: #ffffff;
  height: 81.0625rem;
  position: relative;
  overflow: hidden;
}
.frame-8 {
  width: 6.25rem;
  height: 5.625rem;
  position: absolute;
  left: 50%;
  translate: -50%;
  top: 3.125rem;
  overflow: hidden;
}
.image-2 {
  width: 6.25rem;
  height: 5.625rem;
  position: absolute;
  left: 0rem;
  top: 50%;
  translate: 0 -50%;
  object-fit: cover;
}
.group-1 {
  position: absolute;
  inset: 0;
}
.ellipse-4 {
  background: #183269;
  border-radius: 50%;
  width: 6.375rem;
  height: 6.375rem;
  position: absolute;
  left: 3.625rem;
  top: 2.375rem;
}
.rectangle-31 {
  background: #e4eff7;
  border-radius: 3.1875rem;
  min-width: 18.938rem;
  height: 6.375rem;
  position: absolute;
  left: 3.625rem;
  top: 2.375rem;
  box-shadow: inset 0rem 0rem 0.85625rem 0rem rgba(0, 0, 0, 0.15);
  display: flex;
  align-items: center;
  padding: 0 1rem;
  gap: 0.8rem;
  width: fit-content;
}
.mask-group {
	width: 5.935625rem;
	height: 5.935625rem;
	border-radius: 50%;
	object-fit: cover;
	margin-left: -13px;
  
}

.div {
	color: #465bb8;
	font-family: "SamimFd-Bold", sans-serif;
	font-size: 1.5rem;
	font-weight: 700;
	display: flex;
	align-items: center;
	white-space: nowrap;
	margin-left: 9px;
}

.group-9 {
  height: auto;
  position: absolute;
  left: 8.1875rem;
  top: 6.875rem;
  overflow: visible;
}
.menu-1 {
  width: 4.9375rem;
  height: 4.9375rem;
  position: absolute;
  left: 80.875rem;
  top: 3.125rem;
  overflow: visible;
}
.rectangle-5 {
  background: #e4eff7;
  border-radius: 3.1875rem;
  width: 38.875rem;
  height: 6.375rem;
  position: absolute;
  left: 25.5625rem;
  top: 10.75rem;
  box-shadow: inset 0rem 0rem 0.85625rem 0rem rgba(0, 0, 0, 0.15);
}
.group-43 {
  position: absolute;
  inset: 0;
}
.ellipse-3 {
  border-radius: 50%;
  border-style: solid;
  border-color: #f79742;
  border-width: 0.125rem;
  width: 5.75rem;
  height: 5.75rem;
  position: absolute;
  left: 58.3625rem;
  top: 11.0625rem;
}
.group-3 {
  width: 5.75rem;
  height: 5.75rem;
  position: static;
}
.ellipse-32 {
  border-radius: 50%;
  border-style: solid;
  border-color: #f79742;
  border-width: 0.125rem;
  width: 5.75rem;
  height: 5.75rem;
  position: absolute;
  left: 51.75rem;
  top: 11.0625rem;
}
.mask-group2 {
  width: 5.175rem;
  height: 5.175rem;
  position: absolute;
  left: 52.0375rem;
  top: 11.35rem;
  overflow: visible;
}
.group-4 {
  width: 5.75rem;
  height: 5.75rem;
  position: static;
}
.ellipse-33 {
  border-radius: 50%;
  border-style: solid;
  border-color: #f79742;
  border-width: 0.125rem;
  width: 5.75rem;
  height: 5.75rem;
  position: absolute;
  left: 45.1375rem;
  top: 11.0625rem;
}
.mask-group3 {
  width: 5.175rem;
  height: 5.175rem;
  position: absolute;
  left: 45.425rem;
  top: 11.35rem;
  overflow: visible;
}
.mask-group4 {
  width: 5.175rem;
  height: 5.175rem;
  position: absolute;
  left: 38.8125rem;
  top: 11.35rem;
  overflow: visible;
}
.mask-group5 {
  width: 5.175rem;
  height: 5.175rem;
  position: absolute;
  left: 32.4875rem;
  top: 11.35rem;
  overflow: visible;
}
.ellipse-34 {
  border-radius: 50%;
  border-style: solid;
  border-color: #f79742;
  border-width: 0.125rem;
  width: 5.75rem;
  height: 5.75rem;
  position: absolute;
  left: 38.525rem;
  top: 11.0625rem;
}
.ellipse-42 {
  border-radius: 50%;
  border-style: solid;
  border-color: #f79742;
  border-width: 0.125rem;
  width: 5.75rem;
  height: 5.75rem;
  position: absolute;
  left: 32.2rem;
  top: 11.0625rem;
}
.group-44 {
  width: 5.75rem;
  height: 5.75rem;
  position: static;
}
.mask-group6 {
  width: 5.175rem;
  height: 5.175rem;
  position: absolute;
  left: 26.1625rem;
  top: 11.35rem;
  overflow: visible;
}
.ellipse-5 {
  border-radius: 50%;
  border-style: solid;
  border-color: #f79742;
  border-width: 0.125rem;
  width: 5.75rem;
  height: 5.75rem;
  position: absolute;
  left: 25.875rem;
  top: 11.0625rem;
}
.mask-group7 {
  width: 5.175rem;
  height: 5.175rem;
  position: absolute;
  left: 58.65rem;
  top: 11.35rem;
  overflow: visible;
}
.group-48 {
  position: absolute;
  inset: 0;
}
.rectangle-6 {
  background: #e4eff7;
  border-radius: 1.6875rem;
  width: 81.75rem;
  height: 23.5625rem;
  position: absolute;
  left: 50%;
  translate: -50%;
  top: 22.4375rem;
  box-shadow: inset 0rem 0rem 0.85625rem 0rem rgba(0, 0, 0, 0.25);
}
.div2 {
  color: #142647;
  text-align: right;
  font-family: "SamimFd-Bold", sans-serif;
  font-size: 2rem;
  font-weight: 700;
  position: absolute;
  left: calc(50% - -21.8125rem);
  top: 18.5rem;
  width: 17.4375rem;
  height: 3.3125rem;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.frame-48 {
  width: 81.5625rem;
  height: 20.5rem;
  position: absolute;
  right: 4.25rem;
  top: 23.9375rem;
  overflow: hidden;
}
.group-45 {
  position: absolute;
  inset: 0;
}
.rectangle-8 {
  background: #fbfbfb;
  border-radius: 1.6875rem 0rem 1.6875rem 1.6875rem;
  width: 30.4375rem;
  height: 17.625rem;
  position: absolute;
  left: 49.25rem;
  top: 2.875rem;
  box-shadow: 0rem 0rem 0.625rem 0rem rgba(70, 91, 184, 0.7);
}
.div3 {
	color: #f79742;
	text-align: right;
	font-family: "SamimFd-Bold", sans-serif;
	font-size: 1.25rem;
	font-weight: 700;
	position: absolute;
	left: 65.063rem;
	top: 3.8rem;
	width: 8.188rem;
	display: flex;
	align-items: center;
	justify-content: flex-end;
}
.ellipse-35 {
  background: #ffffff;
  border-radius: 50%;
  width: 5.8125rem;
  height: 5.8125rem;
  position: absolute;
  left: 73.875rem;
  top: 0rem;
  box-shadow: 0rem 0rem 0.25rem 0rem rgba(70, 91, 184, 0.7);
}
.mask-group8 {
  width: 5.178125rem;
  height: 5.178125rem;
  position: absolute;
  left: 74.191875rem;
  top: 0.316875rem;
  overflow: visible;
}
.div4 {
  color: #142647;
  text-align: center;
  font-family: "SamimFd-Bold", sans-serif;
  font-size: 2.5rem;
  font-weight: 700;
  position: absolute;
  left: 72.5625rem;
  top: 6.3125rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
.rectangle-12 {
  background: #8fa0f8;
  border-radius: 0rem 0rem 1.6875rem 1.6875rem;
  width: 30.4375rem;
  height: 3.25rem;
  position: absolute;
  left: 49.25rem;
  top: 17.25rem;
}
.div5 {
  color: #ffffff;
  text-align: center;
  font-family: "SamimFd-Bold", sans-serif;
  font-size: 1.5rem;
  font-weight: 700;
  position: absolute;
  left: 56.375rem;
  top: 18rem;
  width: 16.1875rem;
  height: 1.875rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
.div6 {
  color: rgba(20, 38, 71, 0.6);
  text-align: right;
  font-family: "SamimFd-Medium", sans-serif;
  font-size: 1.25rem;
  font-weight: 500;
  position: absolute;
  left: 59.875rem;
  top: 11.25rem;
  width: 17.9375rem;
  height: 1.375rem;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.div7 {
  color: rgba(70, 91, 184, 0.7);
  text-align: right;
  font-family: "SamimFd-Regular", sans-serif;
  font-size: 1.25rem;
  font-weight: 400;
  position: absolute;
  left: 69.75rem;
  top: 13.625rem;
  width: 8.0625rem;
  height: 1.375rem;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.group-46 {
  position: absolute;
  inset: 0;
}
.rectangle-82 {
  background: #fbfbfb;
  border-radius: 1.6875rem 0rem 1.6875rem 1.6875rem;
  width: 30.4375rem;
  height: 17.625rem;
  position: absolute;
  left: 17.3125rem;
  top: 2.875rem;
  box-shadow: 0rem 0rem 0.625rem 0rem rgba(70, 91, 184, 0.7);
}
.div8 {
  color: #f79742;
  text-align: right;
  font-family: "SamimFd-Bold", sans-serif;
  font-size: 1.25rem;
  font-weight: 700;
  position: absolute;
  left: 33.0625rem;
  top: 3.5rem;
  width: 8.25rem;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.ellipse-36 {
  background: #ffffff;
  border-radius: 50%;
  width: 5.8125rem;
  height: 5.8125rem;
  position: absolute;
  left: 41.9375rem;
  top: 0rem;
  box-shadow: 0rem 0rem 0.25rem 0rem rgba(70, 91, 184, 0.7);
}
.mask-group9 {
  width: 5.178125rem;
  height: 5.178125rem;
  position: absolute;
  left: 42.254375rem;
  top: 0.316875rem;
  overflow: visible;
}
.div9 {
  color: #142647;
  text-align: center;
  font-family: "SamimFd-Bold", sans-serif;
  font-size: 2.5rem;
  font-weight: 700;
  position: absolute;
  left: 35.9375rem;
  top: 6.3125rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
.rectangle-122 {
  background: #8fa0f8;
  border-radius: 0rem 0rem 1.6875rem 1.6875rem;
  width: 30.4375rem;
  height: 3.25rem;
  position: absolute;
  left: 17.3125rem;
  top: 17.25rem;
}
.div10 {
  color: #ffffff;
  text-align: center;
  font-family: "SamimFd-Bold", sans-serif;
  font-size: 1.5rem;
  font-weight: 700;
  position: absolute;
  left: 24.4375rem;
  top: 18rem;
  width: 16.1875rem;
  height: 1.875rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
.div11 {
  color: rgba(70, 91, 184, 0.7);
  text-align: right;
  font-family: "SamimFd-Regular", sans-serif;
  font-size: 1.25rem;
  font-weight: 400;
  position: absolute;
  left: 37.8125rem;
  top: 11.25rem;
  width: 8.0625rem;
  height: 1.375rem;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.group-47 {
  position: absolute;
  inset: 0;
}
.rectangle-83 {
  background: #fbfbfb;
  border-radius: 1.6875rem 0rem 1.6875rem 1.6875rem;
  width: 30.4375rem;
  height: 17.625rem;
  position: absolute;
  left: -14.625rem;
  top: 2.875rem;
  box-shadow: 0rem 0rem 0.625rem 0rem rgba(70, 91, 184, 0.7);
}
.div12 {
  color: #f79742;
  text-align: right;
  font-family: "SamimFd-Bold", sans-serif;
  font-size: 1.25rem;
  font-weight: 700;
  position: absolute;
  left: 3.1875rem;
  top: 3.5rem;
  width: 6.1875rem;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.ellipse-37 {
  background: #ffffff;
  border-radius: 50%;
  width: 5.8125rem;
  height: 5.8125rem;
  position: absolute;
  left: 10rem;
  top: 0rem;
  box-shadow: 0rem 0rem 0.25rem 0rem rgba(70, 91, 184, 0.7);
}
.mask-group10 {
  width: 5.178125rem;
  height: 5.178125rem;
  position: absolute;
  left: 10.316875rem;
  top: 0.316875rem;
  overflow: visible;
}
.div13 {
	color: #142647;
	text-align: center;
	font-family: "SamimFd-Bold", sans-serif;
	font-size: 2.5rem;
	font-weight: 700;
	position: absolute;
	left: 8.813rem;
	top: 6.3125rem;
	display: flex;
	align-items: center;
	justify-content: center;
}
.rectangle-123 {
  background: #8fa0f8;
  border-radius: 0rem 0rem 1.6875rem 1.6875rem;
  width: 30.4375rem;
  height: 3.25rem;
  position: absolute;
  left: -14.625rem;
  top: 17.25rem;
}
.div14 {
  color: #ffffff;
  text-align: center;
  font-family: "SamimFd-Bold", sans-serif;
  font-size: 1.5rem;
  font-weight: 700;
  position: absolute;
  left: -7.5rem;
  top: 18rem;
  width: 16.1875rem;
  height: 1.875rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
.div15 {
  color: rgba(20, 38, 71, 0.6);
  text-align: right;
  font-family: "SamimFd-Medium", sans-serif;
  font-size: 1.25rem;
  font-weight: 500;
  position: absolute;
  left: -4rem;
  top: 11.25rem;
  width: 17.9375rem;
  height: 1.375rem;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.div16 {
  color: rgba(70, 91, 184, 0.7);
  text-align: right;
  font-family: "SamimFd-Regular", sans-serif;
  font-size: 1.25rem;
  font-weight: 400;
  position: absolute;
  left: 5.875rem;
  top: 13.625rem;
  width: 8.0625rem;
  height: 1.375rem;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.div17 {
  color: #cd772c;
  text-align: center;
  font-family: "SamimFd-Medium", sans-serif;
  font-size: 1.25rem;
  font-weight: 500;
  text-decoration: underline;
  position: absolute;
  left: 5.375rem;
  top: 19.1875rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
.group-49 {
  position: absolute;
  inset: 0;
}
.rectangle-62 {
  background: #e4eff7;
  border-radius: 1.6875rem;
  width: 81.75rem;
  height: 23.5625rem;
  position: absolute;
  left: 50%;
  translate: -50%;
  top: 51.8125rem;
  box-shadow: inset 0rem 0rem 0.85625rem 0rem rgba(0, 0, 0, 0.25);
}
.div18 {
  color: #142647;
  text-align: right;
  font-family: "SamimFd-Bold", sans-serif;
  font-size: 2rem;
  font-weight: 700;
  position: absolute;
  left: calc(50% - -21.8125rem);
  top: 47.875rem;
  width: 17.4375rem;
  height: 3.3125rem;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.frame-482 {
  width: 81.5625rem;
  height: 20.5rem;
  position: absolute;
  right: 4.25rem;
  top: 53.3125rem;
  overflow: hidden;
}
.mask-group11 {
  width: 5.178125rem;
  height: 5.178125rem;
  position: absolute;
  left: 74.191875rem;
  top: 0.316875rem;
  overflow: visible;
}
.mask-group12 {
  width: 5.178125rem;
  height: 5.178125rem;
  position: absolute;
  left: 42.254375rem;
  top: 0.316875rem;
  overflow: visible;
}
.mask-group13 {
  width: 5.178125rem;
  height: 5.178125rem;
  position: absolute;
  left: 10.316875rem;
  top: 0.316875rem;
  overflow: visible;
}
.div19 {
  color: #cd772c;
  text-align: center;
  font-family: "SamimFd-Medium", sans-serif;
  font-size: 1.25rem;
  font-weight: 500;
  text-decoration: underline;
  position: absolute;
  left: 5.375rem;
  top: 48.5625rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

   menu, ol, ul {
       list-style-type: none;
       margin: 0;
       padding: 0;
   }
    </style>
  <title>Document</title>
</head>
<body>
  
    
    <img class="mask-group7" src="mask-group6.svg" />
    <div class="rectangle-6"></div>
    <div class="div2">آخرین داستان ها</div>
    <div class="frame-48">
      <div class="rectangle-8"></div>
      <div class="div3">الناز دادخواه</div>
      <div class="ellipse-35"></div>
      <img class="mask-group8" src="mask-group7.svg" />
      <div class="div4">اوهام</div>
      <div class="rectangle-12"></div>
      <div class="div5">مشاهده</div>
      <div class="div6">فصل اول - قسمت اول ( آغاز )</div>
      <div class="div7">#فانتزی #درام</div>
      <div class="rectangle-82"></div>
      <div class="div8">صادق واحدی</div>
      <div class="ellipse-36"></div>
      <img class="mask-group9" src="mask-group8.svg" />
      <div class="div9">وسط شهر</div>
      <div class="rectangle-122"></div>
      <div class="div10">مشاهده</div>
      <div class="div11">#دلنوشت</div>
      <div class="rectangle-83"></div>
      <div class="div12">یاسین ذاکر</div>
      <div class="ellipse-37"></div>
      <img class="mask-group10" src="mask-group9.svg" />
      <div class="div13">سلامپ</div>
      <div class="rectangle-123"></div>
      <div class="div14">مشاهده</div>
      <div class="div15">قسمت آخر (دختری؟)</div>
      <div class="div16">#فانتزی #درام</div>
    </div>
    <div class="div17">دیدن همه</div>
    <div class="rectangle-62"></div>
    <div class="div18">آخرین شعر ها</div>
    <div class="frame-482">
      <div class="rectangle-8"></div>
      <div class="div3">الناز دادخواه</div>
      <div class="ellipse-35"></div>
      <img class="mask-group11" src="mask-group10.svg" />
      <div class="div4">اوهام</div>
      <div class="rectangle-12"></div>
      <div class="div5">مشاهده</div>
      <div class="div6">فصل اول - قسمت اول ( آغاز )</div>
      <div class="div7">#فانتزی #درام</div>
      <div class="rectangle-82"></div>
      <div class="div8">صادق واحدی</div>
      <div class="ellipse-36"></div>
      <img class="mask-group12" src="mask-group11.svg" />
      <div class="div9">وسط شهر</div>
      <div class="rectangle-122"></div>
      <div class="div10">مشاهده</div>
      <div class="div11">#دلنوشت</div>
      <div class="rectangle-83"></div>
      <div class="div12">یاسین ذاکر</div>
      <div class="ellipse-37"></div>
      <img class="mask-group13" src="mask-group12.svg" />
      <div class="div13">سلامپ</div>
      <div class="rectangle-123"></div>
      <div class="div14">مشاهده</div>
      <div class="div15">قسمت آخر (دختری؟)</div>
      <div class="div16">#فانتزی #درام</div>
    </div>
    <div class="div19">دیدن همه</div>
  </div>

    <div class="frame-8">
      <img class="image-2" src="image-20.png" />
    </div>
    <div class="ellipse-4"></div>

  <div class="rectangle-31">
      <img class="mask-group" src="<?=$profile_image?>"  alt="پروفایل کاربر" />
      <div class="div">
        <?php echo htmlspecialchars($name . " " . $family); ?>
      </div>
    </div>
    <img class="group-9" src="group-90.svg" />

    <img class="menu-1" src="menu-10.svg" />
    <div class="rectangle-5"></div>
    <div class="ellipse-3"></div>
    <div class="group-3">
      <div class="ellipse-32"></div>
      <img class="mask-group2" src="mask-group1.svg" />
    </div>
    <div class="group-4">
      <div class="ellipse-33"></div>
      <img class="mask-group3" src="mask-group2.svg" />
    </div>
    <img class="mask-group4" src="mask-group3.svg" />
    <img class="mask-group5" src="mask-group4.svg" />
    <div class="ellipse-34"></div>
    <div class="ellipse-42"></div>
    <div class="group-44">
      <img class="mask-group6" src="mask-group5.svg" />
      <div class="ellipse-5"></div>
    </div>
    <img class="mask-group7" src="mask-group6.svg" />
    <div class="rectangle-6"></div>
    <div class="div2">آخرین داستان ها</div>
    <div class="frame-48">
      <div class="rectangle-8"></div>
      <div class="div3">الناز دادخواه&nbsp;</div>
      <div class="ellipse-35"></div>
      <img class="mask-group8" src="mask-group7.svg" />
      <div class="div4">اوهام</div>
      <div class="rectangle-12"></div>
      <div class="div5">مشاهده</div>
      <div class="div6">فصل اول - قسمت اول ( آغاز )</div>
      <div class="div7">فانتزی #درام#</div>
      <div class="rectangle-82"></div>
      <div class="div8">صادق واحدی</div>
      <div class="ellipse-36"></div>
      <img class="mask-group9" src="mask-group8.svg" />
      <div class="div9">وسط شهر</div>
      <div class="rectangle-122"></div>
      <div class="div10">مشاهده</div>
      <div class="div11">دلنوشت#</div>
      <div class="rectangle-83"></div>
      <div class="div12">یاسین ذاکر</div>
      <div class="ellipse-37"></div>
      <img class="mask-group10" src="mask-group9.svg" />
      <div class="div13">سلام</div>
      <div class="rectangle-123"></div>
      <div class="div14">مشاهده</div>
      <div class="div15">قسمت آخر (دختری؟)</div>
      <div class="div16">فانتزی #درام#</div>
    </div>
    <div class="div17">دیدن همه</div>
    <div class="rectangle-62"></div>
    <div class="div18">آخرین شعر ها</div>
    <div class="frame-482">
      <div class="rectangle-8"></div>
      <div class="div3">الناز دادخواه</div>
      <div class="ellipse-35"></div>
      <img class="mask-group11" src="mask-group10.svg" />
      <div class="div4">اوهام</div>
      <div class="rectangle-12"></div>
      <div class="div5">مشاهده</div>
      <div class="div6">فصل اول - قسمت اول ( آغاز )</div>
      <div class="div7">فانتزی #درام#</div>
      <div class="rectangle-82"></div>
      <div class="div8">صادق واحدی</div>
      <div class="ellipse-36"></div>
      <img class="mask-group12" src="mask-group11.svg" />
      <div class="div9">وسط شهر</div>
      <div class="rectangle-122"></div>
      <div class="div10">مشاهده</div>
      <div class="div11">دلنوشت#</div>
      <div class="rectangle-83"></div>
      <div class="div12">یاسین ذاکر</div>
      <div class="ellipse-37"></div>
      <img class="mask-group13" src="mask-group12.svg" />
      <div class="div13">سلام</div>
      <div class="rectangle-123"></div>
      <div class="div14">مشاهده</div>
      <div class="div15">قسمت آخر (دختری؟)</div>
      <div class="div16">فانتزی #درام#</div>
    </div>
    <div class="div19">دیدن همه</div>
  </div>
  
</body>
</html>
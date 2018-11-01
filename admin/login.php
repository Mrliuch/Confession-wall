<?php 
    session_start();

    // 账号密码验证标记，0为正确，1为错误
    $isWrong = 0;
    if (isset($_POST['username']) && isset($_POST['password'])) {
        # 检测到提交的内容

        // 获取提交的账号和密码
        $username = test_input($_POST['username']);
        $password = test_input($_POST['password']);
        // 指定的正确的账号和密码
        $true_username = "root";
        $true_password = "1122";

        // 比较
        if ($username == $true_username && $password == $true_password) {
            # 账号密码匹配
            $_SESSION['login'] = 1;
            # 使用脚本重定向回到登录界面
            $url="index.php";
            echo "<script language=\"javascript\">";
            echo "location.href=\"$url\"";
            echo "</script>";
            exit();
        } else {
            # 账号密码不匹配
            $_SESSION['login'] = 0;
            $isWrong = 1;
        }
    }

    // 对提交的数据进行处理和过滤
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>表白墙后台管理</title>
</head>
<body>
    <h1>表白墙后台管理</h1>
    <form action="?" method="POST">
        <div>
            <span>账号；</span>
            <input type="text" name="username" value="">
        </div>
        <div>
            <span>密码：</span>
            <input type="password" name="password" value="">
        </div>
       <input type="submit" name="submit" value="登录">
       <p style="color:red;">
        <?php 
            if ($isWrong == 1) {
               echo "账号密码错误！";
            }
        ?>
       </p>
    </form>
</body>
</html>

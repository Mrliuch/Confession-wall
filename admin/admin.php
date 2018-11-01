<?php
    session_start();
    if (isset($_SESSION['login']) && $_SESSION['login'] > 0) {
        # 如果存在登录记录则进入后台。注意：因为Cookie被微信禁用，导致$_SESSION，所以用微信登录是无法打开后台的。
        
    }else {
        # 使用脚本重定向回到登录界面
        $url="login.php";
        echo "<script language=\"javascript\">";
        echo "location.href=\"$url\"";
        echo "</script>";
        exit();
    }
    // 引入数据库连接类
    include_once "../php/connect.php";
    // 实例化数据库连接
    $connectDBS = new connectDataBase();

    if (isset($_POST['act'])) {
        # 请求是否包括act参数
        $act = $connectDBS->test_input($_POST['act']);
        switch ($act) {
            case 'getPosts':
                # 获取表白

                break;
            case 'deletePosts':
                # 删除某条表白
                $id = $connectDBS->test_input($_POST['id']);
                $sql = "DELETE FROM `saylove_2017_posts` WHERE `id` = $id";
                echo mysqli_query($connectDBS->link, $sql);
                break;
            case 'getComment':
                # 获取某条表白的评论

                break;
            case 'deleteComment':
                # 删除某条评论
                $id = $connectDBS->test_input($_POST['id']);
                $sql = "DELETE FROM `saylove_2017_commtents` WHERE `id` = $id";
                echo mysqli_query($connectDBS->link, $sql);
                break;
            case 'editNickName':
                # 修改昵称
                $id = $connectDBS->test_input($_POST['id']);
                $target = $connectDBS->test_input($_POST['target']);
                $sql = "UPDATE `saylove_2017_posts` SET `nickName` = '$target' WHERE `id` = $id";
                echo mysqli_query($connectDBS->link, $sql);
                break;
            case 'editTureName':
                # 修改真名
                $id = $connectDBS->test_input($_POST['id']);
                $target = $connectDBS->test_input($_POST['target']);
                $sql = "UPDATE `saylove_2017_posts` SET `tureName` = '$target' WHERE `id` = $id";
                echo mysqli_query($connectDBS->link, $sql);
                break;
            case 'editGender':
                # 修改性别
                $id = $connectDBS->test_input($_POST['id']);
                $target = $connectDBS->test_input($_POST['target']);
                if ($target == "男") {
                    $target = 'male';
                } else {
                    $target = 'female';
                }
                $sql = "UPDATE `saylove_2017_posts` SET `gender` = '$target' WHERE `id` = $id";
                echo mysqli_query($connectDBS->link, $sql);
                break;
            case 'editToWho':
                # 修改对象名字
                $id = $connectDBS->test_input($_POST['id']);
                $target = $connectDBS->test_input($_POST['target']);
                $sql = "UPDATE `saylove_2017_posts` SET `toWho` = '$target' WHERE `id` = $id";
                echo mysqli_query($connectDBS->link, $sql);
                break;
            case 'editItsGender':
                # 修改对象性别
                $id = $connectDBS->test_input($_POST['id']);
                $target = $connectDBS->test_input($_POST['target']);
                if ($target == "男") {
                    $target = 'male';
                } else {
                    $target = 'female';
                }
                $sql = "UPDATE `saylove_2017_posts` SET `itsGender` = '$target' WHERE `id` = $id";
                echo mysqli_query($connectDBS->link, $sql);
                break;
            case 'editLikes':
                # 修改点赞数
                $id = $connectDBS->test_input($_POST['id']);
                $targetNum = $connectDBS->test_input($_POST['targetNum']);
                $sql = "UPDATE `saylove_2017_posts` SET `love` = $targetNum WHERE `id` = $id";
                echo mysqli_query($connectDBS->link, $sql);
                break;
            case 'editEmail':
                # 修改邮箱
                $id = $connectDBS->test_input($_POST['id']);
                $target = $connectDBS->test_input($_POST['target']);
                $sql = "UPDATE `saylove_2017_posts` SET `email` = '$target' WHERE `id` = $id";
                echo mysqli_query($connectDBS->link, $sql);
                break;
            case 'getGuessHistory':
                # 获取某条表白的猜名字历史记录
                $id = $connectDBS->test_input($_POST['id']);
                $sql = "SELECT * FROM `saylove_2017_guess` WHERE `posts_id` = $id";
                // 遍历输出结果

                break;
            case 'editContent':
                # 修改表白内容
                $id = $connectDBS->test_input($_POST['id']);
                $contents = $connectDBS->test_input($_POST['target']);
                $sql = "UPDATE `saylove_2017_posts` SET `contents` = '$contents' WHERE `id` = $id";
                echo mysqli_query($connectDBS->link, $sql);
                break;
            case 'resendEmail':
                # 重新发送邮件
                include_once '../php/email.php';
                $send = new sendEmail();
                $id = $connectDBS->test_input($_POST['id']);
                $email = $connectDBS->test_input($_POST['email']);
                $send->sendOut($connectDBS->link, $id, $email);

                break;
            default:
                # code...
                break;
        }
    }else if(isset($_GET['page'])){
        // 根据页码和限制获取数据
        $maxItems = 30;
        $page = 1;
        if (isset($_GET['page'])) {
            # 页数
            $page = $connectDBS->test_input($_GET['page']);
        }
        if (isset($_GET['limit'])) {
            # 需要的表白个数
            $maxItems = $connectDBS->test_input($_GET['limit']);
        }
        // 获取总数据
        //获取数据总数
        $total_sql = "SELECT COUNT(*) FROM `saylove_2017_posts` where isDisplay = '0'";
        $total_result = mysqli_fetch_array(mysqli_query($connectDBS->link,$total_sql));
        $total = $total_result[0];

        $page_later = ($page-1)*$maxItems;
        // 按照时间倒序排序
        $mysql = "SELECT * FROM `saylove_2017_posts` WHERE `isDisplay` = '0' ORDER BY `mtime` DESC LIMIT {$page_later},{$maxItems}";
        $arr_address = mysqli_query($connectDBS->link, $mysql);
        // 组装前端所需要的json格式
        $posts = array('code' => 0, 'msg'=> '', 'count'=> $total);
        while ($row = mysqli_fetch_assoc($arr_address)){
            $subArr = array();
            $subArr['id'] = $row['id'];
            $subArr['nickName'] = $row['nickName'];
            $subArr['tureName'] = $row['tureName'];
            $subArr['toWho'] = $row['toWho'];
            $subArr['email'] = $row['email'];
            $subArr['contents'] = $row['contents'];
            $subArr['love'] = $row['love'];
            $subArr['mtime'] = $row['mtime'];
            if ($row['gender'] == "male") {
                $subArr['gender'] = "男";
            } else {
                $subArr['gender'] = "女";
            }
            if ($row['itsGender'] == "male") {
                $subArr['itsGender'] = "男";
            } else {
                $subArr['itsGender'] = "女";
            }
            if ($row['isDisplay'] == 0) {
                $subArr['isDisplay'] = "显示";
            } else {
                $subArr['isDisplay'] = "隐藏";
            }
            if ($row['isSended'] == 0) {
                $subArr['isSended'] = "未发送";
            } else if($row['isSended'] == 1) {
                $subArr['isSended'] = "发送成功";
            }else{
                $subArr['isSended'] = "发送失败";
            }
            $subArr['ip'] = $row['ip'];
            $posts['data'][] = $subArr;
        }
        echo json_encode($posts);
    }else {
        echo "wrong";
    }
<?php
  /**
   *
   */
  class sendEmail
  {

    function __construct()
    {

    }

    public function sendOut($linkDatabaese, $uid, $email)
    {
      require 'PHPMailer/PHPMailerAutoload.php';
      $mail = new PHPMailer;
      //$mail->SMTPDebug = 3;                               // Enable verbose debug output
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.qq.com;';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;
      $mail->CharSet = "utf-8";                               // Enable SMTP authentication
      $mail->Username = '609046248@qq.com';                 // SMTP username
      $mail->Password = 'xefbcvddtlizbehi';                           // SMTP password 这里需要QQ邮箱开启独立密码并填写到这里
      $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, tls `ssl` also accepted
      $mail->Port = 465;                                    // TCP port to connect to
      $link = "http://qq597914752.gotoip1.com/app/saylove/share.php?id={$uid}";

      $mail->setFrom('QQ账号@qq.com', '吉林农业大学易班表白墙');// 填写发送人的邮箱，和主题标题
      $mail->addAddress("{$email}");               // Name is optional 对方的邮件地址
      $mail->addReplyTo('QQ账号@qq.com', '吉林农业大学易班表白墙'); // 填写回复的邮箱，和主题标题

      //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
      $mail->isHTML(true);                                  // Set email format to HTML

      $mail->Subject = '你被表白啦！来自吉林农业大学易班表白墙';// 邮件的标题
      $mail->Body    = '你被表白啦！点击<a href="'.$link.'">这里</a>查看<br>或者猛戳链接：'.$link.'<br>此封邮件来自吉林农业大学易班表白墙应用<br>
      $mail->AltBody = '';

      if(!$mail->send()) {
          echo '邮件发送失败！因为当前人数太多，邮件发送频率高被限制，不过系统会在稍后自动重新发送邮件，请放心，联系站长QQ：609046248<br>';
          echo 'Mailer Error: ' . $mail->ErrorInfo . '<br>';
          // 发送失败，标记isSended为2，0为未发送，1为发送成功，2为失败
          $sql = "UPDATE `saylove_2017_posts` set isSended = '2' where id='$uid'";
        	mysqli_query($linkDatabaese, $sql);
      } else {
          echo '邮件发送成功！<br>';
          $sql = "UPDATE `saylove_2017_posts` set isSended = '1' where id='$uid'";
        	mysqli_query($linkDatabaese, $sql);
      }
    }
  }

 ?>

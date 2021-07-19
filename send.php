<?php 
// Файлы phpmailer
require '/home/k/kgpod/fundamentvolga.ru/public_html/phpmailer/PHPMailer.php';
require '/home/k/kgpod/fundamentvolga.ru/public_html/phpmailer/SMTP.php';
require '/home/k/kgpod/fundamentvolga.ru/public_html/phpmailer/Exception.php';


$name = $_POST['name'];
$phone = $_POST['tel'];
$email = $_POST['email'];
$radio1 = $_GET['radio-1'];
$radio2 = $_GET['radio-2'];
$radio3 = $_GET['radio-3'];

// Формирование самого письма
$title = "Новая заявка с формы сайта Фундамент-Волга";
$body = '...';


if(!empty($radio1) && !empty($radio2) && !empty($radio3)) {
 $body = "
    <h2>Новая заявка с квиза  Фундамент-Волга</h2>
    <p> Из какого материала планируете строить дом? -> ".$radio1."</p>
    <p> У Вас есть геология участка под строительство? -> ".$radio2."</p>
    <p> Как далеко соседские дома и постройки от предполагаемого места для дома -> ".$radio3."</p>
    <p><b>Телефон:</b> ".$phone."<br></p>
    ";
} else {
    $body = "
    <h2>Новая заявка с формы сайта Фундамент-Волга</h2>
    <b>Телефон:</b> ".$phone."<br>
    "; 

}


$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    
    $mail->Host       = 'smtp.yandex.ru'; // Логин на почте
    $mail->Username   = 'info@fundamentvolga.ru'; // Логин на почте
    $mail->Password   = '64964BD5bj'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('info@fundamentvolga.ru', 'Имя отправителя'); // Адрес самой почты и имя отправителя

    // $mail->addAddress('info@fundamentvolga.ru');
    $mail->addAddress('director@seoprostor.ru');
    $mail->addAddress('buranov@seoprostor.ru');
    // $mail->addAddress('youremail@gmail.com'); // Ещё один, если надо
    
    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;    

    // Проверяем отравленность сообщения
    if ($mail->send()) {$result = "success";} 
    else {$result = "error";}

}  catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

echo json_encode(["result" => $result]);
<?php
// Files phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

$title = "Тема письма";
$file = $_FILES['file']; // Для inp type="file" name="file[]" multiple id="myfile". Для работы этого inp в form должен быть атрибут enctype="multipart/form-data"

$c = true;

//Формирование письма

$title = "Заголовок письма"ж
foreach ( $_POST as $key => $value ) {
    if ( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
        $body .= "
        " . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
        <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
        <td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
        </tr>
        ";
    }
}

$body = "<table style='width: 100%;'>$body</table>";

//Настройка PHPMailer

$mail = new PHPMailer\PHPMailer\PHPMailer();

try {
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth  = true;

    //Настройки нашей почты
    $mail->Host       = 'smtp.gmail.com';// SMTP сервера нашей почты
    $mail->Username   = 'maxgraph23@gmail.com';//Логин на почте
    $mail->Password   = '';//Пароль на почте //Заходим на свою почту -> управление аккаунтом -> Безопасность -> (Должна быть включена двухэтапная аутентификация) Пароли приложений -> Вводим свой пароль -> Создаем свой пароль. Полученный пароль (Lh07 LO56 09Hi OL76) записываем сюда
    $mail->SMTPSecure = 'ssl';//Шифрование
    $mail->Port       = 465;//Порт

    $mail->setFrom('maxgraph23@gmail.com', 'Заявка с нашего сайта');//Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('ldkdlf@gmail.com');
    $mail->addAddress('vnkjii@yandex.ru');//Еще один, если нужен

    //Прикрепление файлов к письму
    if (!empty($file['name'][0])) {
        for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
            $uploadfile = tempnam(sys_get_temp_dir(), shal($file['name'][$ct]));
            $filename = $file['name'][$ct];
            if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
                $mail->addAttachment($uploadfile, $filename);
                $rfile[] = "Файл $filename прикреплен";
            } else {
                $rfile[] = "Не удалось прикрепить файл $filename";
            }
        }
    }

    //Отправка сообщения

    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    $mail->send();

} catch (Exception $e) {
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}
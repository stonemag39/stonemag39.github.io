<?php
    $msg_box = ""; 
    $errors = array(); 

    // если форма без ошибок
    if(empty($errors)){     
        // собираем данные из формы
        $message = "Имя: " . $_POST['user_name'] . "<br/> Номер телефона: " . $_POST['user_tel'];
        send_mail($message); // отправим письмо
    }
     
    // функция отправки письма
    function send_mail($message){
        // почта, на которую придет письмо
        $mail_to = "sinya.kat@gmail.com"; 
        
        // тема письма
        $subject = "Заявка на бесплатный замер";
         
        // заголовок письма
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
        $headers .= "From: <sinya.kat@gmail.com>\r\n"; // от кого письмо
         
        // отправляем письмо 
        mail($mail_to, $subject, $message, $headers);
    }
     
?>

<?php

//В переменную $token нужно вставить токен, который нам прислал @botFather
$token = "1778168082:AAFSSaY8XOJQ1lRPYJOjK92-tuwriadT4HA";

//Сюда вставляем chat_id
$chat_id = "-546704130";

//Определяем переменные для передачи данных из нашей формы
    $name = ($_POST['user_name']);
    $phone = ($_POST['user_tel']);

//Собираем в массив то, что будет передаваться боту
    $arr = array(
        'Имя:' => $name,
        'Телефон:' => $phone
    );

//Настраиваем внешний вид сообщения в телеграме
    foreach($arr as $key => $value) {
        $txt .= "<b>".$key."</b> ".$value."%0A";
    };

//Передаем данные боту
    $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");

?>

<?php
// формируем запись в таблицу google (изменить)
$url = "https://docs.google.com/forms/d/1RXxmteU_Y6p78u3EN6nX1-EFtnrMY09Z3p9wRF5JfBE/formResponse";

// массив данных (изменить entry, draft и fbzx)
$post_data = array (
 "entry.1461396659" => $_POST['user_name'],
 "entry.330969374" => $_POST['user_tel'],
 "draftResponse" => "[,,&quot;-1141414548648688046&quot;]",
 "pageHistory" => "0",
 "fbzx" => "-1141414548648688046"
);

// Далее не трогать
// с помощью CURL заносим данные в таблицу google
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// указываем, что у нас POST запрос
curl_setopt($ch, CURLOPT_POST, 1);
// добавляем переменные
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
//заполняем таблицу google
$output = curl_exec($ch);
curl_close($ch);

?>
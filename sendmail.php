<?php

$email="info@linpass.ru;2400394@gmail.com;kogotok555@list.ru;savinkin@linpass.ru";
//$email="info@linpass.ru;kogotok555@list.ru";

if (isset($_POST['name']) && isset($_POST['email']))// && isset($_POST['subject']) && isset($_POST['subject']) && isset($_POST['message']))
{
	if (strlen($_POST['name']) && strlen($_POST['email'])>0)// && strlen($_POST['subject']) && strlen($_POST['subject']) && strlen($_POST['message'])>0)
	{
		$message="Name: ".htmlspecialchars($_POST['name'])."<br>";
		$message.="Contact: ".htmlspecialchars($_POST['email'])."<br>";
		//$message.="Subject: ".htmlspecialchars($_POST['subject'])."<br>";
		//$message.="Text message: ".htmlspecialchars($_POST['message'])."<br>";
		
		echo "Спасибо. Сообщение отправлено, мы с Вами свяжемся.";
		
		//mailsend($email, htmlspecialchars($_POST['name'])." / ".htmlspecialchars($_POST['email'])." / ".htmlspecialchars($_POST['subject']), $message);// На время	
		
		mailsend($email, htmlspecialchars($_POST['name'])." / ".htmlspecialchars($_POST['email']), $message);// На время	
		file_get_contents("https://api.telegram.org/bot5311194726:AAH-2qpRouhjTVN6Uiccnb58dYms8nIAhdw/sendMessage?chat_id=-743460592&text=Новый клиент: ".htmlspecialchars($_POST['name'])." / ".htmlspecialchars($_POST['email']));
	}
	
}


function mailsend($email, $subject, $message)
{
 $EOL = "\r\n";// ограничитель строк, некоторые почтовые сервера требуют \n - подобрать опытным путём
		//ini_set ('SMTP', 'mail.nic.ru');
       
		
		    $boundary     = "--".md5(uniqid(time()));  // любая строка, которой не будет ниже в потоке данных. 
		    $headers    = "MIME-Version: 1.0;$EOL";   
            $headers   .= "Content-Type: multipart/mixed; boundary=\"$boundary\"$EOL";  
            $headers   .= "From: info@linpass.ru\r\n"; 
			
			
			$multipart  = "--$boundary$EOL";   
            $multipart .= "Content-Type: text/html; charset=UTF-8$EOL";   
            $multipart .= "Content-Transfer-Encoding: base64$EOL";   
            $multipart .= $EOL; // раздел между заголовками и телом html-части 
            $multipart .= chunk_split(base64_encode($message));  
	
	
			//echo $email.$EOL;
		     //echo $subject.$EOL;
		     //echo $message.$EOL;
		
            mail($email, $subject, $multipart,$headers);
}



?>
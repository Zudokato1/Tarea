<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



$connect = mysqli_connect('localhost', 'admin', '123456', 'bd_form');

$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
$message = isset( $_POST['message'] ) ? $_POST['message'] : '';

$email_error = '';
$message_error = '';

if (count($_POST))
{ 
    $errors = 0;

    if ($_POST['email'] == '')
    {
        $email_error = 'Por favor ingrese su email';
        $errors ++;
    }

    if ($_POST['message'] == '')
    {
        $message_error = 'Por favor ingrese su email';
        $errors ++;
    }

    if ($errors == 0)
    {

        $query = 'INSERT INTO contacto (
                email,
                mensaje
            ) VALUES (
                "'.addslashes($_POST['email']).'",
                "'.addslashes($_POST['message']).'"
            )';
        mysqli_query($connect, $query);



    }
$mail = new PHPMailer();
try{

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Port = 2525;
$mail->Username = 'c0ec0dfbe709d3';
$mail->Password = '152d9093641794';

$mail->setFrom('juandavidm2015@hotmail.com');
$mail->addAddress($email);

$mail->isHTML(true);
$mail->Subject ='contacto desde el formulario';
$mail->Body    =$_POST['message'];


$mail->send();
echo'El mensaje ha sido enviado';
}catch(Exception $e) {
    echo'el mensaje no se a podido enviar',$email->ErrorInfo;
}
header('Location: thankyou.html');
die();

}

?>
<!doctype html>
<html>
    <head>
        <title>PHP Formulario</title>
    </head>
    <body>
    
        <h1>PHP Formulario</h1>

        <form method="post" action="">
        
            ingrese su correo:
            <br>
            <input type="text" name="email" value="<?php echo $email; ?>">
            <?php echo $email_error; ?>

            <br><br>

            Mensaje:
            <br>
            <textarea name="message"><?php echo $message; ?></textarea>
            <?php echo $message_error; ?>

            <br><br>

            <input type="submit" value="Submit">
        
        </form>
    
    </body>
</html>

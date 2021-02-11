<?php


//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

class envioEmail { 
    //private $mail;
    private $emailAddress;
    //private $password;

    function __construct($email) {
        $this->emailAddress = $email;
    }

    function sendMail() {
        //Crear un objeto nuevo email
        $mail = new PHPMailer();

        //Usamos SMTP
        $mail->isSMTP();

        //Permitir SMTP debugging
        // SMTP::DEBUG_OFF = off (Cuando el software esté en producción)
        // SMTP::DEBUG_CLIENT = Mensajes sólo clientes
        // SMTP::DEBUG_SERVER = Mensajes de clientes y servidor 
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        //Asignamos el servidor
        $mail->Host = 'smtp.gmail.com';
        // usar
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // Si tu red no soporta ipV6

        //Asignar el número de puerto SMTP  - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;

        //Asignar el mecanismo de encriptación - STARTTLS or SMTPS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        //Activamos comunicación segura SMTP authentication
        $mail->SMTPAuth = true;

        //Usuario que se logea en gmail - hay que usar la misma dirección de email completa
        $mail->Username = 'andres.examen@gmail.com';

        //Contraseña de gmail para la SMTP authentication
        $mail->Password = 'estanolasabenadie0123';

        //Asignar el 'desde'
        $mail->setFrom('andres.alcaraz@politecnicomalaga.com', 'Tienda Web 3.0');

        // reply-to address
        $mail->addReplyTo('andres.alcaraz@politecnicomalaga.com', 'Tienda Web 3.0');

        //Dirección de envío
        $mail->addAddress($this->emailAddress, $this->emailAddress);

        //Ponemos el asunto
        $mail->Subject = 'Bienvenido a la tienda web 3.0';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        $mail->msgHTML("<p>Este es el mensaje que leera el cliente...</p>", __DIR__);
        //Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';

        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');

        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #}
        }
    }

}

?>

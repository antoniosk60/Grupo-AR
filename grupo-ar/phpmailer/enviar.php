<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación y saneamiento de datos
    $nombre = filter_var(trim($_POST["nombre"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $mensaje = filter_var(trim($_POST["mensaje"]), FILTER_SANITIZE_STRING);
    
    // Verificación de campos obligatorios
    if (empty($nombre) || empty($mensaje) || !$email) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Por favor complete todos los campos correctamente.']);
        exit;
    }
    
    // Configuración de PHPMailer
    $mail = new PHPMailer(true);
    
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'angelantonioflore837@gmail.com';
        $mail->Password = ''; // Considerar usar variables de entorno
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';
        
        // Remitente y destinatarios
        $mail->setFrom('angelantonioflore837@gmail.com', 'Grupo AR');
        $mail->addAddress('angelantonioflore837@gmail.com');
        $mail->addAddress('randaleonel@gmail.com');
        $mail->addReplyTo($email, $nombre);
        
        // Contenido del correo
        $mail->Subject = 'Nuevo mensaje desde el sitio web Grupo AR';
        $mail->Body = "
            <h2>Nuevo mensaje de contacto</h2>
            <p><strong>Nombre:</strong> {$nombre}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Mensaje:</strong></p>
            <p>{$mensaje}</p>
        ";
        $mail->AltBody = "Nombre: {$nombre}\nEmail: {$email}\nMensaje:\n{$mensaje}";
        $mail->isHTML(true);
        
        // Envío del correo
        $mail->send();
        
        // Respuesta JSON para AJAX
        echo json_encode(['success' => true, 'message' => 'Mensaje enviado con éxito. Nos pondremos en contacto pronto.']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => "Error al enviar el mensaje: {$mail->ErrorInfo}"]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
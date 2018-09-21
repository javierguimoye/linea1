<?php namespace Inc;

use PHPMailer\PHPMailer\PHPMailer;

class UMail
{

    // Configurar Mailer
    private static function getMailer()
    {
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        //$mail->SMTPDebug = 2;
        //$mail->Debugoutput = 'html';

        $mail->setFrom(STG::get('mail_sender'), STG::get('brand'));

        if ($mail_bcc = STG::get('mail_bcc')) {
            $mail->addBCC($mail_bcc);
        }

        if (STG::bool('mail_auth')) {
            $mail->isSMTP();
            $mail->Host = STG::get('mail_host');
            $mail->SMTPAuth = true;
            $mail->Username = STG::get('mail_username');
            $mail->Password = STG::get('mail_password');
        }

        return $mail;
    }

    // Correo de confirmacion
    public static function sendPassword($email, $pwd)
    {
        $mail = self::getMailer();
        $mail->addCC($email);
        $mail->Subject = 'Tu contraseña';
        $mail->msgHTML('
			Hola ' . $email . ',
			<br>has solicitado la contraseña para tu cuenta de ' . STG::get('brand') . '.
			<br><br>Contraseña: <b>' . $pwd . '</b><br>
			<br>El equipo de ' . STG::get('brand') . '.
		');
        return ($mail->send());
    }

}
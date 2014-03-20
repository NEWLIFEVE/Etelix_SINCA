<?php
class EnviarEmail extends CFormatter
{
    public function sendEmail($html,$correo,$topic,$dir=null)
    {
        if(isset($html) && isset($correo))
        {
            $mailer=Yii::createComponent('application.extensions.mailer.EMailer');
            $mailer->Host = 'smtp.gmail.com';
            $mailer->Port = '587';
            //$mailer->SMTPDebug = 2;
            $mailer->SMTPSecure = 'tls';
            $mailer->Username = 'sinca.test@gmail.com';
            $mailer->SMTPAuth = true;
            $mailer->Password ="sincatest";
            $mailer->IsSMTP();
            $mailer->IsHTML(true);
            $mailer->From = 'sinca.test@gmail.com';
            $mailer->AddReplyTo('sinca.test@gmail.com');
            $mailer->AddAddress($correo);
            $mailer->FromName = 'SINCA';
            $mailer->CharSet = 'UTF-8';
            $mailer->Subject = Yii::t('', $topic);
            $mailer->AddAttachment($dir);
            $message = $html;
            $mailer->Body = $message;
            if($mailer->Send())
                unlink($dir);
        }
    }
}
?>
<?php
class EnviarEmail extends CFormatter
{
    public function enviar()
    {
        if(isset($_POST ['html']) && isset($_POST ['correoUsuario']))
        {
            $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
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
            $mailer->AddAddress($_POST ['correoUsuario']);
            $mailer->FromName = 'SINCA';
            $mailer->CharSet = 'UTF-8';
            $mailer->Subject = Yii::t('', $_POST['asunto']);
            $message = $_POST['html'];
            $mailer->Body = $message;
            $mailer->Send();
        }
    }

    /**
     * Encargado de enviar los reportes por correo electronico
     * @param $cuerpo string cuerpo del email
     * @param $direccion string direccion de correo electronico
     */
    public function enviarReporte($cuerpo, $direccion, $asunto, $ruta=null)
    {
        $mailer=Yii::createComponent('application.extensions.mailer.EMailer');
        $mailer=new PHPMailer();
        $mailer->IsSMTP();
        $mailer->Host='smtp.gmail.com';
        $mailer->Port='587';
        //$mailer->SMTPDebug = 2;
        $mailer->SMTPSecure='tls';
        $mailer->Username='sinca.test@gmail.com';
        $mailer->SMTPAuth=true;
        $mailer->Password="sincatest";
        $mailer->IsSMTP();
        $mailer->IsHTML(true);
        $mailer->From='sinca.test@gmail.com';
        $mailer->AddReplyTo('sinca.test@gmail.com');
        $mailer->AddAddress($direccion);
        $mailer->FromName='SINCA';
        $mailer->CharSet='UTF-8';
        $mailer->Subject=Yii::t('',$asunto);
        //$mailer->AddAttachment($ruta); //Archivo adjunto
        $mailer->Body=$cuerpo;
        $mailer->Send();
    }
}
?>
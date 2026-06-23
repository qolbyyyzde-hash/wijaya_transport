<?php
function send_email($to, $subject, $body){
    // Prefer PHPMailer if installed via Composer, otherwise fallback to mail().
    $sent = false;
    $logBody = $body;
    if(file_exists(__DIR__ . '/../vendor/autoload.php')){
        require_once __DIR__ . '/../vendor/autoload.php';
        if(class_exists('\PHPMailer\PHPMailer\PHPMailer')){
            try{
                $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                // If SMTP settings provided via env, configure them
                $smtpHost = getenv('SMTP_HOST');
                if($smtpHost){
                    $mail->isSMTP();
                    $mail->Host = $smtpHost;
                    $mail->SMTPAuth = true;
                    $mail->Username = getenv('SMTP_USER') ?: '';
                    $mail->Password = getenv('SMTP_PASS') ?: '';
                    $mail->SMTPSecure = getenv('SMTP_SECURE') ?: 'tls';
                    $mail->Port = getenv('SMTP_PORT') ?: 587;
                }
                $mail->setFrom(getenv('MAIL_FROM') ?: 'no-reply@wijaya.local', 'Wijaya Transport');
                $mail->addAddress($to);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $sent = $mail->send();
                $logBody = "PHPMailer used.\n" . $body;
            } catch(Exception $e){
                $sent = false;
                $logBody = "PHPMailer error: " . $e->getMessage() . "\n" . $body;
            }
        }
    }

    if(!$sent){
        $headers = "From: " . (getenv('MAIL_FROM') ?: 'no-reply@wijaya.local') . "\r\n" .
                   "MIME-Version: 1.0\r\n" .
                   "Content-type: text/html; charset=UTF-8\r\n";
        try{ $sent = @mail($to, $subject, $body, $headers); } catch(Exception $e){ $sent = false; }
    }

    $log = date('c') . " TO:" . $to . " SUBJ:" . $subject . " SENT:" . ($sent?1:0) . "\n" . $logBody . "\n\n";
    if(!is_dir(__DIR__ . '/../storage')) mkdir(__DIR__ . '/../storage',0755,true);
    file_put_contents(__DIR__ . '/../storage/email.log', $log, FILE_APPEND);
    return $sent;
}

<?php
require 'lib/phpmailer/PHPMailerAutoload.php';

class Mailer {
  private $mail;
  private $sent_successfully;

  public function __construct() {
    $this->mail = new PHPMailer;
    $this->setup_common_properties();
  }

  // Send an email using a bunch of easy to guess parameters.
  public function send($pars) {
    $this->mail->From = $pars['from'];
    $this->mail->FromName = $pars['from_name'];
    $this->mail->addAddress($pars['to']);
    $this->mail->addReplyTo($pars['from'], $pars['from_name']);
    $this->mail->Subject = $pars['subject'];
    $this->mail->Body = $pars['body'];

    $this->sent_successfully = $this->mail->send();

    return $this->sent_successfully;
  }

  // Return true if the last email was sent successfully.
  public function sent_successfully() {
    return $this->sent_successfully;
  }

  // Private methods

  // Setup properties that all sent emails should have in common.
  private function setup_common_properties() {
    $this->mail->isSMTP();
    $this->mail->Host = '127.0.0.1:1025';
    $this->mail->SMTPAuth = false;
    $this->mail->isHTML(false);
    $this->mail->WordWrap = 50;
  }
}
?>

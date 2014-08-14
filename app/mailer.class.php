<?php
require 'lib/phpmailer/PHPMailerAutoload.php';

class Mailer {
  public function __construct() {
    $this->mail = new PHPMailer;
    $this->setup_common_properties();
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

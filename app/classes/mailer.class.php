<?php
/**
 * This file contains a wrapper class around the `PHPMailer` class.
 * @package Gamespot
 * @subpackage Common
 */
require 'lib/phpmailer/PHPMailerAutoload.php';

/**
 * A wrapper class around the `PHPMailer` class.
 */
class Mailer {
  private $mail;
  private $sent_successfully;

  public function __construct() {
    $this->mail = new PHPMailer;
    $this->setup_common_properties();
  }

  /**
   * Send an email.
   * @param array $pars An easy to guess array of parameters (from, to, etc)
   * @return bool True if the email was sent successfully, false otherwise
   */
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

  /**
   * Returns true if the last email was sent successfully, false otherwise.
   * @return bool Whether the last email was sent successfully.
   */
  public function sent_successfully() {
    return $this->sent_successfully;
  }

  /**
   * Setup common properties that all sent emails should share.
   */
  private function setup_common_properties() {
    $this->mail->isSMTP();
    $this->mail->Host = '127.0.0.1:1025';
    $this->mail->SMTPAuth = false;
    $this->mail->isHTML(false);
    $this->mail->WordWrap = 50;
  }
}
?>

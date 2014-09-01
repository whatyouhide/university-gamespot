<?php
/**
 * This file contains a wrapper class (Mailer) around the PHPMailer class.
 */

namespace Common;

// Require the original PHPMailer class.
require 'lib/phpmailer/PHPMailerAutoload.php';

/**
 * A wrapper class around the `PHPMailer` class.
 * @package Gamespot
 * @subpackage Common
 */
class Mailer {
  /**
   * @var PHPMailer The wrapped instance of PHPMailer.
   */
  private $mail;

  /**
   * @var bool Whether the last email was sent successfully.
   */
  private $sent_successfully;

  /**
   * Create a new instance of Mailer and setup some common properties.
   */
  public function __construct() {
    $this->mail = new \PHPMailer;
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

    if (isset($pars['is_html'])) {
      $this->mail->isHTML(true);
    }

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
   * Return infos about the last error.
   * @return string
   */
  public function error_infos() {
    return $this->mail->ErrorInfo;
  }

  /**
   * Setup common properties that all sent emails should share.
   */
  private function setup_common_properties() {
    // Gmail.
    $this->mail->isSMTP();
    $this->mail->SMTPAuth = true;
    $this->mail->SMTPSecure = 'tls';
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->Port = 587;
    $this->mail->Username = 'twdgamespot@gmail.com';
    $this->mail->Password = 'tecnodelweb';

    $this->mail->isHTML(false);
    $this->mail->WordWrap = 50;
  }
}
?>

<?php
class SignInCommons {
  public static $userEmail = 'an.leopardi@gmail.com';
  public static $userPassword = 'pwd';

  public static function signInUser($I) {
    $I->amOnPage('/users/sign_in');
    self::fillEmailAndPassword($I, self::$userEmail, self::$userPassword);
    $I->click('input[type=submit]');
  }

  private static function fillEmailAndPassword($I, $email, $password) {
    $I->fillField('email', $email);
    $I->fillField('password', $password);
  }
}
?>

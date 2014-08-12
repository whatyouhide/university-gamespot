<?php
use Codeception\Util\Stub;

class UserTest extends \Codeception\TestCase\Test {
  /**
   * @var \CodeGuy
   */
  protected $codeGuy;

  protected function _before() {}
  protected function _after() {}

  public function testPasswordHashing() {
    $email = 'unique@unique.unique';
    $pass = 'test';

    User::create(array(
      'email' => $email,
      'password' => $pass,
      'first_name' => 'A',
      'last_name' => 'B'
    ));

    $this->codeGuy->seeInDatabase('users', array('email' => $email));

    $user = User::find('email', $email);
    $this->assertEquals($user['hashed_password'], md5($pass));
  }
}

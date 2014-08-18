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
    $p = 'passw0rD';
    $this->assertEquals(User::hash_password($p), md5($p));
  }

  public function testPasswordHashingOnCreation() {
    $email = "unique@unique.unique";
    $pass = 'test';

    $user = User::create([
      'email' => $email,
      'password' => $pass,
      'first_name' => 'A',
      'last_name' => 'B'
    ]);

    $this->codeGuy->seeInDatabase('users', ['email' => $email]);
    $this->assertEquals($user->hashed_password, md5($pass));
  }

  public function testUpdatePassword() {
    $user = User::create([
      'email' => 'testinupdatepassword@b.com',
      'password' => '3145yh4qtegr'
    ]);

    $old_hash = $user->hashed_password;
    $user->update_password('dqrfqr');

    $this->assertFalse($old_hash == $user->hashed_password);
  }
}

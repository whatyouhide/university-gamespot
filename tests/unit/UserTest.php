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
      'email' => 'ciaoword@bubba.com',
      'password' => '3145yh4qtegr'
    ]);

    $old_hash = $user->hashed_password;
    $user->update_password('dqrfqr');

    $this->assertFalse($old_hash == $user->hashed_password);
  }

  public function testFullName() {
    $user = User::create([
      'first_name' => 'Sandro',
      'last_name' => 'Marchionni',
      'email' => 'testingfullname@test.test',
      'password' => '1312321312'
    ]);

    $this->assertEquals($user->full_name(), 'Sandro Marchionni');
  }

  public function testValidations() {
    $user = User::create([
      'first_name' => 'Sandro',
      'last_name' => 'Marchionni',
      'email' => 'testinguser@validations.com',
      'password' => ''
    ]);

    $this->assertFalse($user->is_valid());
    $this->assertContains("Password can't", $user->errors()[0]);

    $user = User::create([
      'first_name' => 'Sandro',
      'last_name' => 'Marchionni',
      'email' => 'aa',
      'password' => 'hello'
    ]);

    $this->assertFalse($user->is_valid());
    $this->assertContains("invalid", $user->errors()[0]);
  }
}

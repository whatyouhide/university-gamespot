<?php
use Codeception\Util\Stub;

class ModelTest extends \Codeception\TestCase\Test {
  /**
   * @var \CodeGuy
   */
  protected $codeGuy;

  private $email_seq = 0;

  protected function _before() {}
  protected function _after() {}

  public function testAll() {
    // Clean the 'users' table.
    (new DB)->query('TRUNCATE `users`');

    $this->assertEquals(intval(count(User::all())), 0);

    $this->create_user_called();
    $all = User::all();
    $this->assertEquals(count($all), 1);
  }

  public function testWhere() {
    $this->create_user_called('John', 'Doe');
    $this->create_user_called('John', 'Doe');
    $both = User::where(['first_name' => 'John', 'last_name' => 'Doe']);
    $this->assertEquals(count($both), 2);
  }

  public function testFind() {
    $email = $this->next_email();
    User::create([
      'email' => $email,
      'password' => '67890',
      'first_name' => 'A',
      'last_name' => 'B'
    ]);

    $user = User::find($email);
    $this->assertEquals($user->email, $email);
    $this->assertEquals($user->first_name, 'A');
  }

  private function create_user_called($first_name = 'a', $last_name = 'b') {
    User::create([
      'email' => $this->next_email(),
      'password' => '67890',
      'first_name' => $first_name,
      'last_name' => $last_name
    ]);

  }

  private function next_email() {
    $email = "{$this->email_seq}model_testing@unique.email";
    $this->email_seq++;
    return $email;
  }
}
?>

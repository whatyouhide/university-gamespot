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
    Db::query('SET FOREIGN_KEY_CHECKS=0');
    Db::query('TRUNCATE `users`');
    Db::query('SET FOREIGN_KEY_CHECKS=1');

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
    $user = $this->create_user_with_email($email);
    $this->assertNotNull($user);
    $this->assertEquals($user->email, $email);
  }

  public function testCreate() {
    $attrs = [
      'email' => 'test@test.test',
      'password' => '67890',
      'first_name' => 'Unique',
      'last_name' => 'Name'
    ];

    $user = User::create($attrs);

    // Clean the 'password' attribute (will be changed by hashing).
    unset($attrs['password']);

    $this->codeGuy->seeInDatabase('users', $attrs);
    $this->assertNotNull($user);
    $this->assertEquals($user->email, $attrs['email']);

    $game = Game::create(['name' => 'PES']);
    $this->codeGuy->seeInDatabase('games', ['name' => 'PES']);
    $this->assertNotNull($game);
    $this->assertEquals($game->name, 'PES');
  }

  public function testUpdate() {
    $email = 'update@test.test';
    $user = $this->create_user_with_email($email);
    $this->codeGuy->seeInDatabase('users', ['email' => $email]);
    $this->assertEquals($user->email, $email);

    $new_email = 'new@email.updatetest';
    $user->update(['email' => $new_email]);
    $this->codeGuy->seeInDatabase('users', ['email' => $new_email]);
    $this->assertEquals($user->email, $new_email);
  }

  public function testDestroy() {
    $email = 'test@destroying.com';
    $user = $this->create_user_with_email($email);

    $user->destroy();
    $this->codeGuy->dontSeeInDatabase('users', ['email' => $email]);
    $this->assertFalse(isset($user->attributes()['email']));
  }

  public function testGet() {
    $email = 'my@email.com';
    $user = $this->create_user_with_email($email);
    $this->assertEquals($user->email, $email);
  }

  public function testSet() {
    $email = 'he@llo.com';
    $user = $this->create_user_with_email($email);
    $user->test_property_yeah = 10;
    $this->assertEquals($user->test_property_yeah, 10);
  }

  public function testReload() {
    $game = Game::create(['name' => 'Test game']);
    $this->assertEquals($game->name, 'Test game');

    $new_name = 'New test game';
    $game->update(['name' => $new_name]);
    $this->assertEquals($game->name, $new_name);
  }

  public function testAttributes() {
    $name = 'Test game';
    $game = Game::create(['name' => $name]);
    $this->assertNotNull($game->attributes());
    $this->assertEquals($game->attributes()['name'], $name);
  }

  private function create_user_called($first_name = 'a', $last_name = 'b') {
    return User::create([
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

  private function create_user_with_email($email) {
    return User::create([
      'email' => $email,
      'password' => '67890',
      'first_name' => 'John',
      'last_name' => 'Doe'
    ]);
  }
}
?>

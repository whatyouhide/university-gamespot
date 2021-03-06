<?php
use Codeception\Util\Stub;
use Common\Db;

class DbTest extends \Codeception\TestCase\Test {
  /**
   * @var \CodeGuy
   */
  protected $codeGuy;

  protected function _before() {}
  protected function _after() {}

  public function testQuery() {
    $email = 'nonezistent@ema.il';
    $this->codeGuy->dontSeeInDatabase('users', ['email' => $email]);

    Db::query("INSERT INTO `users`(`email`) VALUES ('$email')");
    $this->codeGuy->seeInDatabase('users', ['email' => $email]);

    Db::query('SET FOREIGN_KEY_CHECKS=0');
    Db::query('TRUNCATE `users`');
    Db::query('SET FOREIGN_KEY_CHECKS=1');
    $this->codeGuy->dontSeeInDatabase('users', ['email' => $email]);
  }

  public function testGetRows() {
    $email = 'nonezistent@ema.il';
    $this->codeGuy->dontSeeInDatabase('users', ['email' => $email]);

    Db::query("INSERT INTO `users`(`email`) VALUES ('$email')");
    $rows = Db::get_rows("SELECT * FROM users");

    $this->assertFalse(array_search($email, $rows));
  }

  public function testArrayFromOneColumnQuery() {
    $res = Db::array_from_one_column_query("SELECT COUNT(*) FROM users");
    $this->assertTrue(is_array($res));
    $this->assertEquals(count($res), 1);
  }
}

<?php
use Codeception\Util\Stub;

class FunctionsTest extends \Codeception\TestCase\Test {
  /**
   * @var \CodeGuy
   */
  protected $codeGuy;

  protected function _before() {}
  protected function _after() {}

  public function testSurroundWith() {
    $this->assertTrue(is_callable(surround_with('')));

    $quote = surround_with("'");
    $this->assertEquals($quote('hello'), "'hello'");

    $multichar = surround_with('foo');
    $this->assertEquals($multichar(' bar '), 'foo bar foo');
  }

  public function testRandomString() {
    $this->assertEquals(gettype(random_string()), 'string');
    $this->assertEquals(strlen(random_string(15)), 15);
  }

  public function testArrayGroup() {
    $people = [
      ['name' => 'test1', 'gender' => 'm'],
      ['name' => 'test2', 'gender' => 'f'],
      ['name' => 'test3', 'gender' => 'm']
    ];

    $group_by_gender = function ($person) { return $person['gender']; };
    $genders = array_group($people, $group_by_gender);

    // There are two genders.
    $this->assertEquals(count($genders), 2);

    // There are two males and one female.
    $this->assertEquals(count($genders['m']), 2);
    $this->assertEquals(count($genders['f']), 1);

    // Assert that the female is the right one.
    $this->assertEquals($genders['f'][0], ['name' => 'test2', 'gender' => 'f']);
  }

  public function testArrayExtract() {
    $arr = ['a' => 1, 'b' => 2, 'c' => 3];

    $this->assertEquals(array_extract($arr, []), []);

    $this->assertEquals(array_extract($arr, ['a']), ['a' => 1]);
    $this->assertEquals(array_extract($arr, ['a', 'b']), ['a' => 1, 'b' => 2]);
    $this->assertEquals(array_extract($arr, array_keys($arr)), $arr);

    $this->assertEquals(array_extract($arr, ['nonex']), ['nonex' => null]);
    $this->assertEquals(array_extract($arr, ['a', 'foo']), ['a' => 1, 'foo' => null]);
    $this->assertEquals(array_extract($arr, ['nonex'], 'default'), ['nonex' => 'default']);
  }
}

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
}

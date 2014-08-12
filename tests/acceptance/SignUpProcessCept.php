<?php
$scenario->group(array('sign-up', 'user'));

$firstName = 'Fir';
$lastName = 'Las';
$email = 'a@b.com';
$password = 'asd';

$I = new WebGuy($scenario);
$I->wantTo('sign up as a new user');

$I->amOnPage('/');

$I->click('sign up');

$I->seeInCurrentUrl('sign_up');
$I->see('name');
$I->see('email');
$I->see('password');

$I->fillField('first_name', $firstName);
$I->fillField('last_name', $lastName);
$I->fillField('email', $email);
$I->fillField('password', $password);
$I->click('input[type=submit]');

$I->see('success');
$I->seeInDatabase('users', array(
  'email' => $email,
  'first_name' => $firstName,
  'last_name' => $lastName
));
?>

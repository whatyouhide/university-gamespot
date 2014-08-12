<?php
$scenario->group(array('sign-in', 'user'));

$userEmail = 'an.leopardi@gmail.com';
$userPassword = 'pwd';

$I = new WebGuy($scenario);

$I->seeInDatabase('users', array('email' => $userEmail));

$I = new WebGuy($scenario);
$I->wantTo('Sign in');

$I->amOnPage('/');

$I->click('Sign in');

$I->seeInCurrentUrl('sign_in');
$I->see('Email');
$I->see('Password');


$I->fillField('email', $userEmail);
$I->fillField('password', $userPassword);
$I->click('input[type=submit]');

$I->seeLink('Sign out');
$I->seeLink('Profile');
?>

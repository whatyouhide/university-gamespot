<?php
$I = new WebGuy($scenario);
$I->wantTo('Sign in');
$I->amOnPage('/');

$I->click('Sign in');
$I->see('Email');
$I->see('Password');

$I->fillField('email', 'an.leopardi@gmail.com');
$I->fillField('password', 'pwd');
$I->click('input[type=submit]');

$I->seeInCurrentUrl('/');
$I->see('Sign out');
?>

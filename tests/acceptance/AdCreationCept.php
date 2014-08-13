<?php

$city = 'Rome';
$description = 'lorem ipsum dolor';
$price = 100;

$I = new WebGuy($scenario);
$I->wantTo('create a new ad');

SignInCommons::signInUser($I);

$I->amOnPage('/users/profile');
$I->click('Create game ad');

$I->fillField('city', $city);
$I->fillField('description', $description);
$I->fillField('price', $price);
$I->selectOption('console_name', 'PlayStation 3');
$I->selectOption('game_name', 'Beyond');

$I->click('input[type=submit]');

$I->seeInDatabase('ads', array(
  'city' => $city,
  'description' => $description,
  'price' => $price
));

$I->see('created');
?>

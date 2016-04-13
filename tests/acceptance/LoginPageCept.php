<?php
use Page\LoginPage;
use Page\SetupExamSelectPage;

$I = new AcceptanceTester($scenario);
$I->wantTo('Login to the site');


// logging in
$I->amOnPage(LoginPage::$URL);
$I->fillField(LoginPage::$emailField, LoginPage::$testAccountEmail);
$I->fillField(LoginPage::$passwordField, LoginPage::$testAccountPassword);
$I->click(LoginPage::$loginButton);

//redirected properly
$I->amGoingTo("check that properly redirected to exam setup page");
$I->seeInCurrentUrl(SetupExamSelectPage::$URL);
$I->seeInTitle(SetupExamSelectPage::$pageTitleText);
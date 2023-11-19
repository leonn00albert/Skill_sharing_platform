<?php
// tests/acceptance/HomepageCept.php
use \AcceptanceTester;
class RegisterCest
{

    public function RegisterPage(AcceptanceTester $I)
    {
        $I->wantTo('ensure that the register works');

        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);
        $I->see('Register', 'h1');
        $I->seeElement('.ui.input'); // Check for input fields with class 'ui input'
        $I->seeElement('button.ui.primary.button'); // Check for a button with class 'ui primary button'
        $I->fillField('registrationForm[email]', 'test@example.com');
        $I->fillField('registrationForm[plainPassword]', 'test_password');
        $I->selectOption('registrationForm[roles]', 'ROLE_USER');
        $I->click('Register');
        $I->seeCurrentUrlEquals('/');
    }
}

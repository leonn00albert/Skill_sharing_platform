<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;
use Codeception\Lib\Interfaces\DependsOnModule;

class RegisterCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {


        $I->wantTo('Register a new user');

        $I->amOnPage('/register');

        $I->fillField('//input[@id="registration_form_email"]', 'teacher@acceptiontest.com');
        $I->selectOption('//select[@id="registration_form_roles"]', 'ROLE_TEACHER');

        $I->fillField('//input[@id="registration_form_plainPassword"]', 'password123');

        $I->click('button[type="submit"]');
    }
    public function _after(AcceptanceTester $I)
    {
        $I->amOnPage('/test/clean/user');

        $I->seeResponseCodeIs(200);
        $I->see('User deleted successfully.');
    }
}

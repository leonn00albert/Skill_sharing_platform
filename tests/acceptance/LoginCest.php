<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/register'); 
        
        $I->fillField('//input[@id="registration_form_email"]', 'teacher@acceptiontest.com');
        $I->selectOption('//select[@id="registration_form_roles"]', 'ROLE_TEACHER');
        
        $I->fillField('//input[@id="registration_form_plainPassword"]', 'password123');
        
        $I->click('button[type="submit"]');
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->wantTo('Log in');

        $I->amOnPage('/login');
        $I->fillField('#username', 'teacher@acceptiontest.com');
        $I->fillField('#password', 'password123');
        $I->click('button[type="submit"]');
        $I->seeCurrentUrlEquals('/courses');
    }
    
}

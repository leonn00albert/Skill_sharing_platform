<?php
// tests/acceptance/HomepageCept.php

class HomePageCept
{
    public function homePage(AcceptanceTester $I)
    {
        $I->wantTo('ensure that the homepage works');
        $I->amOnPage('/');
        $I->see('MakerShare');
        $I->see('Welcome to the MakerShare website!');
        
    }
    
}

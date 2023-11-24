<?php


namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;

class ManageCoursesCest
{
    public function _before(AcceptanceTester $I)
    {

        $I->amOnPage('/login');
        $I->fillField('#username', 'teacher@acceptiontest.com');
        $I->fillField('#password', 'password123');
        $I->click('button[type="submit"]');
        $I->seeCurrentUrlEquals('/courses');
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->wantTo('Create a course and delete it');

        $courseTitle = 'New Course Test';
        $courseDescription = 'Description for the new course';
        $imagePath ='./test.png';
        $I->amOnPage('/teacher/course/new');
        $I->fillField('#course_title', $courseTitle);
        $I->fillField('#course_description', $courseDescription);
        $I->attachFile('input[name="course[imageFile]"]', $imagePath);
        $I->click('button[type="submit"]');

        $I->see($courseTitle);
        $I->see($courseDescription);
        $I->seeCurrentUrlEquals('/teacher/courses');
        $I->wantTo('Delete a course');
        $I->amOnPage('/teacher/courses');
        $I->click("//*[contains(text(), '$courseTitle')]/ancestor::div[@class='card']//a[contains(@href, 'delete')]");
    }

    public function _after(AcceptanceTester $I)
    {
        $I->amOnPage('/test/clean/user');

        $I->seeResponseCodeIs(200);
        $I->see('User deleted successfully.');
    }
}

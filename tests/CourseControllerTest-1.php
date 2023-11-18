<?php
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class CourseControllerTest extends TestCase
{

    public function testCreate()
    {
        $client = static::createClient();

        // Simulate an authenticated user
        $user = // create a user or use a fixture to get an existing user

        // Make a POST request to the create route
        $crawler = $client->request('POST', '/course/create', [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $user->getApiToken(),
        ], json_encode([
            // provide the necessary request data here
        ]));

        // Assert that the response is successful
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Assert that the flash message is set
        $this->assertContains('Course created successfully', $crawler->filter('.flash-messages')->text());

        // Assert that the user is redirected to the teacher_courses route
        $this->assertEquals('teacher_courses', $client->getRequest()->attributes->get('_route'));
    }
    public function testDelete(): void
    {
        // Create a mock EntityManagerInterface
        $entityManager = $this->createMock(EntityManagerInterface::class);

        // Create a mock Course object
        $course = $this->createMock(Course::class);

        // Set up the mock EntityManagerInterface to return the mock Course object
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($this->returnValueMap([
                [Course::class, $this->returnValueMap([
                    [$id, $course]
                ])]
            ]));

        // Set up the mock EntityManagerInterface to expect the remove and flush methods to be called
        $entityManager->expects($this->once())
            ->method('remove')
            ->with($course);
        $entityManager->expects($this->once())
            ->method('flush');

        // Create an instance of the CourseController class
        $controller = new CourseController();

        // Call the delete method with the mock EntityManagerInterface
        $response = $controller->delete($id, $entityManager);

        // Assert that the response is a redirect response
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('teacher_courses', $response->getTargetUrl());
    }
}
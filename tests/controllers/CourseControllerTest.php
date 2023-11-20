<?php
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CourseControllerTest extends WebTestCase
{
    public function testListAction()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        $entityManager = $container->get('doctrine')->getManager();
        $connection = $entityManager->getConnection();
        $params = $connection->getParams();
        $params['driver'] = 'pdo_sqlite';
        $connection->__construct($params, $connection->getDriver(), $connection->getConfiguration(), $connection->getEventManager());

        $course = new \App\Entity\Course();
        $course->setTitle('Test Course');
        $entityManager->persist($course);
        $entityManager->flush();

        $client->request('GET', '/courses');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', 'Course List');
        $this->assertSelectorTextContains('td', 'Test Course');
    }

}
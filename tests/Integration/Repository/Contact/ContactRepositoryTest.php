<?php


namespace App\Tests\Integration\Repository\Contact;


use App\Tests\TestCase;

class ContactRepositoryTest extends TestCase
{
    public function testFake()
    {
        $entities = $this->loadFile('tests/.fixtures/user.yml');

        $this->assertTrue(true);
    }
}
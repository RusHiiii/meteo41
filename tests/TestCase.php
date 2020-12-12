<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TestCase extends KernelTestCase
{
    protected $loader;

    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->loader =  self::$container->get('fidry_alice_data_fixtures.loader.doctrine');
    }

    protected function loadFile($files)
    {
        $fixtureToLoad = $files;
        if (!is_array($files)) {
            $fixtureToLoad = [$files];
        }

        return $this->loader->load($fixtureToLoad);
    }
}
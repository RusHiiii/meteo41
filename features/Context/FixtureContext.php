<?php

namespace Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

final class FixtureContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        KernelInterface $kernel,
        EntityManagerInterface $entityManager
    ) {
        $this->kernel = $kernel;
        $this->entityManager = $entityManager;
    }

    /**
     * @Given I load the fixture :fixtureName
     */
    public function iLoadTheFixture($fixtureName)
    {
        $this->resetAutoIncrement();

        $loader = $this->kernel->getContainer()->get('fidry_alice_data_fixtures.loader.doctrine');

        $fixtureFile = sprintf('tests/.fixtures/%s.yml', $fixtureName);

        $loader->load([$fixtureFile]);
    }

    /**
     * @Then Object :object in namespace :namespace with attribute :attribute equal :value should exist in database
     */
    public function objectInNamespaceWithAttributeEqualShouldExistInDatabase($object, $namespace, $attribute, $value)
    {
        $entity = $this->kernel->getContainer()->get('doctrine')
            ->getRepository("App\Entity\\$namespace\\$object")
            ->findOneBy(
                [
                    $attribute => $value
                ]
            );

        Assert::notNull($entity);
    }

    /**
     * @Then Object :object in namespace :namespace with attribute :attribute equal :value shouldn't exist in database
     */
    public function objectInNamespaceWithAttributeEqualShouldntExistInDatabase($object, $namespace, $attribute, $value)
    {
        $entity = $this->kernel->getContainer()->get('doctrine')
            ->getRepository("App\Entity\\$namespace\\$object")
            ->findOneBy(
                [
                    $attribute => $value
                ]
            );

        Assert::null($entity);
    }

    /**
     * @Then Object :object in namespace :namespace with the following data shouldn't exist in database
     */
    public function objectInNamespaceWithFollowingDataShouldntExistInDatabase($object, $namespace, TableNode $tableNode = null)
    {
        $entity = $this->kernel->getContainer()->get('doctrine')
            ->getRepository("App\Entity\\$namespace\\$object")
            ->findOneBy(array_column($tableNode->getHash(), 'value', 'attribute'));

        Assert::null($entity);
    }

    /**
     * @Then Object :object in namespace :namespace with the following data should exist in database
     */
    public function objectInNamespaceWithFollowingDataShouldExistInDatabase($object, $namespace, TableNode $tableNode = null)
    {
        $entity = $this->kernel->getContainer()->get('doctrine')
            ->getRepository("App\Entity\\$namespace\\$object")
            ->findOneBy(array_column($tableNode->getHash(), 'value', 'attribute'));

        Assert::notNull($entity);
    }

    /**
     * Restart auto increment
     * @throws \Doctrine\DBAL\Exception
     */
    private function resetAutoIncrement()
    {
        $this->entityManager->getConnection()->executeStatement('ALTER SEQUENCE contact_id_seq RESTART WITH 1');
        $this->entityManager->getConnection()->executeStatement('ALTER SEQUENCE observation_id_seq RESTART WITH 1');
        $this->entityManager->getConnection()->executeStatement('ALTER SEQUENCE post_id_seq RESTART WITH 1');
        $this->entityManager->getConnection()->executeStatement('ALTER SEQUENCE unit_id_seq RESTART WITH 1');
        $this->entityManager->getConnection()->executeStatement('ALTER SEQUENCE user_id_seq RESTART WITH 1');
        $this->entityManager->getConnection()->executeStatement('ALTER SEQUENCE weather_data_id_seq RESTART WITH 1');
        $this->entityManager->getConnection()->executeStatement('ALTER SEQUENCE weather_station_id_seq RESTART WITH 1');
    }
}

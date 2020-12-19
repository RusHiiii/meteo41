<?php

namespace Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

final class FixtureContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    public function __construct(
        KernelInterface $kernel
    ) {
        $this->kernel = $kernel;
    }

    /**
     * @Given I load the fixture :fixtureName
     */
    public function iLoadTheFixture($fixtureName)
    {
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
}

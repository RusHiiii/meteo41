<?php


namespace App\Tests\Integration\Factory;

use App\Core\Factory\UserFactory;
use App\Core\Tactician\Command\User\EditUserCommand;
use App\Core\Tactician\Command\User\RegisterUserCommand;
use App\Tests\TestCase;

class UserFactoryTest extends TestCase
{
    /**
     * @var UserFactory
     */
    private $userFactory;

    protected function setUp()
    {
        parent::setUp();
        $this->userFactory = self::$container->get(UserFactory::class);
    }

    public function testCreateUserFromCommand()
    {
        $command = new RegisterUserCommand('florent', 'ppatric', 'dezde@dee.fr', 'aa', 'aa', ['ROLE_USER']);
        $user = $this->userFactory->createUserFromCommand($command);

        $this->assertEquals('florent', $user->getFirstname());
        $this->assertEquals('ppatric', $user->getLastname());
        $this->assertEquals('dezde@dee.fr', $user->getEmail());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testEditUserFromCommand()
    {
        $entities = $this->loadFile('tests/.fixtures/contact.yml');

        $command = new EditUserCommand('florent', 'ppatric', '', 'aa', 'aa', ['ROLE_USER']);
        $user = $this->userFactory->editUserFromCommand($entities['user_1'], $command);

        $this->assertEquals('florent', $user->getFirstname());
        $this->assertEquals('ppatric', $user->getLastname());
        $this->assertEquals('admin@test.fr', $user->getEmail());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }
}
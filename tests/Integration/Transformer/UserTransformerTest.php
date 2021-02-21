<?php


namespace App\Tests\Integration\Transformer;


use App\Core\Transformer\UserTransformer;
use App\Entity\Core\ViewModels\User\UserView;
use App\Repository\Doctrine\UserRepository;
use App\Tests\TestCase;

class UserTransformerTest extends TestCase
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**.
     * @var UserTransformer
     */
    private $userTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->userTransformer = self::$container->get(UserTransformer::class);
        $this->userRepository = self::$container->get(UserRepository::class);
    }

    public function testTransformToView()
    {
        $entities = $this->loadFile('tests/.fixtures/user.yml');

        $userView = $this->userTransformer->transformUserToView($entities['user_1']);

        $this->assertInstanceOf(UserView::class, $userView);

        $this->assertEquals('1', $userView->getId());
        $this->assertEquals('florent', $userView->getFirstname());
        $this->assertEquals('damiens', $userView->getLastname());
        $this->assertNull($userView->getEmail());
        $this->assertNull($userView->getRoles());
    }
}
<?php


namespace App\Tests\Integration\Factory;

use App\Core\Factory\PostFactory;
use App\Core\Tactician\Command\Post\EditPostCommand;
use App\Core\Tactician\Command\Post\RegisterPostCommand;
use App\Repository\PostRepository;
use App\Tests\TestCase;

class PostFactoryTest extends TestCase
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var PostFactory
     */
    private $postFactory;

    protected function setUp()
    {
        parent::setUp();
        $this->postRepository = self::$container->get(PostRepository::class);
        $this->postFactory = self::$container->get(PostFactory::class);
    }

    public function testCreateContactFromCommand()
    {
        $entities = $this->loadFile('tests/.fixtures/user.yml');

        $command = new RegisterPostCommand('name', 'desc');
        $post = $this->postFactory->createPostFromCommand($command, $entities['user_1']);

        $this->assertEquals('name', $post->getName());
        $this->assertEquals('desc', $post->getDescription());
    }

    public function testEditPostFromCommand()
    {
        $entities = $this->loadFile('tests/.fixtures/post.yml');

        $command = new EditPostCommand('test', 'sdes');
        $post = $this->postFactory->editPostFromCommand($entities['post_1'], $command, $entities['user_1']);

        $this->assertEquals('test', $post->getName());
        $this->assertEquals('sdes', $post->getDescription());
    }
}
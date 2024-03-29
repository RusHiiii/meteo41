<?php


namespace App\Tests\Integration\Transformer;

use App\Core\Constant\Post\ApiSearch;
use App\Core\Transformer\PostTransformer;
use App\Entity\Core\ViewModels\Post\PostSearchView;
use App\Entity\Core\ViewModels\Post\PostView;
use App\Entity\Core\ViewModels\User\UserView;
use App\Repository\PostRepository;
use App\Tests\TestCase;

class PostTransformerTest extends TestCase
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var PostTransformer
     */
    private $postTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->postRepository = self::$container->get(PostRepository::class);
        $this->postTransformer = self::$container->get(PostTransformer::class);
    }

    public function testTransformToView()
    {
        $entities = $this->loadFile('tests/.fixtures/post.yml');

        $postView = $this->postTransformer->transformPostToView($entities['post_1']);

        $this->assertInstanceOf(PostView::class, $postView);
        $this->assertEquals('subject', $postView->getDescription());
        $this->assertEquals('nale', $postView->getName());

        $this->assertInstanceOf(UserView::class, $postView->getUser());
        $this->assertEquals('florent', $postView->getUser()->getFirstname());
        $this->assertEquals('damiens', $postView->getUser()->getLastname());
        $this->assertNull($postView->getUser()->getEmail());
        $this->assertNull($postView->getUser()->getRoles());
    }

    public function testTransformToSearchView()
    {
        $entities = $this->loadFile('tests/.fixtures/post.yml');

        $posts = $this->postRepository->findPaginatedPosts(
            [],
            ApiSearch::POST_ORDER_BY_ASC,
            1,
            10
        );

        $postView = $this->postTransformer->transformPostToSearchView($posts);

        $this->assertInstanceOf(PostSearchView::class, $postView);
        $this->assertEquals('1', $postView->getNumberOfResult());
        $this->assertEquals('nale', $postView->getPosts()[0]->getName());
        $this->assertInstanceOf(UserView::class, $postView->getPosts()[0]->getUser());
    }
}
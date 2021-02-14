<?php


namespace App\Tests\Integration\Repository;


use App\Core\Constant\Post\ApiSearch;
use App\Repository\Doctrine\PostRepository;
use App\Tests\TestCase;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PostRepositoryTest extends TestCase
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->postRepository = self::$container->get(PostRepository::class);
    }

    public function testFindPaginatedPostWithDefaultParams()
    {
        $this->loadFile('tests/.fixtures/post.yml');

        $posts = $this->postRepository->findPaginatedPosts(
            [],
            ApiSearch::POST_ORDER_BY_ASC,
            1,
            10
        );

        $this->assertInstanceOf(Paginator::class, $posts);
        $this->assertEquals(1, $posts->count());
    }

    public function testFindPaginatedPostWithSearchBy()
    {
        $this->loadFile('tests/.fixtures/post.yml');

        $posts = $this->postRepository->findPaginatedPosts(
            [
                ApiSearch::POST_SEARCH_BY_NAME => 'non',
            ],
            ApiSearch::POST_ORDER_BY_ASC,
            1,
            10
        );

        $this->assertInstanceOf(Paginator::class, $posts);
        $this->assertEquals(0, $posts->count());
    }

    public function testFindPaginatedPostWithSearchByUser()
    {
        $this->loadFile('tests/.fixtures/post.yml');

        $posts = $this->postRepository->findPaginatedPosts(
            [
                ApiSearch::POST_SEARCH_BY_USER => '1',
            ],
            ApiSearch::POST_ORDER_BY_ASC,
            1,
            10
        );

        $this->assertInstanceOf(Paginator::class, $posts);
        $this->assertEquals(1, $posts->count());
    }

}
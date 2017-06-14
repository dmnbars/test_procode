<?php
namespace App;

use App\Finder\BookFinder;
use App\Finder\ChapterFinder;
use App\Finder\LangFinder;
use App\Finder\PageFinder;
use App\Pagination\PagePagination;

require_once 'vendor/autoload.php';

$app = new Application();
$db = new DataBase('localhost', 'test_procode', 'root', '');
$app->register('db', $db);

$app->get('/', function ($app, $attributes, $params) {
    /**
     * @var Application $app
     * @var SessionInterface $session
     * @var DataBase $db
     */

    $db = $app->getService('db');
    $session = $app->getService('session');

    $langCode = $session->get('lang', 'ru');

    $bookFinder = new BookFinder($db);
    $books = $bookFinder->findAllByLang($langCode);

    $langFinder = new LangFinder($db);
    $languages = $langFinder->findAll();

    return new Response(
        Template::render(
            'index',
            [
                'books' => $books,
                'languages' => $languages,
            ]
        )
    );
});

$app->get('/book/:book_id', function ($app, $attributes, $params) {
    /**
     * @var Application $app
     */

    $bookFinder = new BookFinder($app->getService('db'));
    $book = $bookFinder->findOneById($attributes['book_id']);

    if (empty($book)) {
        return null;
    }

    $chapterFinder = new ChapterFinder($app->getService('db'));
    $chapters = $chapterFinder->findAllByBookId($attributes['book_id']);

    return new Response(
        Template::render(
            'book',
            [
                'book' => $book,
                'chapters' => $chapters,
            ]
        )
    );
});

$app->get('/book/:book_id/:page_number', function ($app, $attributes, $params) {
    /**
     * @var Application $app
     * @var DataBase $db
     */

    $db = $app->getService('db');

    $bookId = intval($attributes['book_id']);
    $pageNumber = intval($attributes['page_number']);

    $bookFinder = new BookFinder($db);
    $book = $bookFinder->findOneById($bookId);

    $pageFinder = new PageFinder($db);
    $page = $pageFinder->findOneByNumber($pageNumber);

    if (empty($page)) {
        return null;
    }

    $pageCount = $bookFinder->getPageCountByBook($bookId);

    $pagePagination = new PagePagination($pageCount, $pageNumber);

    return new Response(
        Template::render(
            'page',
            [
                'book' => $book,
                'page' => $page,
                'pagePagination' => $pagePagination,
            ]
        )
    );
});

$app->get('/lang/:lang_id', function ($app, $attributes, $params) {
    /**
     * @var Application $app
     * @var SessionInterface $session
     */

    $session = $app->getService('session');

    $finder = new LangFinder($app->getService('db'));
    $lang = $finder->findOneById($attributes['lang_id']);

    if (!empty($lang)) {
        $session->set('lang', $lang['id']);
    }

    $response = new Response();
    $response->redirect('/');

    return $response;
});

$app->run();

<?php

namespace Jen\ContentCMS;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;
/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ContentController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * @var object $contentData handles connection to database
     *
     */
    private $contentData;
    private $contentManager;


    public function initialize() : void
    {
        // $this->db = "active";
        $this->contentData = new Content($this->app->db);
        $this->contentManager = new ContentCUD($this->app->db);
    }

    /**
     *
     * handles contentcms/show
     *
     * @return object
     */
    public function showAction() : object
    {
        $title = "Content show all | oophp";
        $page = $this->app->page;

        $res = $this->contentData->showAll();

        $view[] = "content/show-all";
        $data = [
            "res" => $res
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     * handles contentcms/blog
     *
     * @return object
     */
    public function blogAction() : object
    {
        $title = "Show blog | oophp";
        $page = $this->app->page;

        $res = $this->contentData->showBlog();

        $view[] = "content/blog";
        $data = [
            "res" => $res
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     * handles contentcms/showblog/$id
     *
     * @return object
     */
    public function showBlogAction($pathOrSlug) : object
    {
        $title = "Show blogpost | oophp";
        $page = $this->app->page;

        $res = $this->contentData->showBlogPost($pathOrSlug);
        if (!$res) {
            return $this->pageNotFound();
        }

        $view[] = "content/blogpost";
        $data = [
            "res" => $res
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     * handles contentcms/pages
     *
     * @return object
     */
    public function pagesAction() : object
    {
        $title = "Show pages | oophp";
        $page = $this->app->page;

        $res = $this->contentData->showPages();

        $view[] = "content/pages";
        $data = [
            "res" => $res
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     * handles contentcms/showpage/$id
     *
     * @return object
     */
    public function showPageAction($pathOrSlug) : object
    {
        $title = "Show page | oophp";
        $page = $this->app->page;

        $res = $this->contentData->showPage($pathOrSlug);
        if (!$res) {
            return $this->pageNotFound();
        }

        $view[] = "content/page";
        $data = [
            "res" => $res
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     * handles contentcms/admin
     *
     * @return object
     */
    public function adminAction() : object
    {
        $title = "Admin | oophp";
        $page = $this->app->page;

        $res = $this->contentData->showAll();

        $view[] = "content/admin";
        $data = [
            "res" => $res
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     * handles contentcms/edit/$id
     *
     * @return object
     */
    public function editAction($contentId) : object
    {
        $title = "Edit content | oophp";
        $page = $this->app->page;

        $res = $this->contentData->showAllId($contentId);
        if (!$res) {
            return $this->pageNotFound();
        }

        $view[] = "content/edit";
        $data = [
            "res" => $res
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     * handles contentcms/edit/$id POST
     *
     * @return object
     */
    public function editActionPost($contentId)
    {
        $response = $this->app->response;
        if (hasKeyPost("doSave")) {
            return $this->updateContent($contentId);
        } elseif (hasKeyPost("doDelete")) {
            return $response->redirect("contentcms/delete . $contentId");
        }
        return $response->redirect("contentcms/edit/" . $contentId);
    }

    /**
     *
     * Update content
     *
     * @return object
     */
    public function updateContent($contentId) : object
    {
        $params = getPost([
            "contentTitle",
            "contentPath",
            "contentSlug",
            "contentData",
            "contentType",
            "contentFilter",
            "contentPublish",
            "contentId"
        ]);
        $contentData = $this->contentData;

        if ($contentData->slugExists($params["contentSlug"], $contentId) ||
            $contentData->pathExists($params["contentPath"], $contentId)) {
            return $this->app->response->redirect("contentcms/edit/" . $contentId);
        }
        $this->contentManager->updateContent($params);

        return $this->app->response->redirect("contentcms/edit/" . $contentId);
    }

    /**
     *
     * Delete content
     *
     * @return object
     */
    public function deleteAction($contentId)
    {
        $title = "Delete content | oophp";
        $page = $this->app->page;

        $res = $this->contentData->showTitelId($contentId);
        if (!$res) {
            return $this->pageNotFound();
        }

        $view[] = "content/delete";
        $data = [
            "res" => $res
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     * Delete content POST
     *
     * @return object
     */
    public function deleteActionPost($contentId) : object
    {
        if (hasKeyPost("doDelete")) {
            $this->contentManager->deleteContent($contentId);
        }
        return $this->app->response->redirect("contentcms/admin");
    }

    /**
     *
     * Create content
     *
     * @return object
     */
    public function createAction() : object
    {
        $title = "Create content | oophp";
        $page = $this->app->page;

        $view[] = "content/create";

        $this->addView($view);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     * Create content POST
     *
     * @return object
     */
    public function createActionPost() : object
    {
        if (hasKeyPost("doCreate")) {
            $title = getPost("contentTitle");
            $this->contentManager->createContent($title);
            $id = $this->app->db->lastInsertId();
        }
        return $this->app->response->redirect("contentcms/edit/" . $id);
    }


    /**
     *
     * Render page not found
     *
     * @return object
     */
    private function pageNotFound() : object
    {
        $title = "404";
        $page = $this->app->page;

        $view[] = "content/404";

        $this->addView($view);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Add views to render on site
     * Optional data to display
     *
     * @return void
     */
    private function addView($view, $data = null) : void
    {
        $page = $this->app->page;
        $page->add("content/header");

        if (null === $data) {
            $data = [];
        }

        foreach ($view as $value) {
            $page->add($value, $data);
        }
    }
}

<?php

namespace Jen\MyTextFilter;

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
class TextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function bbcodeAction() : object
    {
        $title = "Textfilter bbcode | oophp";
        $page = $this->app->page;

        $filter = new MyTextFilter();

        $text = file_get_contents(__DIR__ . "/bbcode.txt");
        $html = $filter->parse($text, ["bbcode"]);
        $htmlnl2br = $filter->parse($text, ["bbcode", "nl2br"]);


        $view[] = "textfilter/bbcode";
        $data = [
            "text" => $text,
            "output" => $html,
            "html" => $filter->esc($html),
            "htmlnl2br" => $htmlnl2br
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function clickableAction() : object
    {
        $title = "Textfilter bbcode | oophp";
        $page = $this->app->page;

        $filter = new MyTextFilter();

        $text = file_get_contents(__DIR__ . "/clickable.txt");
        $html = $filter->parse($text, ["link"]);

        $view[] = "textfilter/clickable";
        $data = [
            "text" => $text,
            "html" => $filter->esc($html),
            "output" => $html
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function markdownAction() : object
    {
        $title = "Textfilter markdown | oophp";
        $page = $this->app->page;

        $filter = new MyTextFilter();

        $text = file_get_contents(__DIR__ . "/markdown.md");
        $html = $filter->parse($text, ["markdown"]);

        $view[] = "textfilter/markdown";
        $data = [
            "text" => $text,
            "html" => $filter->esc($html),
            "output" => $html
        ];

        $this->addView($view, $data);

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
        $page->add("textfilter/header");

        if (null === $data) {
            $data = [];
        }

        foreach ($view as $value) {
            $page->add($value, $data);
        }
    }
}

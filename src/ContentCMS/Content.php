<?php

namespace Jen\ContentCMS;

/**
 *
 * Access and read from database
 *
 *
 */
class Content
{
    /**
     *  $ contentDB database that handles content data
     */
    private $contentDB;

    /**
     * Constructor to access database.
     *
     */
    public function __construct($database)
    {
        $db = $database;
        $this->contentDB = $db;
        $this->contentDB->connect();
    }

    /**
     * Return all from content
     *
     * @return array consisting results from database.
     */
    public function showAll() : array
    {

        $sql = "SELECT * FROM content";
        $res = $this->contentDB->executeFetchAll($sql);
        return $res;
    }

    /**
     * Return all from content
     * Based on $id
     *
     * @return object consisting results from database.
     */
    public function showAllId($id) : object
    {

        $sql = "SELECT * FROM content WHERE id = ?;";
        $res = $this->contentDB->executeFetch($sql, [$id]);
        return $res;
    }

    /**
     * Return title and id
     * Based on $id
     *
     *
     */
    public function showTitelId($id)
    {
        $sql = "SELECT id, title FROM content WHERE id = ?;";
        $res = $this->contentDB->executeFetch($sql, [$id]);
        return $res;
    }

    /**
     * Return results based on content-type
     *
     * @return array consisting results from database.
     */
    public function showBlog() : array
    {

        $sql = <<<EOD
    SELECT
        *,
        CASE
            WHEN (deleted <= NOW()) THEN "isDeleted"
            WHEN (published <= NOW()) THEN "isPublished"
            ELSE "notPublished"
        END AS status,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
    FROM content
    WHERE type=?
    ORDER BY published DESC
;
EOD;
        $res = $this->contentDB->executeFetchAll($sql, ["post"]);
        return $this->filterText($res);
    }

    /**
     *  Return blogpost based on path or slug
     *
     * @return object consisting results from database.
     */
    public function showBlogPost($pathOrSlug) : object
    {

        $sql = <<<EOD
    SELECT
        *,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
    FROM content
    WHERE
        slug = ?
        OR path = ?
        AND type = ?
        AND (deleted IS NULL OR deleted > NOW())
        AND published <= NOW()
    ORDER BY published DESC
;
EOD;
        $res = $this->contentDB->executeFetchAll($sql, [$pathOrSlug, $pathOrSlug, "post"]);
        return $this->filterText($res)[0];
    }

    /**
     *  Return all pages from database
     *
     * @return array consisting results from database.
     */
    public function showPages() : array
    {
            $sql = <<<EOD
    SELECT
        *,
        CASE
            WHEN (deleted <= NOW()) THEN "isDeleted"
            WHEN (published <= NOW()) THEN "isPublished"
            ELSE "notPublished"
        END AS status
    FROM content
    WHERE type=?
    ;
EOD;
        $res = $this->contentDB->executeFetchAll($sql, ["page"]);
        return $res;
    }

    /**
     *  Return page based on path or slug
     *
     * @return
     */
    public function showPage($pathOrSlug)
    {
        $sql = <<<EOD
    SELECT
        *,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
    FROM content
    WHERE
        (path = ?
        OR slug = ?)
        AND type = ?
        AND (deleted IS NULL OR deleted > NOW())
        AND published <= NOW()
    ;
EOD;
        $res = $this->contentDB->executeFetchAll($sql, [$pathOrSlug, $pathOrSlug, "page"]);
        if ($res) {
            return $this->filterText($res)[0];
        }
        return $res;
    }

    /**
     *  Check if slug exists in another content
     *
     * @return bool
     */
    public function slugExists($slug, $id) : bool
    {
        $sql = <<<EOD
    SELECT EXISTS(
         SELECT *
         FROM content
         WHERE
         slug = ?
         AND id <> ?) AS 'exists'
EOD;
        $res = $this->contentDB->executeFetch($sql, [$slug, $id]);
        $resArray = get_object_vars($res);
        return $resArray['exists'] == 1;
    }

    /**
     *  Check if path exists in another content
     *
     * @return bool
     */
    public function pathExists($path, $id) : bool
    {
        $sql = <<<EOD
    SELECT EXISTS(
         SELECT *
         FROM content
         WHERE
         path = ?
         AND id <> ?) as 'exists'
EOD;
        $res = $this->contentDB->executeFetch($sql, [$path, $id]);
        $resArray = get_object_vars($res);
        return $resArray['exists'] == 1;
    }

    /**
     *  Filter text based on users choice if filter
     *
     * @return array
     */
    private function filterText($textArray) : array
    {
        foreach ($textArray as $text) {
                $filter = new \Jen\MyTextFilter\MyTextFilter();
                $filters = explode(",", $text->filter);
                $filteredText = $filter->parse(htmlentities($text->data), $filters);
                $text->data = $filteredText;
        }

        return $textArray;
    }
}

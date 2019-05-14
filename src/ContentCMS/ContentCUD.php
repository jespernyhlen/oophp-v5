<?php

namespace Jen\ContentCMS;

/**
 *
 * Using Create, update and delete on database
 *
 *
 */
class ContentCUD extends Content
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
     *  Update content in database
     *
     * @return void
     */
    public function updateContent($params) : void
    {
        if (!$params["contentSlug"]) {
            $params["contentSlug"] = slugify($params["contentTitle"]);
        }

        if (!$params["contentPath"]) {
            $params["contentPath"] = null;
        }

        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $this->contentDB->execute($sql, array_values($params));
    }

    /**
     *  Update content in database
     *
     * @return void
     */
    public function deleteContent($id) : void
    {
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $this->contentDB->execute($sql, [$id]);
    }

    /**
     *  Create content in database
     *
     * @return void
     */
    public function createContent($title) : void
    {
        $sql = "INSERT INTO content (title) VALUES (?);";
        $this->contentDB->execute($sql, [$title]);
    }
}

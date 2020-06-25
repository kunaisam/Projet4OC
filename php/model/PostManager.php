<?php

/**
 * Fichier contenant le modèle de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 16.04.2020
 */

class PostManager extends Manager
{
    public function getPosts()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM article');

        return $req;
    }

    public function getIndexPosts()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM article ORDER BY id DESC LIMIT 0, 3');

        return $req;
    }

    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM article WHERE id = ?');
        $req->execute(array($postId));

        return $req;
    }

    public function getComments($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT comment.date, comment.content, user.username FROM comment, user WHERE comment.articles_id = ? AND comment.user_id = user.id');
        $req->execute(array($postId));

        return $req;
    }

    public function postComment($postId, $userId, $comment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO comment(articles_id, user_id, comment.date, content) VALUES(?, ?, NOW(), ?)');
        $req->execute(array(
            'articles_id' => $postId,
            'user_id' => $userId, 
            'content' => $comment
        ));

        return $req;
    }
}
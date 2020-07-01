<?php

/**
 * Fichier contenant le modèle de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 16.04.2020
 */


/**
 * Classe Postmanager
 *
 * Classe contenant le modèle de gestion des articles de blog
 */
class PostManager extends Manager
{
    /**
     * Méthode permettant d'appeler des articles de blog dans la base de données et d'incorporer leur valeurs dans des instances de la classe Article
     *
     */
    public function getPosts()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM article');

        return $req;
    }

    /**
     * Méthode permettant d'appeler les trois derniers articles de blog dans la base de données et d'incorporer leur valeurs dans des instances de la classe Article
     *
     */
    public function getIndexPosts()
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
        // Requête SQL pour récupérer les données des 3 derniers articles
        $req = $db->query('SELECT * FROM article ORDER BY id DESC LIMIT 0, 3');

        // Contiendra toutes les instances d'articles dans un tableau
        $listPosts = array();
        // PDO::FETCH_ASSOC renvoie les valeurs sous forme d'un tableau associatif.
        while ($result_array = $req->fetchAll(PDO::FETCH_ASSOC)) {
            // Liste chaque article en fonction de son id
            for ($value = 0; $value < 3; $value++) {
                // Renvoie les données de l'article sélectionné dans la variable $articleData
                $articleData = $result_array[$value];
                // Création d'une instance de la classe Article avec les valeurs contenues dans $articleData
                $article = new Article($articleData);
                // Retourne la nouvelle instance $article dans le tableau $listposts.
                array_push($listPosts, $article);
            }
        }
        $req->closeCursor();

        return $listPosts;
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
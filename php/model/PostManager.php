<?php

/**
 * Fichier contenant le modèle de gestion des articles de blog de l'application
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
        // Connexion à la base de données
        $db = $this->dbConnect();
        // Requête SQL pour récupérer toutes les données des articles
        $req = $db->query('SELECT * FROM article');

        // Contiendra toutes les instances d'articles dans un tableau
        $listPosts = array();
        // PDO::FETCH_ASSOC renvoie les valeurs sous forme d'un tableau associatif.
        while ($result_array = $req->fetchAll(PDO::FETCH_ASSOC)) {
            // renvoie la clé correspondante à l'id de l'article
            $result_array_id = array_search('id', $result_array);
            // Liste chaque article en fonction de son id
            foreach ($result_array as $result_array_id => $value) {
                // Renvoie les données de l'article sélectionné dans la variable $articleData
                $articleData = $result_array[$result_array_id];
                // Création d'une instance de la classe Article avec les valeurs contenues dans $articleData
                $article = new Article($articleData);
                // Retourne la nouvelle instance $article dans le tableau $listposts.
                array_push($listPosts, $article);
            }
        }
        $req->closeCursor();

        return $listPosts;
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

    /**
     * Méthode permettant d'appeler l'article de blog sélectionné dans la base de données et d'incorporer ses valeurs dans une instance de la classe Article
     *
     * @param Integer $postId contient l'identifiant du post sélectionné
     */
    public function getPost($postId)
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
        // Requête SQL pour récupérer les données de l'article sélectionné via son id
        $req = $db->prepare('SELECT * FROM article WHERE id = ?');
        // Envoi du paramètre $postId à la requête pour sélectionner le bon article
        $req->execute(array($postId));
        // PDO::FETCH_ASSOC renvoie les valeurs sous forme d'un tableau associatif.
        $result_array = $req->fetchAll(PDO::FETCH_ASSOC);
        // Vérifie si la variable $result_array est vide
        if (empty($result_array)) {
            return null;
        }
        // Renvoie les données de l'article sélectionné dans la variable $articleData
        $articleData = $result_array[0];
        // Création d'une instance de la classe Article avec les valeurs contenues dans $articleData
        $article = new Article($articleData);

        return $article;
    }

    /**
     * Méthode permettant de supprimer un article
     *
     * @param Integer $idPost contient l'identifiant de l'article sélectionné
     */
    public function deletePost($idPost)
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
        // Création d'un objet Article avec ses données dans un tableau
        $postInstance = new Article([
            'id' => $idPost
        ]);
        // Attribution de l'id de l'article à la variable $id
        $id = $postInstance->getId();

        // Requête SQL pour supprimer l'article
        $req = $db->prepare('DELETE FROM article WHERE id = :id');
        // Attribution des variables à la requête
        $req->execute(array(
            'id' => $id
        ));
    }
}
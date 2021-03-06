<?php

/**
 * Fichier contenant le modèle de gestion des commentaires de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 01.07.2020
 */


/**
 * Classe CommentManager
 *
 * Classe contenant le modèle de gestion des commentaires
 */
class CommentManager extends Manager
{
    /**
     * Méthode permettant d'appeler les commentaires sélectionnés dans la base de données et d'incorporer leurs valeurs dans des instances de la classe Comment
     *
     * @param Integer $postId contient l'identifiant du post sélectionné
     */
    public function getComments($postId)
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
        // Requête SQL pour récupérer les données des commentaires sélectionnés
        $req = $db->prepare('SELECT comment.id, comment.date, comment.content, comment.user_id FROM comment WHERE comment.articles_id = ?');
        // Envoi du paramètre $postId à la requête pour sélectionner les bons commentaires
        $req->execute(array($postId));

        // Contiendra toutes les instances de commentaires dans un tableau
        $listComments = array();
        // PDO::FETCH_ASSOC renvoie les valeurs sous forme d'un tableau associatif.
        while ($result_array = $req->fetchAll(PDO::FETCH_ASSOC)) {
            // renvoie la clé correspondante à l'id du commentaire
            $result_array_id = array_search('comment.id', $result_array);
            // Liste chaque commentaire en fonction de son id
            foreach ($result_array as $result_array_id => $value) {
                // Renvoie les données du commentaire sélectionné dans la variable $commentData
                $commentData = $result_array[$result_array_id];
                // Création d'une instance de la classe Comment avec les valeurs contenues dans $commentData
                $comment = new Comment($commentData);
                // Instancie une classe User à partir de l'identifiant de la personne ayant commenté
                $user = UserManager::getUserManager()->getUserById($commentData["user_id"]);
                // Intégration de l'id du post dans l'instance Comment
                $comment->setArticles($postId);
                // Intégration de l'instance User dans l'instance Comment
                $comment->setUser($user);
                // Retourne la nouvelle instance $comment dans le tableau $listComments.
                array_push($listComments, $comment);
            }
        }
        $req->closeCursor();

        return $listComments;
    }

    /**
     * Méthode permettant de signaler les commentaires
     *
     * @param Integer $id contient l'identifiant du commentaire sélectionné
     */
    public function reportComment($id)
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
        // Création d'un objet Comment avec ses données dans un tableau
        $commentInstance = new Comment([
            'id' => $id,
            'reported' => 2
        ]);
        // Attribution de l'id du commentaire à la variable $idComment
        $idComment = $commentInstance->getId();
        // Attribution du signalement du commentaire à la variable $reported
        $reported = $commentInstance->getReported();

        // Requête SQL pour mettre à jour le signalement du commmentaire
        $req = $db->prepare('UPDATE comment SET reported = :reported WHERE id = :id');
        // Attribution des variables à la requête
        $req->execute(array(
            'id' => $idComment,
            'reported' => $reported
        ));
    }

    /**
     * Méthode permettant d'appeler les commentaires signalés dans la base de données et d'incorporer leurs valeurs dans des instances de la classe Comment
     *
     */
    public function getReportedComments()
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
        // Requête SQL pour récupérer les données des commentaires sélectionnés
        $req = $db->query('SELECT * FROM comment WHERE reported = 2');
        // Contiendra toutes les instances de commentaires dans un tableau
        $listComments = array();
        // PDO::FETCH_ASSOC renvoie les valeurs sous forme d'un tableau associatif.
        while ($result_array = $req->fetchAll(PDO::FETCH_ASSOC)) {
            // renvoie la clé correspondante à l'id du commentaire
            $result_array_id = array_search('comment.id', $result_array);
            // Liste chaque commentaire en fonction de son id
            foreach ($result_array as $result_array_id => $value) {
                // Renvoie les données du commentaire sélectionné dans la variable $commentData
                $commentData = $result_array[$result_array_id];
                // Création d'une instance de la classe Comment avec les valeurs contenues dans $commentData
                $comment = new Comment($commentData);
                // Instancie une classe User à partir de l'identifiant de la personne ayant commenté
                $user = UserManager::getUserManager()->getUserById($commentData["user_id"]);
                // Intégration de l'instance User dans l'instance Comment
                $comment->setUser($user);
                // Retourne la nouvelle instance $comment dans le tableau $listComments.
                array_push($listComments, $comment);
            }
        }
        $req->closeCursor();

        return $listComments;
    }

    /**
     * Méthode permettant de normaliser les commentaires signalés
     *
     * @param Integer $id contient l'identifiant du commentaire sélectionné
     */
    public function normaliseComment($id)
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
        // Création d'un objet Comment avec ses données dans un tableau
        $commentInstance = new Comment([
            'id' => $id,
            'reported' => 1
        ]);
        // Attribution de l'id du commentaire à la variable $idComment
        $idComment = $commentInstance->getId();
        // Attribution du signalement normalisé du commentaire à la variable $reported
        $reported = $commentInstance->getReported();

        // Requête SQL pour mettre à jour le signalement normalisé du commmentaire
        $req = $db->prepare('UPDATE comment SET reported = :reported WHERE id = :id');
        // Attribution des variables à la requête
        $req->execute(array(
            'id' => $idComment,
            'reported' => $reported
        ));
    }

    /**
     * Méthode permettant de supprimer les commentaires signalés
     *
     * @param Integer $id contient l'identifiant du commentaire sélectionné
     */
    public function deleteComment($id)
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
        // Création d'un objet Comment avec ses données dans un tableau
        $commentInstance = new Comment([
            'id' => $id
        ]);
        // Attribution de l'id du commentaire à la variable $idComment
        $idComment = $commentInstance->getId();

        // Requête SQL pour supprimer le commmentaire signalé
        $req = $db->prepare('DELETE FROM comment WHERE id = :id');
        // Attribution des variables à la requête
        $req->execute(array(
            'id' => $idComment
        ));
    }

    /**
     * Méthode permettant de créer un commentaire et de l'incorporer dans la base de données
     *
     * @param Object $commentInstance contient l'instance du commentaire qui va être ajouté en base de données
     */
    public function postComment(Comment $commentInstance)
    {
        try {
            // Connexion à la base de données
            $db = $this->dbConnect();
            // Requête SQL INSERT INTO pour ajouter le nouveau commentaire à la base de données
            $req = $db->prepare('INSERT INTO comment(articles_id, user_id, comment.date, content, reported) VALUES(:articles_id, :user_id, NOW(), :content, :reported)');
            
            // Création de variables avec les valeurs de l'objet Comment
            $articles_id = $commentInstance->getArticles();
            $user_id = $commentInstance->getUser();
            $content = $commentInstance->getContent();
            $reported = $commentInstance->getReported();

            // Ajout des données du commentaire à la base de données
            $req->bindParam('articles_id', $articles_id, PDO::PARAM_INT);
            $req->bindParam('user_id', $user_id, PDO::PARAM_INT);
            $req->bindParam('content', $content, PDO::PARAM_STR);
            $req->bindParam('reported', $reported, PDO::PARAM_INT);
            $res = $req->execute();
        }
        catch (Exception $e) {
            die($e);
        }

        return $req;
    }
}
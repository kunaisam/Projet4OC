<?php

/**
 * Fichier contenant le modèle de gestion des commentaires de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 01.07.2020
 */


/**
 * Classe Commentmanager
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
                $user = UserManager::getUserManager()->getUserById($commentData["user_id"]);
                $comment->setUser($user);
                // Retourne la nouvelle instance $comment dans le tableau $listComments.
                array_push($listComments, $comment);
            }
        }
        $req->closeCursor();

        return $listComments;
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
<?php

/**
 * Fichier contenant le contrôleur des commentaires de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 01.07.2020
 */

/**
 * Classe CommentController
 *
 * Classe contenant le contrôleur des commentaires de l'application
 */
class CommentController
{
	/**
     * Méthode permettant d'appeler l'article de blog sélectionné à partir du PostManager et d'envoyer ses valeurs au routeur
     *
     * @param Integer $id contient l'identifiant du post sélectionné
     */
	public function comments($id)
	{
		// Création d'un objet $commentManager
		$commentManager = new CommentManager();
		// Appel de la fonction getComments() de cet objet avec l'identifiant du post en paramètre
		$comments = $commentManager->getComments($id);

		return $comments;
	}

	public function addComment($postId, $userId, $comment)
	{
		$commentManager = new CommentManager();
		$comment = $commentManager->postComment($postId, $userId, $comment);

		return $comment;
	}
}
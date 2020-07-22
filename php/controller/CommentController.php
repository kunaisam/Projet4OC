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
     * Méthode permettant de vérifier si un commentaire a bien été sélectionné
     *
     */
	public function issetIdComment()
	{
		// Opérateur ternaire : vérifie si une valeur TAG_IDCOMMENT est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idComment
        $idComment = isset($_POST[TAG_IDCOMMENT]) ? $_POST[TAG_IDCOMMENT] : (isset($_GET[TAG_IDCOMMENT]) ? $_GET[TAG_IDCOMMENT] : null);

	    return $idComment;
	}

	/**
     * Méthode permettant d'appeler les commentaires sélectionnés à partir du CommentManager et d'envoyer ses valeurs au routeur
     *
     * @param Integer $id contient l'identifiant du post sélectionné
     */
	public function getComments($id)
	{
		// Création d'un objet $commentManager
		$commentManager = new CommentManager();
		// Appel de la fonction getComments() de cet objet avec l'identifiant du post en paramètre
		$comments = $commentManager->getComments($id);

		return $comments;
	}

	/**
     * Méthode permettant de signaler les commentaires
     *
     * @param Integer $id contient l'identifiant du commentaire sélectionné
     */
	public function reportComment($id)
	{
		// Création d'un objet $commentManager
		$commentManager = new CommentManager();
		// Appel de la fonction reportComment() de cet objet avec l'identifiant du commentaire en paramètre
		$comment = $commentManager->reportComment($id);

		return $comment;
	}

	/**
     * Méthode permettant d'appeler les commentaires signalés sélectionnés à partir du CommentManager et d'envoyer ses valeurs au routeur
     *
     */
	public function getReportedComments()
	{
		// Création d'un objet $commentManager
		$commentManager = new CommentManager();
		// Appel de la fonction getReportedComments() de cet objet
		$comments = $commentManager->getReportedComments();

		return $comments;
	}

	/**
     * Méthode permettant de nomaliser les commentaires signalés
     *
     * @param Integer $id contient l'identifiant du commentaire sélectionné
     */
	public function normaliseComment($id)
	{
		// Création d'un objet $commentManager
		$commentManager = new CommentManager();
		// Appel de la fonction normaliseComment() de cet objet avec l'identifiant du commentaire en paramètre
		$comment = $commentManager->normaliseComment($id);

		return $comment;
	}

	/**
     * Méthode permettant de nomaliser les commentaires signalés
     *
     * @param Integer $id contient l'identifiant du commentaire sélectionné
     */
	public function deleteComment($id)
	{
		// Création d'un objet $commentManager
		$commentManager = new CommentManager();
		// Appel de la fonction deleteComment() de cet objet avec l'identifiant du commentaire en paramètre
		$comment = $commentManager->deleteComment($id);

		return $comment;
	}

	/**
     * Méthode permettant d'ajouter un commentaire à partir du CommentManager
     *
     * @param Integer $postId contient l'identifiant du post sélectionné
     */
	public function addComment($postId)
	{
		// Récupère le commentaire posté
        $comment = $_POST['comment'];
		// Vérifie si les champs ont été correctement remplis
		if (!empty($postId) && !empty($comment)) {
			// Création d'un objet Comment avec ses données dans un tableau
			$commentInstance = new Comment([
				'articles' => $postId,
	            'user' => $_SESSION['userId'], 
	            'content' => $comment,
	            'reported' => 1
			]);
			// Création d'un objet CommentManager
			$commentManager = new CommentManager();
			// Création d'un nouveau commentaire avec la méthode postComment et l'objet $commentInstance en paramètre
			$commentInstancePost = $commentManager->postComment($commentInstance);

			return $commentInstancePost;
		}
		else {
			return NULL;
		}
	}
}
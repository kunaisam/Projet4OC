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
     * Méthode permettant d'appeler les commentaires sélectionnés à partir du CommentManager et d'envoyer ses valeurs au routeur
     *
     * @param Integer $id contient l'identifiant du post sélectionné
     */
	public function getCommentsFromPost($idPost)
	{
		// Création d'un objet $commentManager
		$commentManager = new CommentManager();
		// Appel de la fonction getComments() de cet objet avec l'identifiant du post en paramètre
		$comments = $commentManager->getComments($idPost);

		return $comments;
	}

	/**
     * Méthode permettant de signaler les commentaires
     *
     * @param Integer $id contient l'identifiant du commentaire sélectionné
     * @param Boolean $isSessionActive vérifie si une session est active
     */
	public function reportComment($id, $isSessionActive)
	{
		// Création d'un objet $commentManager
		$commentManager = new CommentManager();
		$postController = new PostController();
		$commentController = new CommentController();
		// Appel de la fonction reportComment() de cet objet avec l'identifiant du commentaire en paramètre
		if ($commentManager->reportComment($id)) {
			$comment = $commentController->getCommentById($id);
			// Création de l'objet Post dans la variable $post
			$post = $postController->getPostById($comment->getArticles()); // il faudrait renommer getArticles en getArticle
			// Création d'objets Comment dans la variable $comments
			$comments = $post->getComments();
			// Vérifie si une session est active
			if ($isSessionActive) {
				// Affiche le post, ses commentaires et si la session est active, affiche la possibilité d'ajouter un commentaire. Affiche un message disant que le commentaire a été signalé.
				$ViewController->render(['postView', 'reportCommentSuccessView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $post->getId()]);
			}
			else {
				// Affiche seulement le post et ses commentaires. Affiche un message disant que le commentaire a été signalé.
				$ViewController->render(['postView', 'reportCommentSuccessView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $post->getId()]);
			}
		}
	}

	/**
     * Méthode permettant de sélectionner un commentaire
     *
     * @param Integer $idComment contient l'identifiant du commentaire
     */
	public function getCommentById($idComment)
	{
		// Création d'un objet $commentManager
		$commentManager = new CommentManager();
		// Appel de la fonction getComment() de cet objet avec l'identifiant du post en paramètre
		$comment = $commentManager->getComment($idComment);

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
     * Méthode permettant de créer un commentaire à partir du CommentManager
     *
     * @param Integer $postId contient l'identifiant du post sélectionné
     * @param String $comment contient le commentaire envoyé par l'utilisateur
     * @param Integer $userId contient l'identifiant de l'utilisateur qui envoie le commentaire
     */
	public function createComment($postId, $comment, $userId)
	{
		// Création d'un objet Comment avec ses données dans un tableau
		$commentInstance = new Comment([
			'articles' => $postId,
			'user' => $userId,
			'content' => $comment,
			'reported' => 1
		]);
		// Création d'un objet CommentManager
		$commentManager = new CommentManager();
		// Création d'un nouveau commentaire avec la méthode postComment et l'objet $commentInstance en paramètre
		if ($commentManager->postComment($commentInstance)) {
			return $commentInstance;
		}
		else {
			return null;
		}
	}
}
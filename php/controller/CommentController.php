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
	public function comments($id)
	{
		$commentManager = new CommentManager();
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
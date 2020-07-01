<?php

/**
 * Fichier contenant le contrôleur principal de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 24.06.2020
 */

/**
 * Classe Controller
 *
 * Classe contenant le contrôleur principal de l'application
 */
class Controller
{
	/**
     * Méthode permettant d'appeler les trois derniers articles de blog à partir du PostManager et d'envoyer leurs valeurs au routeur
     *
     */
	public function indexListPosts()
	{
		// Création d'un objet $postManager
	    $postManager = new PostManager();
	    // Appel de la fonction getIndexPosts() de cet objet
	    $posts = $postManager->getIndexPosts();

	    return $posts;
	}

	public function articleListPosts()
	{
	    $postManager = new PostManager(); // Création d'un objet
	    $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet

	    return $posts;
	}

	public function post($id)
	{
		$postManager = new PostManager();
	    $post = $postManager->getPost($id);

	    return $post;
	}

	public function comments($id)
	{
		$postManager = new PostManager();
		$comments = $postManager->getComments($id);

		return $comments;
	}

	public function addComment($postId, $userId, $comment)
	{
		$postManager = new PostManager();
		$comment = $postManager->postComment($postId, $userId, $comment);

		return $comment;
	}
}
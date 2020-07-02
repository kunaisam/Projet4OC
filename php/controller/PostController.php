<?php

/**
 * Fichier contenant le contrôleur des articles de blog de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 01.07.2020
 */

/**
 * Classe PostController
 *
 * Classe contenant le contrôleur des articles de blog de l'application
 */
class PostController
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

	/**
     * Méthode permettant d'appeler tous les articles de blog à partir du PostManager et d'envoyer leurs valeurs au routeur
     *
     */
	public function articleListPosts()
	{
		// Création d'un objet $postManager
	    $postManager = new PostManager();
	    // Appel de la fonction getPosts() de cet objet
	    $posts = $postManager->getPosts();

	    return $posts;
	}

	/**
     * Méthode permettant d'appeler l'article de blog sélectionné à partir du PostManager et d'envoyer ses valeurs au routeur
     *
     * @param Integer $id contient l'identifiant du post sélectionné
     */
	public function post($id)
	{
		// Création d'un objet $postManager
		$postManager = new PostManager();
		// Appel de la fonction getPost() de cet objet avec l'identifiant du post en paramètre
	    $post = $postManager->getPost($id);

	    return $post;
	}
}
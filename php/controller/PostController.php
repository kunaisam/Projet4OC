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
}
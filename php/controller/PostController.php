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

	/**
	 * Méthode permettant de créer un utilisateur via la classe User
	 *
	 * @param String $title contient la valeur entrée par l'administrateur dans la partie Titre
	 * @param String $myTextArea contient la valeur entrée par l'utilisateur dans la partie Contenu (interface Wysiwyg)
	 */
	public function createNewPost($title, $myTextArea)
	{
		// Vérifie si le formulaire de création d'article a été correctement rempli
		if (!empty($title) && !empty($myTextArea)) {
			// Création d'une instance UserManager
			$user = new UserManager;
			// Récupérantion d'une instance d'utilisateur
			$userData = $user->getUserById(1);
			// Récupération de l'identifiant de l'utilisateur
			$userId = $userData->getId();
			// Création d'un objet Article avec ses données dans un tableau
			$article = new Article([
				'title' => $title,
	            'content' => $myTextArea, 
	            'user' => $userId
			]);
			// Création d'un objet PostManager
			$postManager = new PostManager();
			// Création d'un nouvel article avec la méthode createNewPost du Postmanager et l'objet $article en paramètres
			$newPost = $postManager->createNewPost($article);

			return $newPost;
		}
		else {
			return NULL;
		}
	}

	/**
     * Méthode permettant de modifier des articles
     *
     * @param Integer $idPost contient l'identifiant de l'article sélectionné
     * @param String $title contient la valeur entrée par l'administrateur dans la partie Titre
	 * @param String $myTextArea contient la valeur entrée par l'utilisateur dans la partie Contenu (interface Wysiwyg)
     */
	public function updatePost($idPost, $title, $myTextArea)
	{
		// Vérifie si le formulaire de modifiaction d'article a été correctement rempli
		if (!empty($title) && !empty($myTextArea)) {
			// Création d'un objet $postManager
			$postManager = new PostManager();
			// Appel de la fonction updatePost() de cet objet avec l'identifiant, le titre et le texte de l'article en paramètres
			$post = $postManager->updatePost($idPost, $title, $myTextArea);

			return $post;
		}
		else {
			return NULL;
		}
	}

	/**
     * Méthode permettant de supprimer l'article de blog sélectionné à partir du PostManager
     *
     * @param Integer $idPost contient l'identifiant du post sélectionné
     */
	public function deletePost($idPost)
	{
		// Instanciation d'un CommentController
		$commentController = new CommentController();
		// Création d'objets Comment dans la variable $comments
        $comments = $commentController->getComments($idPost);
        // Supression de chaque commentaire de l'article
        foreach ($comments as $key => $value) {
        	$commentController->deleteComment($value->getId());
        }
		// Création d'un objet $postManager
		$postManager = new PostManager();
		// Appel de la fonction deletePost() de cet objet avec l'identifiant du post en paramètre
	    $post = $postManager->deletePost($idPost);

	    return $post;
	}
}
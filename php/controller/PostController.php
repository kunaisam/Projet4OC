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
     * @param Integer $idPost contient l'identifiant du post sélectionné
     */
	public function getPostById($idPost)
	{
		// Création d'un objet $postManager
		$postManager = new PostManager();
		// Appel de la fonction getPost() de cet objet avec l'identifiant du post en paramètre 
		$post = $postManager->getPost($idPost);
		// à ce moment là, le champ $_user de la classe Article contient seulement la valeur numérique, id de l’utilisateur
		$user = UserManager::getUserManager()->getUserById($post->getUser());
		// On réinjecte l’objet User dans l’objet $post
		$post->setUser($user);

		return $post;
	}

	/**
     * Méthode permettant d'ajouter un commentaire à une publication
     *
     * @param Integer $postId contient l'identifiant du post sélectionné
     * @param String $comment contient le commentaire à ajouter
     * @param Integer $idUser contient l'identifiant de l'utilisateur sélectionné
     */	
	public function addComment($postId, $comment, $idUser)
	{
		$commentController = new CommentController();
		$postController = new PostController();
		$viewController = new ViewController();
		// Envoi du commentaire au CommentController
		$newComment = $commentController->createComment($idPost, $comment, $idUser);
		// Création de l'objet Post dans la variable $post
		$post = $postController->getPostById($idPost);
		// Récupération des commentaires du post
		$comments = $post->getComments($idPost);
		// Si le nouveau commentaire ne vaut pas NULL
		if (!empty($newComment)) {
			// Affiche le post, ses commentaires et affiche la possibilité d'ajouter un commentaire
			$ViewController->render(['postView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
		}
		else {
	        // Affiche le post, ses commentaires, le message d'échec d'envoi du commentaire et affiche la possibilité d'ajouter un commentaire
	        $ViewController->render(['postView', 'addCommentFailedView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
	    }               
	}

	/**
     * Méthode permettant de supprimer l'article de blog sélectionné à partir du PostManager
     *
     * @param Integer $idPost contient l'identifiant du post sélectionné
     */
	public function deletePost($idPost)
	{
		// Création d'un objet $postManager
		$postManager = new PostManager();
		// Appel de la fonction deletePost() de cet objet avec l'identifiant du post en paramètre
	    $post = $postManager->deletePost($idPost);

	    return $post;
	}

	public function displayPost($idPost, $isActiveSession)
	{
		$postController = new PostController();
        $commentController = new CommentController();
		$ViewController = new ViewController();
		// Création de l'objet Post dans la variable $post
        $post = $postController->getPostById($idPost);
        // Création d'objets Comment dans la variable $comments
        $comments = $commentController->getCommentsFromPost($idPost);
        // Vérifie si une session est active
        if ($isActiveSession) {
        	// Affiche le post, ses commentaires et si la session est active, affiche la possibilité d'ajouter un commentaire
            $ViewController->render(['postView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
         }
        else {
            // Affiche seulement le post et ses commentaires
            $ViewController->render(['postView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
        }
	}
}
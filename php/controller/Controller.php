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
	private $_viewController;
    private $_formController;
    private $_userController;
    private $_postController;
    private $_commentController;

	/**
	 * Constructeur de la classe Controller permettant d'instancier les classes de tous les autres contrôleurs
	 *
	 */
	public function __construct()
	{
		$this->_viewController = new ViewController();
	    $this->_formController = new FormController();
	    $this->_userController = new UserController();
	    $this->_postController = new PostController();
	    $this->_commentController = new CommentController();
	}

	/**
	 * Méthode permettant de vérifier si une action a été effectuée
	 *
	 */
	public function issetAction()
	{
		// Opérateur ternaire : vérifie si une valeur TAG_ACTION existe, si oui, on attribue cette valeur à $action
		$action = isset($_POST[TAG_ACTION]) ? $_POST[TAG_ACTION] : (isset($_GET[TAG_ACTION]) ? $_GET[TAG_ACTION] : null);

		return $action;
	}

	/**
	 * Méthode permettant de démarrer une session
	 *
	 */
	public function sessionStart()
	{
		// Démarrage d'une session
		$sessionStart = session_start();

		return $sessionStart;
	}

	/**
	 * Méthode permettant de détruire une session
	 *
	 */
	public function sessionDestroy()
	{
		// Destruction de la session
        $_SESSION = array();
        $sessionDestroy = session_destroy();

		return $sessionDestroy;
	}

	/**
	 * Méthode permettant de renvoyer la variable $_SESSION['username']
	 *
	 * @param Object $user contient l'instance de l'utilisateur
	 */
	public function returnSessionUsername(User $user)
	{
		// Création d'une variable de session contenant le nom de l'utilisateur
		$_SESSION['username'] = $user->getUsername();
		return $_SESSION['username'];
	}

	/**
	 * Méthode permettant de renvoyer la variable $_SESSION['userId']
	 *
	 * @param Object $user contient l'instance de l'utilisateur
	 */
	public function returnSessionUserId(User $user)
	{
		// Création d'une variable de session contenant l'id de l'utilisateur
		$_SESSION['userId'] = $user->getId();
		return $_SESSION['userId'];
	}

	/**
	 * Méthode permettant de renvoyer la variable $_SESSION['profileId']
	 *
	 * @param Object $user contient l'instance de l'utilisateur
	 */
	public function returnSessionProfileId(User $user)
	{
		// Création d'une variable de session contenant l'id du profil de l'utilisateur
        $_SESSION['profileId'] = $user->getProfile();
		return $_SESSION['profileId'];
	}

	/**
	 * Méthode permettant de vérifier si la variable $_SESSION['username'] existe
	 *
	 */
	public function issetSessionUsername()
	{
		// Vérifie si une session est active
        if (isset($_SESSION['username'])) {
        	return true;
        }
        else {
            return false;
        }
	}

	public function authorizationAdmin()
	{
		if (isset($_SESSION['profileId']) && $_SESSION['profileId'] == 1) {
			return true;
		}
		else {
			return false;
		}
	}

    /**
     * Méthode enclenchée lorsqu'on clique sur la section Articles
     *
     */
	public function actionListPosts()
	{
        // Création des instances de chaque article
        $posts = $this->_postController->articleListPosts();
        // Affichage de la liste des articles
        $this->_viewController->render(['listPostsView'], ['posts' => $posts, 'title' => 'Articles']);
	}

    /**
     * Méthode enclenchée lorsqu'on clique sur un article de blog
     *
     */
	public function actionPost()
	{
        // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
        $idPost = $this->_postController->issetIdPost();
        // Vérifie si $idPost contient une valeur
        if (!empty($idPost)) {
            // Création de l'objet Post dans la variable $post
            $post = $this->_postController->post($idPost);
            // Création d'objets Comment dans la variable $comments
            $comments = $this->_commentController->getComments($idPost);
            // Vérifie si une session est active
            $sessionUsername = $this->issetSessionUsername();
            if ($sessionUsername) {
                // Affiche le post, ses commentaires et si la session est active, affiche la possibilité d'ajouter un commentaire
                $this->_viewController->render(['postView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => $post->getTitle()]);
            }
            else {
                // Affiche seulement le post et ses commentaires
                $this->_viewController->render(['postView'], ['post' => $post, 'comments' => $comments, 'title' => $post->getTitle()]);
            }
        }
        else {
            echo 'Erreur : aucun identifiant de billet envoyé';
        }
	}

    /**
     * Méthode enclenchée lorsqu'on envoie un nouveau commentaire
     *
     */
	public function actionAddComment()
	{
        // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
        $idPost = $this->_postController->issetIdPost();
        // Envoi du commentaire au CommentController
        $newComment = $this->_commentController->addComment($idPost);
        // Création de l'objet Post dans la variable $post
        $post = $this->_postController->post($idPost);
        // Création d'objets Comment dans la variable $comments
        $comments = $this->_commentController->getComments($idPost);
        // Si le nouveau commentaire ne vaut pas NULL
        if ($newComment) {
            // Affiche le post, ses commentaires et affiche la possibilité d'ajouter un commentaire
            $this->_viewController->render(['postView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => $post->getTitle()]);
        }
        else {
            // Affiche le post, ses commentaires, le message d'échec d'envoi du commentaire et affiche la possibilité d'ajouter un commentaire
            $this->_viewController->render(['postView', 'addCommentFailedView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => $post->getTitle()]);
        }
	}

    /**
     * Méthode enclenchée à l'affichage du formulaire d'inscription
     *
     */
	public function actionRegistrationForm()
	{
        // Vue correspondante au formulaire d'inscription
        $this->_viewController->render(['registrationView'], ['title' => 'Inscription']);
	}

    /**
     * Méthode enclenchée à l'envoi du formulaire d'inscription
     *
     */
	public function actionRegistrationSubmit()
	{
        // Création d'un nouvel utilisateur avec les données des variables
        $newUser = $this->_userController->createNewUser();
        // Si $newUser n'est pas NULL, donc si les champs du formulaire ont été remplis correctement
        if ($newUser) 
        {
            // Affichage d'un message d'inscription réussie et du formulaire de connexion
            $this->_viewController->render(['registrationSucessView', 'loginView'], ['title' => 'Inscription réussie']);
        }
        else
        {
            // Affichage d'un message d'inscription ratée et du formulaire d'inscription
            $this->_viewController->render(['registrationFailureView', 'registrationView'], ['title' => 'Inscription']);
        }
	}

    /**
     * Méthode enclenchée à l'affichage du formulaire de connexion
     *
     */
	public function actionLoginForm()
	{
        // Vue correspondante au formulaire de connexion
        $this->_viewController->render(['loginView'], ['title' => 'Connexion']);
	}

    /**
     * Méthode enclenchée à l'envoi du formulaire de connexion
     *
     */
	public function actionLoginSubmit()
	{
        // Création de l'objet User dans la variable $user
        $user = $this->_userController->getUser();
        // Vérifie si la variable $user contient quelque chose
        if ($user) 
        {
            // Création d'une variable de session contenant le nom de l'utilisateur
            $sessionUsername = $this->returnSessionUsername($user);
            // Création d'une variable de session contenant l'id de l'utilisateur
            $sessionUserId = $this->returnSessionUserId($user);
            // Création d'une variable de session contenant l'id du profil de l'utilisateur
            $sessionProfileId = $this->returnSessionProfileId($user);
            // Récupération du contenu des articles de blog dans la variable $posts pour pouvoir les afficher sur la page d'accueil
            $posts = $this->_postController->indexListPosts();
            // Affichage des vues une fois l'utilisateur/administrateur connecté
            $this->_viewController->render(['indexView', 'listPostsView'], ['posts' => $posts, 'title' => 'Blog de Jean Forteroche']);
        }
        else 
        {
            // Affichage des vues en cas d'échec de connexion
            $this->_viewController->render(['connexionFailureView', 'loginView'], ['title' => 'Connexion']);
        }
	}

    /**
     * Méthode enclenchée lors d'une déconnexion utilisateur
     *
     */
	public function actionLogout()
	{
        // Destruction de la session
        $sessionDestroy = $this->sessionDestroy();
        // Récupération du contenu des articles de blog dans la variable $posts pour pouvoir les afficher sur la page d'accueil
        $posts = $this->_postController->indexListPosts();
        // Affichage des vues après déconnexion
        $this->_viewController->render(['indexView', 'listPostsView'], ['posts' => $posts, 'title' => 'Blog de Jean Forteroche']);
	}

    /**
     * Méthode enclenchée lors du clic sur le bouton Connexion Administrateur
     *
     */
	public function actionLoginAdmin()
	{
		if ($this->authorizationAdmin()) {
	        // Création des instances de chaque article
	        $posts = $this->_postController->articleListPosts();
	        // Affichage de la vue administrateur
	        $this->_viewController->renderAdmin(['listPostsAdminView'], ['posts' => $posts, 'title' => 'Administration : Blog de Jean Forteroche']);
		}
		else {
			die("Connexion impossible : administrateur non-reconnu");
		}
	}

    /**
     * Méthode enclenchée pour aller sur la page de création d'article
     *
     */
	public function actionAddPost()
	{
		if ($this->authorizationAdmin()) {
	        // Affichage de la vue de création d'article administrateur
	        $this->_viewController->renderAdmin(['addPostAdminView'], ['title' => 'Nouvel article']);
		}
		else {
			die("Connexion impossible : administrateur non-reconnu");
		}
	}

    /**
     * Méthode enclenchée pour créer un nouvel article
     *
     */
	public function actionCreateNewPost()
	{
		if ($this->authorizationAdmin()) {
	        // Création d'un nouvel article avec les données des variables
	        $newPost = $this->_postController->createNewPost();
	        // Si $newPost n'est pas NULL, donc si les champs du formulaire ont été remplis correctement
	        if ($newPost) 
	        {
	            // Création des instances de chaque article
	            $posts = $this->_postController->articleListPosts();
	            // Affichage de la vue administrateur
	            $this->_viewController->renderAdmin(['listPostsAdminView'], ['posts' => $posts, 'title' => 'Administration : Blog de Jean Forteroche']);
	        }
	        else
	        {
	            // Affichage de la vue de création d'article administrateur
	            $this->_viewController->renderAdmin(['addPostAdminView', 'addPostFailureView'], ['title' => 'Nouvel article']);
	        }
		}
		else {
			die("Connexion impossible : administrateur non-reconnu");
		}
	}

    /**
     * Méthode enclenchée lors du clic sur le bouton Modifier de la page administrateur
     *
     */
	public function actionEditPost()
	{
		if ($this->authorizationAdmin()) {
	        // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
	        $idPost = $this->_postController->issetIdPost();
	        // Sélection de l'article à modifier
	        $post = $this->_postController->post($idPost);
	        // Affichage de la vue de modification d'article administrateur
	        $this->_viewController->renderAdmin(['editPostAdminView'], ['post' => $post, 'title' => 'Modifier un article']);
		}
		else {
			die("Connexion impossible : administrateur non-reconnu");
		}
	}

    /**
     * Méthode enclenchée lors de la modification d'un article (bouton Publier)
     *
     */
	public function actionUpdatePost()
	{
		if ($this->authorizationAdmin()) {
	        // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
	        $idPost = $this->_postController->issetIdPost();
	        // Modification d'un article
	        $updatePost = $this->_postController->updatePost($idPost);
	        // Si $updatePost n'est pas NULL, donc si les champs du formulaire ont été remplis correctement
	        if ($updatePost) 
	        {
	            // Sélection de l'article à modifier
	            $post = $this->_postController->post($idPost);
	            // Affichage de la vue de modification d'article administrateur
	            $this->_viewController->renderAdmin(['editPostAdminView', 'editPostSuccessView'], ['post' => $post, 'title' => 'Modifier un article']);
	        }
	        else
	        {
	            // Sélection de l'article à modifier
	            $post = $this->_postController->post($idPost);
	            // Affichage de la vue de modification d'article administrateur
	            $this->_viewController->renderAdmin(['editPostAdminView', 'addPostFailureView'], ['post' => $post, 'title' => 'Modifier un article']);
	        }
		}
		else {
			die("Connexion impossible : administrateur non-reconnu");
		}
	}

    /**
     * Méthode enclenchée lors de la supression d'un article
     *
     */
	public function actionDeletePost()
	{
		if ($this->authorizationAdmin()) {
	        // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
	        $idPost = $this->_postController->issetIdPost();
	        // Supression d'un article
	        $post = $this->_postController->deletePost($idPost);
	        // Création des instances de chaque article
	        $posts = $this->_postController->articleListPosts();
	        // Affichage de la vue administrateur
	        $this->_viewController->renderAdmin(['listPostsAdminView'], ['posts' => $posts, 'title' => 'Administration : Blog de Jean Forteroche']);
		}
		else {
			die("Connexion impossible : administrateur non-reconnu");
		}
	}

    /**
     * Méthode enclenchée lors du clic sur le bouton Commentaires signalés de la page administrateur
     *
     */
	public function actionCommentsAdmin()
	{
		if ($this->authorizationAdmin()) {
	        // Création des instances de chaque commentaire signalé
	        $comments = $this->_commentController->getReportedComments();
	        // Affichage de la vue administrateur de modération des commentaires
	        $this->_viewController->renderAdmin(['reportedCommentsAdminView'], ['comments' => $comments, 'title' => 'Commentaires Signalés']);
		}
		else {
			die("Connexion impossible : administrateur non-reconnu");
		}
	}

    /**
     * Méthode enclenchée lors du signalement d'un commentaire
     *
     */
	public function actionReportComment()
	{
        // Opérateur ternaire : vérifie si une valeur TAG_IDCOMMENT est envoyée par l'utilisateur, si oui, on attribue cette valeur à $id
        $id = $this->_commentController->issetIdComment();
        // Signalement d'un commentaire
        $comments = $this->_commentController->reportComment($id);
        // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
        $idPost = $this->_postController->issetIdPost();
        // Création de l'objet Post dans la variable $post
        $post = $this->_postController->post($idPost);
        // Création d'objets Comment dans la variable $comments
        $comments = $this->_commentController->getComments($idPost);
        // Vérifie si une session est active
        $sessionUsername = $this->issetSessionUsername();
        if ($sessionUsername) {
            // Affiche le post, ses commentaires et si la session est active, affiche la possibilité d'ajouter un commentaire. Affiche un message disant que le commentaire a été signalé.
            $this->_viewController->render(['postView', 'reportCommentSuccessView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => $post->getTitle()]);
        }
        else {
            // Affiche seulement le post et ses commentaires. Affiche un message disant que le commentaire a été signalé.
            $this->_viewController->render(['postView', 'reportCommentSuccessView'], ['post' => $post, 'comments' => $comments, 'title' => $post->getTitle()]);
        }
	}

    /**
     * Méthode enclenchée lors de la normalisation d'un commentaire signalé
     *
     */
	public function actionNormaliseComment()
	{
		if ($this->authorizationAdmin()) {
	        // Opérateur ternaire : vérifie si une valeur TAG_IDCOMMENT est envoyée par l'utilisateur, si oui, on attribue cette valeur à $id
	        $id = $this->_commentController->issetIdComment();
	        // Normalisation d'un commentaire
	        $comment = $this->_commentController->normaliseComment($id);
	        // Création des instances de chaque commentaire signalé
	        $comments = $this->_commentController->getReportedComments();
	        // Affichage de la vue administrateur de modération des commentaires
	        $this->_viewController->renderAdmin(['reportedCommentsAdminView'], ['comments' => $comments, 'title' => 'Commentaires Signalés']);
		}
		else {
			die("Connexion impossible : administrateur non-reconnu");
		}
	}

    /**
     * Méthode enclenchée lors de la supression d'un commentaire signalé
     *
     */
	public function actionDeleteComment()
	{
		if ($this->authorizationAdmin()) {
	        // Opérateur ternaire : vérifie si une valeur TAG_IDCOMMENT est envoyée par l'utilisateur, si oui, on attribue cette valeur à $id
	        $id = $this->_commentController->issetIdComment();
	        // Supression d'un commentaire
	        $comment = $this->_commentController->deleteComment($id);
	        // Création des instances de chaque commentaire signalé
	        $comments = $this->_commentController->getReportedComments();
	        // Affichage de la vue administrateur de modération des commentaires
	        $this->_viewController->renderAdmin(['reportedCommentsAdminView'], ['comments' => $comments, 'title' => 'Commentaires Signalés']);
		}
		else {
			die("Connexion impossible : administrateur non-reconnu");
		}
	}

    /**
     * Méthode, Accueil
     *
     */
	public function actionHome()
	{
        // Récupération du contenu des articles de blog dans la variable $posts pour pouvoir les afficher sur la page d'accueil
        $posts = $this->_postController->indexListPosts();
        // Affichage des vues
        $this->_viewController->render(['indexView', 'listPostsView'], ['posts' => $posts, 'title' => 'Blog de Jean Forteroche']);
	}	
}
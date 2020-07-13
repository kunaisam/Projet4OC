<?php

/**
 * Fichier contenant le routeur de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 12.03.2020
 */

require( __DIR__ . '/config/configApp.php');
require( __DIR__ . '/config/config.php');

/**
 * Classe Router
 *
 * Classe gérant les différents contrôleurs et sélectionnant les différentes vues à afficher
 */
class Router
{
    /**
     * Méthode enclenchée à l'arrivée d'un visiteur sur le site et à chacune de ses actions
     *
     */
    public function load()
    {
        // Opérateur ternaire : vérifie si une valeur TAG_ACTION existe, si oui, on attribue cette valeur à $action
        $action = isset($_POST[TAG_ACTION]) ? $_POST[TAG_ACTION] : (isset($_GET[TAG_ACTION]) ? $_GET[TAG_ACTION] : null);

        // Instanciation de tous les contrôleurs
        $controller = new Controller();
        $ViewController = new ViewController();
        $formController = new FormController();
        $userController = new UserController();
        $postController = new PostController();
        $commentController = new CommentController();
        // Démarrage d'une session
        session_start();

        // Switch permettant de déterminer l'action entreprise par le visiteur
        switch ($action) {
            /**
             * Action enclenchée lorsqu'on clique sur la section Articles
             *
             */
            case ACTION_LISTPOSTS :
                // Création des instances de chaque article
                $posts = $postController->articleListPosts();
                // Affichage de la liste des articles
                $ViewController->render(['listPostsView'], ['posts' => $posts, 'title' => 'Articles']);
                break;

            /**
             * Action enclenchée lorsqu'on clique sur un article de blog
             *
             */
            case ACTION_POST :
                // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
                $idPost = isset($_POST[TAG_IDPOST]) ? $_POST[TAG_IDPOST] : (isset($_GET[TAG_IDPOST]) ? $_GET[TAG_IDPOST] : null);
                // Vérifie si $idPost contient une valeur
                if (!empty($idPost)) {
                    // Création de l'objet Post dans la variable $post
                    $post = $postController->post($idPost);
                    // Création d'objets Comment dans la variable $comments
                    $comments = $commentController->getComments($idPost);
                    // Vérifie si une session est active
                    if (isset($_SESSION['username'])) {
                        // Affiche le post, ses commentaires et si la session est active, affiche la possibilité d'ajouter un commentaire
                        $ViewController->render(['postView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
                    }
                    else {
                        // Affiche seulement le post et ses commentaires
                        $ViewController->render(['postView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
                    }
                }
                else {
                    echo 'Erreur : aucun identifiant de billet envoyé';
                }
                break;

            /**
             * Action enclenchée lorsqu'on envoie un nouveau commentaire
             *
             */
            case ACTION_ADDCOMMENT:
                // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
                $idPost = isset($_POST[TAG_IDPOST]) ? $_POST[TAG_IDPOST] : (isset($_GET[TAG_IDPOST]) ? $_GET[TAG_IDPOST] : null);
                // Récupère le commentaire posté
                $comment = $_POST['comment'];
                // Envoi du commentaire au CommentController
                $newComment = $commentController->addComment($idPost, $comment);
                // Création de l'objet Post dans la variable $post
                $post = $postController->post($idPost);
                // Création d'objets Comment dans la variable $comments
                $comments = $commentController->getComments($idPost);
                // Si le nouveau commentaire ne vaut pas NULL
                if ($newComment) {
                    // Affiche le post, ses commentaires et affiche la possibilité d'ajouter un commentaire
                    $ViewController->render(['postView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
                }
                else {
                    // Affiche le post, ses commentaires, le message d'échec d'envoi du commentaire et affiche la possibilité d'ajouter un commentaire
                    $ViewController->render(['postView', 'addCommentFailedView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
                }
                break;

            /**
             * Action enclenchée à l'affichage du formulaire d'inscription
             *
             */
            case ACTION_REGISTRATIONFORM :
                // Vue correspondante au formulaire d'inscription
                $ViewController->render(['registrationView'], ['title' => 'Inscription']);
                break;

            /**
             * Action enclenchée à l'envoi du formulaire d'inscription
             *
             */
            case ACTION_REGISTRATIONSUBMIT:
                // Récupération de champs du formulaire dans les variables $login, $pseudo, $password et $passwordConfirmation
                $login = $_POST['login'];
                $pseudo = $_POST['pseudo'];
                $password = $_POST['pass'];
                $passwordConfirmation = $_POST['pass2'];
                // Création d'un nouvel utilisateur avec les données des variables
                $newUser = $userController->createNewUser($login, $pseudo, $password, $passwordConfirmation);
                // Si $newUser n'est pas NULL, donc si les champs du formulaire ont été remplis correctement
                if ($newUser) 
                {
                    // Affichage d'un message d'inscription réussie et du formulaire de connexion
                    $ViewController->render(['registrationSucessView', 'loginView'], ['title' => 'Inscription réussie']);
                }
                else
                {
                    // Affichage d'un message d'inscription ratée et du formulaire d'inscription
                    $ViewController->render(['registrationFailureView', 'registrationView'], ['title' => 'Inscription']);
                }
                break;

            /**
             * Action enclenchée à l'affichage du formulaire de connexion
             *
             */
            case ACTION_LOGINFORM :
                // Vue correspondante au formulaire de connexion
                $ViewController->render(['loginView'], ['title' => 'Connexion']);
                break;

            /**
             * Action enclenchée à l'envoi du formulaire de connexion
             *
             */
            case ACTION_LOGINSUBMIT:
                // Récupération de champs du formulaire dans les variables $login et $password
                $login = $_POST['login'];
                $password = $_POST['pass'];
                // Création de l'objet User dans la variable $user
                $user = $userController->getUser($login, $password);
                // Vérifie si la variable $user contient quelque chose
                if ($user) 
                {
                    // Création d'une variable de session contenant le nom de l'utilisateur
                    $_SESSION['username'] = $user->getUsername();
                    // Création d'une variable de session contenant l'id de l'utilisateur
                    $_SESSION['userId'] = $user->getId();
                    // Création d'une variable de session contenant l'id du profil de l'utilisateur
                    $_SESSION['profileId'] = $user->getProfile();
                    // Récupération du contenu des articles de blog dans la variable $posts pour pouvoir les afficher sur la page d'accueil
                    $posts = $postController->indexListPosts();
                    // Affichage des vues une fois l'utilisateur/administrateur connecté
                    $ViewController->render(['indexView', 'listPostsView'], ['posts' => $posts, 'title' => 'Blog de Jean Forteroche']);
                }
                else 
                {
                    // Affichage des vues en cas d'échec de connexion
                    $ViewController->render(['connexionFailureView', 'loginView'], ['title' => 'Connexion']);
                }
                break;

            /**
             * Action enclenchée lors d'une déconnexion utilisateur
             *
             */
            case ACTION_LOGOUT:
                // Destruction de la session
                $_SESSION = array();
                session_destroy();
                // Récupération du contenu des articles de blog dans la variable $posts pour pouvoir les afficher sur la page d'accueil
                $posts = $postController->indexListPosts();
                // Affichage des vues après déconnexion
                $ViewController->render(['indexView', 'listPostsView'], ['posts' => $posts, 'title' => 'Blog de Jean Forteroche']);
                break;

            /**
             * Action enclenchée à lors du clic sur le bouton Connexion Administrateur
             *
             */
            case ACTION_LOGINADMIN:
                // Création des instances de chaque article
                $posts = $postController->articleListPosts();
                // Affichage de la vue administrateur
                $ViewController->renderAdmin(['adminView', 'listPostsAdminView'], ['posts' => $posts, 'title' => 'Administration : Blog de Jean Forteroche']);
                break;

            /**
             * Action enclenchée pour aller sur la page de création d'article
             *
             */
            case ACTION_ADDPOST:
                // Affichage de la vue de création d'article administrateur
                $ViewController->renderAdmin(['addPostAdminView'], ['title' => 'Nouvel article']);
                break;

            /**
             * Action enclenchée pour créer un nouvel article
             *
             */
            case ACTION_CREATENEWPOST:
                // Récupération de champs du formulaire dans les variables $title et $myTextArea
                $title = $_POST['title'];
                $myTextArea = $_POST['mytextarea'];
                // Création d'un nouvel article avec les données des variables
                $newPost = $postController->createNewPost($title, $myTextArea);
                // Si $newPost n'est pas NULL, donc si les champs du formulaire ont été remplis correctement
                if ($newPost) 
                {
                    // Création des instances de chaque article
                    $posts = $postController->articleListPosts();
                    // Affichage de la vue administrateur
                    $ViewController->renderAdmin(['adminView', 'listPostsAdminView'], ['posts' => $posts, 'title' => 'Administration : Blog de Jean Forteroche']);
                break;
                }
                else
                {
                    // Affichage de la vue de création d'article administrateur
                    $ViewController->renderAdmin(['addPostAdminView', 'addPostFailureView'], ['title' => 'Nouvel article']);
                }
                break;

            /**
             * Action enclenchée lors du clic sur le bouton Modifier de la page administrateur
             *
             */
            case ACTION_EDITPOST:
                // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
                $idPost = isset($_POST[TAG_IDPOST]) ? $_POST[TAG_IDPOST] : (isset($_GET[TAG_IDPOST]) ? $_GET[TAG_IDPOST] : null);
                // Sélection de l'article à modifier
                $post = $postController->post($idPost);
                // Affichage de la vue de modification d'article administrateur
                $ViewController->renderAdmin(['editPostAdminView'], ['post' => $post, 'title' => 'Modifier un article']);
                break;

            /**
             * Action enclenchée lors de la modification d'un article (bouton Publier)
             *
             */
            case ACTION_UPDATEPOST:
                // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
                $idPost = isset($_POST[TAG_IDPOST]) ? $_POST[TAG_IDPOST] : (isset($_GET[TAG_IDPOST]) ? $_GET[TAG_IDPOST] : null);
                // Récupération de champs du formulaire dans les variables $title et $myTextArea
                $title = $_POST['title'];
                $myTextArea = $_POST['mytextarea'];
                // Modification d'un article
                $updatePost = $postController->updatePost($idPost, $title, $myTextArea);
                // Si $updatePost n'est pas NULL, donc si les champs du formulaire ont été remplis correctement
                if ($updatePost) 
                {
                    // Sélection de l'article à modifier
                    $post = $postController->post($idPost);
                    // Affichage de la vue de modification d'article administrateur
                    $ViewController->renderAdmin(['editPostAdminView', 'editPostSuccessView'], ['post' => $post, 'title' => 'Modifier un article']);
                break;
                }
                else
                {
                    // Sélection de l'article à modifier
                    $post = $postController->post($idPost);
                    // Affichage de la vue de modification d'article administrateur
                    $ViewController->renderAdmin(['editPostAdminView', 'addPostFailureView'], ['post' => $post, 'title' => 'Modifier un article']);
                }
                break;

            /**
             * Action enclenchée lors de la supression d'un article
             *
             */
            case ACTION_DELETEPOST:
                // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
                $idPost = isset($_POST[TAG_IDPOST]) ? $_POST[TAG_IDPOST] : (isset($_GET[TAG_IDPOST]) ? $_GET[TAG_IDPOST] : null);
                // Supression d'un article
                $post = $postController->deletePost($idPost);
                // Création des instances de chaque article
                $posts = $postController->articleListPosts();
                // Affichage de la vue administrateur
                $ViewController->renderAdmin(['adminView', 'listPostsAdminView'], ['posts' => $posts, 'title' => 'Administration : Blog de Jean Forteroche']);

                break;

            /**
             * Action enclenchée lors du clic sur le bouton Commentaires signalés de la page administrateur
             *
             */
            case ACTION_COMMENTSADMIN:
                // Création des instances de chaque commentaire signalé
                $comments = $commentController->getReportedComments();
                // Affichage de la vue administrateur de modération des commentaires
                $ViewController->renderAdmin(['reportedCommentsAdminView'], ['comments' => $comments, 'title' => 'Commentaires Signalés']);
                break;

            /**
             * Action enclenchée lors du signalement d'un commentaire
             *
             */
            case ACTION_REPORTCOMMENT:
                // Opérateur ternaire : vérifie si une valeur TAG_IDCOMMENT est envoyée par l'utilisateur, si oui, on attribue cette valeur à $id
                $id = isset($_POST[TAG_IDCOMMENT]) ? $_POST[TAG_IDCOMMENT] : (isset($_GET[TAG_IDCOMMENT]) ? $_GET[TAG_IDCOMMENT] : null);
                // Signalement d'un commentaire
                $comments = $commentController->reportComment($id);
                // Opérateur ternaire : vérifie si une valeur TAG_IDPOST est envoyée par l'utilisateur, si oui, on attribue cette valeur à $idPost
                $idPost = isset($_POST[TAG_IDPOST]) ? $_POST[TAG_IDPOST] : (isset($_GET[TAG_IDPOST]) ? $_GET[TAG_IDPOST] : null);
                // Création de l'objet Post dans la variable $post
                $post = $postController->post($idPost);
                // Création d'objets Comment dans la variable $comments
                $comments = $commentController->getComments($idPost);
                // Vérifie si une session est active
                if (isset($_SESSION['username'])) {
                    // Affiche le post, ses commentaires et si la session est active, affiche la possibilité d'ajouter un commentaire. Affiche un message disant que le commentaire a été signalé.
                    $ViewController->render(['postView', 'reportCommentSuccessView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
                }
                else {
                    // Affiche seulement le post et ses commentaires. Affiche un message disant que le commentaire a été signalé.
                    $ViewController->render(['postView', 'reportCommentSuccessView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
                }
                break;

            /**
             * Action enclenchée lors de la normalisation d'un commentaire signalé
             *
             */
            case ACTION_NORMALISECOMMENT:
                // Opérateur ternaire : vérifie si une valeur TAG_IDCOMMENT est envoyée par l'utilisateur, si oui, on attribue cette valeur à $id
                $id = isset($_POST[TAG_IDCOMMENT]) ? $_POST[TAG_IDCOMMENT] : (isset($_GET[TAG_IDCOMMENT]) ? $_GET[TAG_IDCOMMENT] : null);
                // Normalisation d'un commentaire
                $comment = $commentController->normaliseComment($id);
                // Création des instances de chaque commentaire signalé
                $comments = $commentController->getReportedComments();
                // Affichage de la vue administrateur de modération des commentaires
                $ViewController->renderAdmin(['reportedCommentsAdminView'], ['comments' => $comments, 'title' => 'Commentaires Signalés']);

                break;

            /**
             * Action enclenchée lors de la supression d'un commentaire signalé
             *
             */
            case ACTION_DELETECOMMENT:
                // Opérateur ternaire : vérifie si une valeur TAG_IDCOMMENT est envoyée par l'utilisateur, si oui, on attribue cette valeur à $id
                $id = isset($_POST[TAG_IDCOMMENT]) ? $_POST[TAG_IDCOMMENT] : (isset($_GET[TAG_IDCOMMENT]) ? $_GET[TAG_IDCOMMENT] : null);
                // Supression d'un commentaire
                $comment = $commentController->deleteComment($id);
                // Création des instances de chaque commentaire signalé
                $comments = $commentController->getReportedComments();
                // Affichage de la vue administrateur de modération des commentaires
                $ViewController->renderAdmin(['reportedCommentsAdminView'], ['comments' => $comments, 'title' => 'Commentaires Signalés']);

                break;

            /**
             * Action, Accueil
             *
             */
            case ACTION_HOME:
                // Récupération du contenu des articles de blog dans la variable $posts pour pouvoir les afficher sur la page d'accueil
                $posts = $postController->indexListPosts();
                // Affichage des vues
                $ViewController->render(['indexView', 'listPostsView'], ['posts' => $posts, 'title' => 'Blog de Jean Forteroche']);
                break;

            /**
             * Pas d'action, Accueil
             *
             */
            default :
                // Récupération du contenu des articles de blog dans la variable $posts pour pouvoir les afficher sur la page d'accueil
                $posts = $postController->indexListPosts();
                // Affichage des vues
                $ViewController->render(['indexView', 'listPostsView'], ['posts' => $posts, 'title' => 'Blog de Jean Forteroche']);
        }
    }
}
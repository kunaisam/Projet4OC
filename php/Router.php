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
    public function load()
    {
        $action = isset($_POST[TAG_ACTION]) ? $_POST[TAG_ACTION] : (isset($_GET[TAG_ACTION]) ? $_GET[TAG_ACTION] : null);

        $controller = new Controller();
        $ViewController = new ViewController();
        $formController = new FormController();
        $userController = new UserController();
        session_start();

        switch ($action) {
            case ACTION_LISTPOSTS :
                $posts = $controller->articleListPosts();
                $ViewController->render(['listPostsView'], ['posts' => $posts, 'title' => 'Articles']);
                break;
            case ACTION_POST :
                $idPost = isset($_POST[TAG_IDPOST]) ? $_POST[TAG_IDPOST] : (isset($_GET[TAG_IDPOST]) ? $_GET[TAG_IDPOST] : null);
                if (!empty($idPost)) {
                    $post = $controller->post($idPost);
                    $comments = $controller->comments($idPost);
                    if (isset($_SESSION['username'])) {
                        $ViewController->render(['postView', 'addCommentView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
                    }
                    else {
                        $ViewController->render(['postView'], ['post' => $post, 'comments' => $comments, 'title' => 'Chapitre ' . $idPost]);
                    }
                }
                else {
                    echo 'Erreur : aucun identifiant de billet envoyé';
                }
                break;
            case ACTION_ADDCOMMENT:
                $comment = $_POST['comment'];
                if ($comment !== "") {
                    $idPost = isset($_POST[TAG_IDPOST]) ? $_POST[TAG_IDPOST] : (isset($_GET[TAG_IDPOST]) ? $_GET[TAG_IDPOST] : null);
                }
                else {
                    echo 'Erreur : aucun commentaire envoyé';
                }
                break;
            case ACTION_REGISTRATIONFORM :
                $ViewController->render(['registrationView'], ['title' => 'Inscription']);
                break;
            case ACTION_REGISTRATIONSUBMIT:
                $login = $_POST['login'];
                $pseudo = $_POST['pseudo'];
                $password = $_POST['pass'];
                $passwordConfirmation = $_POST['pass2'];
                $newUser = $userController->createNewUser($login, $pseudo, $password, $passwordConfirmation);
                if ($newUser) 
                {
                    $ViewController->render(['registrationSucessView', 'loginView'], ['title' => 'Inscription réussie']);
                }
                else
                {
                    $ViewController->render(['registrationFailureView', 'registrationView'], ['title' => 'Inscription']);
                }
                break;
            case ACTION_LOGINFORM :
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
                    // Récupération du contenu des articles de blog dans la variable $posts pour pouvoir les afficher sur la page d'accueil
                    /* REMETTRE DE L'ORDRE DANS CETTE PARTIE $posts */
                    $posts = $controller->indexListPosts();
                    // Affichage des vues une fois l'utilisateur/administrateur connecté
                    $ViewController->render(['indexView', 'listPostsView'], ['posts' => $posts, 'title' => 'Blog de Jean Forteroche']);
                }
                else 
                {
                    // Affichage des vues en cas d'échec de connexion
                    $ViewController->render(['connexionFailureView', 'loginView'], ['title' => 'Connexion']);
                }
                break;
            case ACTION_LOGOUT:
                $_SESSION = array();
                session_destroy();
                $posts = $controller->indexListPosts();
                $ViewController->render(['indexView', 'listPostsView'], ['posts' => $posts, 'title' => 'Blog de Jean Forteroche']);
                break;
            default :
                $posts = $controller->indexListPosts();
                $ViewController->render(['indexView', 'listPostsView'], ['posts' => $posts, 'title' => 'Blog de Jean Forteroche']);
        }
    }
}
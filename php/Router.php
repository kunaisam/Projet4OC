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
        // Instanciation du contrôleur principal
        $controller = new Controller();
        // Opérateur ternaire : vérifie si une valeur TAG_ACTION existe, si oui, on attribue cette valeur à $action
        $action = $controller->issetAction();
        // Démarrage d'une session
        $sessionStart = $controller->sessionStart();

        // Switch permettant de déterminer l'action entreprise par le visiteur
        switch ($action) {

            /**
             * Action enclenchée lorsqu'on clique sur la section Articles
             *
             */
            case ACTION_LISTPOSTS :
                $controller->actionListPosts();
                break;

            /**
             * Action enclenchée lorsqu'on clique sur un article de blog
             *
             */
            case ACTION_POST :
                $controller->actionPost();
                break;

            /**
             * Action enclenchée lorsqu'on envoie un nouveau commentaire
             *
             */
            case ACTION_ADDCOMMENT:
                $controller->actionAddComment();
                break;

            /**
             * Action enclenchée à l'affichage du formulaire d'inscription
             *
             */
            case ACTION_REGISTRATIONFORM :
                $controller->actionRegistrationForm();
                break;

            /**
             * Action enclenchée à l'envoi du formulaire d'inscription
             *
             */
            case ACTION_REGISTRATIONSUBMIT:
                $controller->actionRegistrationSubmit();
                break;

            /**
             * Action enclenchée à l'affichage du formulaire de connexion
             *
             */
            case ACTION_LOGINFORM :
                $controller->actionLoginForm();
                break;

            /**
             * Action enclenchée à l'envoi du formulaire de connexion
             *
             */
            case ACTION_LOGINSUBMIT:
                $controller->actionLoginSubmit();
                break;

            /**
             * Action enclenchée lors d'une déconnexion utilisateur
             *
             */
            case ACTION_LOGOUT:
                $controller->actionLogout();
                break;

            /**
             * Action enclenchée lors du clic sur le bouton Connexion Administrateur
             *
             */
            case ACTION_LOGINADMIN:
                $controller->actionLoginAdmin();
                break;

            /**
             * Action enclenchée pour aller sur la page de création d'article
             *
             */
            case ACTION_ADDPOST:
                $controller->actionAddPost();
                break;

            /**
             * Action enclenchée pour créer un nouvel article
             *
             */
            case ACTION_CREATENEWPOST:
                $controller->actionCreateNewPost();
                break;

            /**
             * Action enclenchée lors du clic sur le bouton Modifier de la page administrateur
             *
             */
            case ACTION_EDITPOST:
                $controller->actionEditPost();
                break;

            /**
             * Action enclenchée lors de la modification d'un article (bouton Publier)
             *
             */
            case ACTION_UPDATEPOST:
                $controller->actionUpdatePost();
                break;

            /**
             * Action enclenchée lors de la supression d'un article
             *
             */
            case ACTION_DELETEPOST:
                $controller->actionDeletePost();
                break;

            /**
             * Action enclenchée lors du clic sur le bouton Commentaires signalés de la page administrateur
             *
             */
            case ACTION_COMMENTSADMIN:
                $controller->actionCommentsAdmin();
                break;

            /**
             * Action enclenchée lors du signalement d'un commentaire
             *
             */
            case ACTION_REPORTCOMMENT:
                $controller->actionReportComment();
                break;

            /**
             * Action enclenchée lors de la normalisation d'un commentaire signalé
             *
             */
            case ACTION_NORMALISECOMMENT:
                $controller->actionNormaliseComment();
                break;

            /**
             * Action enclenchée lors de la supression d'un commentaire signalé
             *
             */
            case ACTION_DELETECOMMENT:
                $controller->actionDeleteComment();
                break;

            /**
             * Action, Accueil
             *
             */
            case ACTION_HOME:
                $controller->actionHome();
                break;

            /**
             * Pas d'action, Accueil
             *
             */
            default :
                $controller->actionHome();
        }
    }
}
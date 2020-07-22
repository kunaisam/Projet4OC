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
}
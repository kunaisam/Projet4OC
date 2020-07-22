<?php

/**
 * Fichier contenant le contrôleur des utilisateurs de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 24.06.2020
 */

/**
 * Classe UserController
 *
 * Classe contenant le contrôleur des utilisateurs de l'application
 */
class UserController
{
	/**
	 * Méthode permettant d'appeler un utilisateur via la classe UserManager
	 *
	 */
	public function getUser()
	{
		// Récupération de champs du formulaire dans les variables $login et $password
        $login = $_POST['login'];
        $password = $_POST['pass'];
		// Création de l'objet UserManager dans la variable $userManager
		$userManager = new UserManager();
		// Appel de l'utilisateur via la méthode getUser de $userManager dans la variable $user
		$user = $userManager->getUser($login, $password);

		return $user;
	}

	/**
	 * Méthode permettant de créer un utilisateur via la classe User
	 *
	 */
	public function createNewUser()
	{
        // Récupération de champs du formulaire dans les variables $login, $pseudo, $password et $passwordConfirmation
        $login = $_POST['login'];
        $pseudo = $_POST['pseudo'];
        $password = $_POST['pass'];
        $passwordConfirmation = $_POST['pass2'];
		// Vérifie si le formulaire d'inscription a été correctement rempli
		if (strcmp($password, $passwordConfirmation) == 0 && !empty($login) && !empty($pseudo) && !empty($password) && !empty($passwordConfirmation)) {
			// Création d'une instance ProfileManager
			$profile = new ProfileManager;
			// Récupérantion d'une instance de profil utilisateur
			$profileData = $profile->getProfileById(2);
			// Récupération de l'identifiant du profil
			$profileId = $profileData->getId();
			// Création d'un objet User avec ses données dans un tableau
			$user = new User([
				'login' => $login,
	            'username' => $pseudo, 
	            'password' => $password,
	            'profile_id' => $profileId
			]);

			// Création d'un objet UserManager
			$userManager = new UserManager();
			// Création d'un nouvel utilisateur avec la méthode createNewUser du Usermanager et l'objet User en paramètres
			$newUser = $userManager->createNewUser($user);

			return $newUser;
		}
		else {
			return NULL;
		}
	}
}
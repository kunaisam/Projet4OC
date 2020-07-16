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
	 * @param String $login contient la valeur entrée par l'utilisateur dans la partie Identifiant du fomulaire de connexion
     * @param String $password contient la valeur entrée par l'utilisateur dans la partie Mot de passe du fomulaire de connexion
	 */
	public function getUser($login, $password)
	{
		// Création de l'objet UserManager dans la variable $userManager
		$userManager = new UserManager();
		// Appel de l'utilisateur via la méthode getUser de $userManager dans la variable $user
		$user = $userManager->getUser($login, $password);

		return $user;
	}

	/**
	 * Méthode permettant de créer un utilisateur via la classe User
	 *
	 * @param String $login contient la valeur entrée par l'utilisateur dans la partie Identifiant du fomulaire d'inscription
	 * @param String $pseudo contient la valeur entrée par l'utilisateur dans la partie Pseudonyme du fomulaire d'inscription
     * @param String $password contient la valeur entrée par l'utilisateur dans la partie Mot de passe du fomulaire d'inscription
	 */
	public function createNewUser($login, $pseudo, $password, $passwordConfirmation)
	{
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
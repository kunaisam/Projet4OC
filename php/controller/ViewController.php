<?php

/**
 * Fichier contenant le contrôleur des vues utilisateur de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 02.07.2020
 */

/**
 * Classe ViewController
 *
 * Classe contenant le contrôleur des vues utilisateur de l'application
 */
class ViewController
{
	/**
	 * Méthode permettant d'appeler les différentes vues
	 *
	 * @param String $view contient le nom des vues souhaitées
     * @param String $params contient les paramètres à envoyer aux vues
	 */
	public function render($view, $params)
	{
		foreach($params as $var => $val)
		{
			$$var = $val;
		}

		ob_start();
		include( __DIR__ . '/../view/frontend/header.html');

		if (isset($_SESSION['username'])) {
			include( __DIR__ . '/../view/frontend/navBarConnected.html');
		}
		else 
		{
			include( __DIR__ . '/../view/frontend/navBarDisconnected.html');
		}

		include( __DIR__ . '/../view/frontend/headerImage.html');

		foreach ($view as $key => $keyView) 
		{
			include( __DIR__ . '/../view/frontend/' . $keyView . '.html');
		}

		include( __DIR__ . '/../view/frontend/footer.html');
		die(ob_get_clean());
	}

	/**
	 * Méthode permettant d'appeler les différentes vues administrateur
	 *
	 * @param String $view contient le nom des vues souhaitées
     * @param String $params contient les paramètres à envoyer aux vues
	 */
	public function renderAdmin($view, $params)
	{
		foreach($params as $var => $val)
		{
			$$var = $val;
		}

		ob_start();
		include( __DIR__ . '/../view/frontend/header.html');

		foreach ($view as $key => $keyView) 
		{
			include( __DIR__ . '/../view/admin/' . $keyView . '.html');
		}

		include( __DIR__ . '/../view/frontend/footer.html');
		die(ob_get_clean());
	}
}
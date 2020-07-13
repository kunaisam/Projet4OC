<?php

/**
 * Fichier contenant la classe User
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 23.06.2020
 */

/**
 * Classe User
 *
 * Classe permettant de manipuler un utilisateur
 */
class User
{
	private $_id;
	private $_login;
	private $_username;
	private $_password;
	private $_profile;

	/**
     * Constructeur de la classe User avec toutes les données propres à un utilisateur en paramètres
     *
     * @param Array $data contient les données de l'utilisateur
     */
	public function __construct(array $data = array())
	{
		if (!empty($data)) {
			$this->hydrate($data);
        }
	}

	/**
     * Hydrateur de la classe User, un tableau de données doit être passé à la fonction (d'où le préfixe « array »)
     *
     * @param Array $data contient les données à assigner à l'objet
     */
	public function hydrate(array $data)
	{
		foreach ($data as $key => $value)
		{
			// On récupère le nom du setter correspondant à l'attribut. ucfirst($key) permet de passer la première lettre du setter en majuscule (setMajuscule)
			$method = 'set'.ucfirst($key);       
			// Si le setter correspondant existe.
			if (method_exists($this, $method))
			{
				// On appelle le setter.
				$this->$method($value);
			}
		}
	}

	/**
     * Liste des getters de la classe User
     *
     */
	public function getId() { return $this->_id; }

	public function getLogin() { return $this->_login; }

	public function getUsername() { return $this->_username; }

	public function getPassword() { return $this->_password; }

	public function getProfile() { return $this->_profile; }

	/**
     * Liste des setters de la classe User
     *
     */
	public function setId($id)
	{
	    // On convertit l'argument en nombre entier.
	    // Si c'en était déjà un, rien ne changera.
	    // Sinon, la conversion donnera le nombre 0 (à quelques exceptions près, mais rien d'important ici).
	    $id = (int) $id;
	    
	    // On vérifie ensuite si ce nombre est bien strictement positif.
	    if ($id > 0)
	    {
	    	// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
	    	$this->_id = $id;
	    }
	}

	public function setLogin($login)
	{
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
	    if (is_string($login))
	    {
	    	// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
	    	$this->_login = $login;
	    }
	}

	public function setUsername($username)
	{
	    if (is_string($username))
	    {
	    	$this->_username = $username;
	    }
	}

	public function setPassword($password)
	{
	    if (is_string($password))
	    {
	    	$this->_password = $password;
	    }
	}
	public function setProfile($profile)
	{
		$this->_profile = $profile;
	}
}

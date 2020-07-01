<?php

/**
 * Fichier contenant la classe User
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 24.06.2020
 */

/**
 * Classe Article
 *
 * Classe permettant de manipuler un article de blog
 */
class Article
{
	private $_id;
	private $_title;
	private $_date;
	private $_content;
	private $_user;

	/**
     * Constructeur de la classe Article avec les données propres à un article de blog en paramètres
     *
     * @param Array $data contient les données de l'article
     */
	public function __construct(array $data = array())
	{
		if (!empty($data)) {
			$this->hydrate($data);
        }
	}

	/**
     * Hydrateur de la classe Article, un tableau de données doit être passé à la fonction (d'où le préfixe « array »)
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
     * Liste des getters de la classe Article
     *
     */
	public function getId() { return $this->_id; }

	public function getTitle() { return $this->_title; }

	public function getDate() { return $this->_date; }

	public function getContent() { return $this->_content; }

	public function getUser() { return $this->_user; }

	/**
     * Liste des setters de la classe Article
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

	public function setTitle($title)
	{
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
	    if (is_string($title))
	    {
	    	// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
	    	$this->_title = $title;
	    }
	}

	public function setDate($date)
	{
	    if (is_string($date))
	    {
	    	$this->_date = $date;
	    }
	}

	public function setContent($content)
	{
	    if (is_string($content))
	    {
	    	$this->_content = $content;
	    }
	}
	
	public function setUser($user)
	{
	    $user = (int) $user;

	    if ($user > 0)
	    {
	    	$this->_user = $user;
	    }
	}
}

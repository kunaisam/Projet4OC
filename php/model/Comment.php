<?php

/**
 * Fichier contenant la classe Comment
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 01.07.2020
 */

/**
 * Classe Comment
 *
 * Classe permettant de manipuler un commentaire
 */
class Comment
{
	private $_id;
	private $_articles;
	private $_user;
	private $_date;
	private $_content;
	private $_reported;

	/**
     * Constructeur de la classe Comment avec toutes les données propres à un commentaire en paramètres
     *
     * @param Array $data contient les données du commentaire
     */
	public function __construct(array $data = array())
	{
		if (!empty($data)) {
			$this->hydrate($data);
        }
	}

	/**
     * Hydrateur de la classe Comment, un tableau de données doit être passé à la fonction (d'où le préfixe « array »)
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
     * Liste des getters de la classe Comment
     *
     */
	public function getId() { return $this->_id; }

	public function getArticles() { return $this->_articles; }

	public function getUser() { return $this->_user; }

	public function getDate() { return $this->_date; }

	public function getContent() { return $this->_content; }

	public function getReported() { return $this->_reported; }

	/**
     * Liste des setters de la classe Comment
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

	public function setArticles($articles)
	{
	    // On convertit l'argument en nombre entier.
	    // Si c'en était déjà un, rien ne changera.
	    // Sinon, la conversion donnera le nombre 0 (à quelques exceptions près, mais rien d'important ici).
	    $articles = (int) $articles;
	    
	    // On vérifie ensuite si ce nombre est bien strictement positif.
	    if ($articles > 0)
	    {
	    	// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
	    	$this->_articles = $articles;
	    }
	}

	public function setUser($user)
	{
	    	$this->_user = $user;
	}

	public function setDate($date)
	{
		// Transformation du format US de la date en format francophone
		$date = preg_replace('(([12]\d{3})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))', '$3/$2/$1', $date);

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

	public function setReported($reported)
	{
	    $reported = (int) $reported;
	    
	    // On vérifie ensuite si ce nombre est bien strictement égal à 1 ou à 2, mais pas les deux en même temps.
	    if ($reported == 1 XOR $reported == 2)
	    {
	    	$this->_reported = $reported;
	    }
	}
}
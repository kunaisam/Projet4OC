<?php

/**
 * Fichier contenant la classe Profile
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 08.07.2020
 */

/**
 * Classe Profile
 *
 * Classe permettant de manipuler un profil d'utilisateur
 */
class Profile
{
	private $_id;
	private $_label;

	/**
     * Constructeur de la classe Profile avec toutes les données propres à un profil d'utilisateur en paramètres
     *
     * @param Array $data contient les données du profil de l'utilisateur
     */
	public function __construct(array $data = array())
	{
		if (!empty($data)) {
			$this->hydrate($data);
        }
	}

	/**
     * Hydrateur de la classe Profile, un tableau de données doit être passé à la fonction (d'où le préfixe « array »)
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
     * Liste des getters de la classe Profile
     *
     */
	public function getId() { return $this->_id; }

	public function getLabel() { return $this->_label; }

	/**
     * Liste des setters de la classe Profile
     *
     */
	public function setId($id)
	{
	    // On convertit l'argument en nombre entier.
	    // Si c'en était déjà un, rien ne changera.
	    // Sinon, la conversion donnera le nombre 0 (à quelques exceptions près, mais rien d'important ici).
	    $id = (int) $id;
	    
	    // On vérifie ensuite si ce nombre est bien strictement égal à 1 ou à 2, mais pas les deux en même temps.
	    if ($id == 1 XOR $id == 2)
	    {
	    	$this->_id = $id;
	    }
	}

	public function setLabel($label)
	{
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
	    if (is_string($label))
	    {
	    	// Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
	    	$this->_label = $label;
	    }
	}
}

<?php

/**
 * Fichier contenant le modèle de gestion des profils d'utilisateur
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 08.07.2020
 */


/**
 * Classe ProfileManager
 *
 * Classe contenant le modèle de gestion des profils d'utilisateur
 */
class ProfileManager extends Manager
{
    /**
     * Méthode permettant d'appeler un profil d'utilisateur dans la base de données en fonction de son id et d'incorporer ses valeurs dans un objet de la classe Profile
     *
     * @param Integer $id contient l'id du profil
     */
    public function getProfileById($id)
    {
        try {
            // Connexion à la base de données
            $db = $this->dbConnect();
            // Requête SQL SELECT pour sélectionner le profil dans la base de données
            $req = $db->prepare('SELECT * FROM profile WHERE id = ?');
            $res = $req->execute(array($id));

            // Récupération des données de l'utilisateur dans la variable $profileData
            $profileData = $req->fetch(PDO::FETCH_ASSOC);
            // Instantiation d'un Profile avec les données contenues dans $profileData
            $profile = new Profile($profileData);

            return $profile;
        }
        catch (Exception $e) {
            return null;
        }
    }
}
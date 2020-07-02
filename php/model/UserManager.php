<?php

/**
 * Fichier contenant le modèle de gestion des utilisateurs
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 04.06.2020
 */

/**
 * Classe UserManager
 *
 * Classe contenant le modèle de gestion des utilisateurs
 */
class UserManager extends Manager
{
    /**
     * Méthode permettant de créer une instance de la classe UserManager
     *
     */
    public static function getUserManager()
    {
        return new UserManager();
    }

    /**
     * Méthode permettant d'appeler un utilisateur dans la base de données et d'incorporer ses valeurs dans un objet de la classe User
     *
     * @param String $login contient la valeur entrée par l'utilisateur dans la partie Identifiant du fomulaire de connexion
     * @param String $password contient la valeur entrée par l'utilisateur dans la partie Mot de passe du fomulaire de connexion
     */
    public function getUser($login, $password)
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
        // Requête SQL pour récupérer les données d'un utilisateur, login et password sont inconnues
        $req = $db->prepare('SELECT id, login, username, password, profile_id FROM user WHERE login = ? AND password = ?');
        // Envoi des paramètres $login et $password à la requête pour sélectionner le bon utilisateur
        $req->execute(array($login, $password));
        // PDO::FETCH_ASSOC renvoie les valeurs sous forme d'un tableau associatif.
        $result_array = $req->fetchAll(PDO::FETCH_ASSOC);
        // Vérifie si la variable $result_array est vide
        if (empty($result_array)) {
            return null;
        }
        // Renvoie les données de l'utilisateur sélectionné dans la variable $userData
        $userData = $result_array[0];
        // Création d'un objet de la classe User avec les valeurs contenues dans $userData
        $user = new User($userData);

        return $user;
    }

    /**
     * Méthode permettant de créer un utilisateur et de l'incorporer dans la base de données
     *
     * @param Object $user contient l'instance de l'utilisateur qui va être ajouté en base de données
     */
    public function createNewUser(User $user)
    {
        try {
            // Connexion à la base de données
            $db = $this->dbConnect();
            // Requête SQL INSERT INTO pour ajouter le nouvel utilisateur à la base de données
            $req = $db->prepare('INSERT INTO user(login, username, password, profile_id) VALUES(:login, :username, :password, :profile_id)');

            // Création de variables avec les valeurs de l'objet User
            $login = $user->getLogin();
            $username = $user->getUsername();
            $password = $user->getPassword();
            $profile_id = $user->getProfile();

            // Ajout des données de l'utilisateur à la base de données
            $req->bindParam('login', $login, PDO::PARAM_STR);
            $req->bindParam('username', $username, PDO::PARAM_STR);
            $req->bindParam('password', $password, PDO::PARAM_STR);
            $req->bindParam('profile_id', $profile_id, PDO::PARAM_INT);
            $res = $req->execute();
        }
        catch (Exception $e) {
            die($e);
        }

        return $req;
    }

    /**
     * Méthode permettant d'appeler un utilisateur dans la base de données en fonction de son id et d'incorporer ses valeurs dans un objet de la classe User
     *
     * @param Integer $idUser contient l'id de l'utilisateur
     */
    public function getUserById($idUser)
    {
        try {
            // Connexion à la base de données
            $db = $this->dbConnect();
            // Requête SQL INSERT INTO pour ajouter le nouvel utilisateur à la base de données
            $req = $db->prepare('SELECT login, username, password, profile_id FROM user WHERE id = ?');
            $res = $req->execute(array($idUser));

            // Récupération des données de l'utilisateur dans la variable $userData
            $userData = $req->fetch(PDO::FETCH_ASSOC);
            // Instantiation d'un User avec les données contenues dans $userData
            $user = new User($userData);

            return $user;
        }
        catch (Exception $e) {
            return null;
        }
    }
}
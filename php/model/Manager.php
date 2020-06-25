<?php

/**
 * Fichier contenant le modèle principal de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 24.06.2020
 */

/**
 * Classe Manager
 *
 * Classe contenant le modèle parent de l'application
 */
class Manager
{
    /**
     * Méthode permettant la connexion à la base de données
     *
     */
    protected function dbConnect()
    {
        try
        {
           $db = new PDO('mysql:host=localhost;dbname=project4;charset=utf8', 'root', ''); 
        }
        catch(Exception $e)
        {
            die('Erreur : '. $e->getMessage());
        }        

        return $db;
    }
}
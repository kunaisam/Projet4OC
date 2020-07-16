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
           $db = new PDO(DRIVER_PDO . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";" . DB_OPTIONS, DB_USER, DB_PASSWORD);
        }
        catch(Exception $e)
        {
            die('Erreur : '. $e->getMessage());
        }        

        return $db;
    }
}
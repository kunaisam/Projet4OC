<?php

/**
 * Fichier contenant l'ensemble de la configuration de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 12.03.2020
 */

/**
 * @var string APP_NAME Nom de l'application
 */
define("APP_NAME", "Blog de Jean Forteroche");

/**
 * @var string APP_VERSION Version de l'application
 */
define("APP_VERSION", "1.0");

/**
 * Paramètres de connexion à la base de données via PDO
 */
define("DRIVER_PDO", "mysql");
define("DB_HOST", "localhost");
define("DB_PORT", 3306);
define("DB_NAME", "project4");
define("DB_OPTIONS", "charset=utf8");
define("DB_USER", "root");
define("DB_PASSWORD", "");
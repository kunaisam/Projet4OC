<?php

/**
 * Fichier contenant l'ensemble de la configuration de l'application
 * @author Samy Jebbari Godinho
 * @version 1.0
 * date : 12.03.2020
 */

define( "TAG_ACTION", "action");
define( "TAG_IDPOST", "idPost");
define( "TAG_IDCOMMENT", "idComment");

define( "ACTION_HOME", "home");
define( "ACTION_LISTPOSTS", "listposts");
define( "ACTION_REGISTRATIONFORM", "registrationForm");
define( "ACTION_LOGINFORM", "loginForm");

define("ACTION_ADDPOST", "addPost");
define("ACTION_CREATENEWPOST", "createNewPost");
define("ACTION_EDITPOST", "editPost");
define("ACTION_UPDATEPOST", "updatePost");
define("ACTION_DELETEPOST", "deletePost");

define("ACTION_ADDCOMMENT", "addComment");
define("ACTION_REPORTCOMMENT", "reportComment");
define("ACTION_NORMALISECOMMENT", "normaliseComment");
define("ACTION_DELETECOMMENT", "deleteComment");

define("ACTION_REGISTRATIONSUBMIT", "registrationSubmit");

define( "ACTION_LOGINSUBMIT", "loginSubmit");
define( "ACTION_LOGINADMIN", "loginAdmin");
define( "ACTION_LOGOUT", "logout");

define( "ACTION_COMMENTSADMIN", "commentsAdmin");

define( "ACTION_POST", "post");

/**
 * Fonction blogP4Autoload
 *
 * Fonction permettant de charger automatiquement les fichiers PHP des dossiers controller et model
 */
function blogP4Autoload($className) {
	$classPath = __DIR__ . '/../controller/' . $className . '.php';
	if(file_exists($classPath)) {
		require($classPath);
		return;
	}
	$classPath = __DIR__ . '/../model/' . $className . '.php';
	if(file_exists($classPath)) {
		require($classPath);
		return;
	}
}

spl_autoload_register('blogP4Autoload');
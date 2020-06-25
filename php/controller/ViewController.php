<?php

class ViewController
{
	public function render($view, $params)
	{
		foreach($params as $var => $val)
		{
			$$var = $val;
		}

		ob_start();
		include( __DIR__ . '/../view/frontend/header.html');

		if (isset($_SESSION['username'])) {
			include( __DIR__ . '/../view/frontend/navBarConnected.html');
		}
		else 
		{
			include( __DIR__ . '/../view/frontend/navBarDisconnected.html');
		}

		include( __DIR__ . '/../view/frontend/headerImage.html');

		foreach ($view as $key => $keyView) 
		{
			include( __DIR__ . '/../view/frontend/' . $keyView . '.html');
		}

		include( __DIR__ . '/../view/frontend/footer.html');
		die(ob_get_clean());
	}
}
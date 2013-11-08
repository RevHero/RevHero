<?php
class WebhooksController extends AppController {
    public $name = 'Webhooks';

	function updategit()
	{
		//shell_exec('cd /home/andolarh/public_html');
		//$output = shell_exec('git pull');
		//echo "<pre>$output</pre>";
		//exit;
		
		$connection = ssh2_connect('shell.andola.revhero.com', 22);
		
		if (ssh2_auth_password($connection, 'andolarh', 'rev123')) {
		  echo "Authentication Successful!\n";
		} else {
		  die('Authentication Failed...');
		}
		exit;
	}
}

<?php
class WebhookController extends AppController {
    public $name = 'Webhook';

	function updategit()
	{
		shell_exec('cd /home/andolarh/public_html');
		$output = shell_exec('git pull');
		echo "<pre>$output</pre>";
	}
}

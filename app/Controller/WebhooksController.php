<?php
class WebhooksController extends AppController {
    public $name = 'Webhooks';

	function updategit()
	{
		shell_exec('cd /home/andolarh/public_html');
		$output = shell_exec('git pull');
		echo "<pre>$output</pre>";
		exit;
	}
}

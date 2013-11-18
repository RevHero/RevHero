<?php
class WebhooksController extends AppController {
    public $name = 'Webhooks';

	function updategit()
	{
		$output  = shell_exec('cd  /home/andolarh/public_html/');
		$output .= shell_exec('git pull');
		$output .= shell_exec('chmod -R 755 /home/andolarh/public_html/');
		echo "<pre>$output</pre>";
		exit;
	}
}

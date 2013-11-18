<?php
	/**
	 * GIT DEPLOYMENT SCRIPT
	 *
	 * Used for automatically deploying websites via github:
	 *
	 */

class DeployController extends AppController {
    public $name = 'Deploy';

	function index()
	{
		$commands = array(
		'cd '.WEBHOOK_SERVER_PATH,
		'git pull',
		'git reset --hard HEAD',
		'git pull',
		'chmod -R 755 '.WEBHOOK_SERVER_PATH,
		);
	
		// Run the commands for output
		$output = '';
		foreach($commands AS $command){
			// Run it
			$tmp = shell_exec($command);
			// Output
			$output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
			$output .= htmlentities(trim($tmp)) . "\n";
		}
	}
}
?>

<?php /*?><?php
class WebhooksController extends AppController {
    public $name = 'Webhooks';

	function updategit()
	{
		//shell_exec('#!/bin/bash');
		shell_exec('cd  /home/andolarh/public_html/');
		shell_exec('git pull');
		shell_exec('git reset --hard HEAD');
		$output = shell_exec('git pull');
		shell_exec('chmod -R 755 /home/andolarh/public_html/');
		echo "<pre>$output</pre>";
		exit;
	}
}
<?php */?>
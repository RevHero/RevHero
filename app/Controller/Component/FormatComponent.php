<?php
class FormatComponent extends Component
{
	public $components = array('Session','Email','Cookie');
	
	function sendEmail($from, $to, $subject, $message, $replyto)
	{
		$this->Email->smtpOptions = Configure::read('email_option');
		$this->Email->delivery = 'smtp';
		$this->Email->to = $to; //array()
		$this->Email->subject = $subject;
		$this->Email->from = $from;
		$this->Email->cc = ''; //array()
		$this->Email->bcc = ''; //array()
		$this->Email->sendAs = 'html';
		$this->Email->replyTo = $replyto;
		$this->Email->send($message);
		return true;
	}
}
?>

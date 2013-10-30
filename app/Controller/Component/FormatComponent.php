<?php
class FormatComponent extends Component
{
	public $components = array('Session','Email','Cookie');
	
	function sendConfirmEmail($from, $to, $subject, $message, $replyto=NULL)
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
	
	function generateUniqNumber() { //This is to generate the unique number that require for the registration confirmation
		$uniq = uniqid(rand());
		return md5($uniq.time());
	}
	
	function uploadPhoto($tmp_name,$name,$size,$path,$count,$type)
	{
		if($name)
		{
			$inkb = $size/1024;
			$oldname = strtolower($name);
			$ext = substr(strrchr($oldname, "."), 1);
			if(($ext !='gif') && ($ext !='jpg') && ($ext !='jpeg') && ($ext !='png')) {
				return "ext";
			}
			/*elseif($inkb > 1024) {
				return "size";
			}*/
			else
			{
				list($width,$height) = getimagesize($tmp_name);
				
				if($width > 800)
				{
					try {
						if($ext == "png") {
							$src = imagecreatefrompng($tmp_name);
						}
						elseif($ext == "gif") {
							$src = imagecreatefromgif($tmp_name);
						}
						elseif($ext == "bmp") {
							$src = imagecreatefromwbmp($tmp_name);
						}
						else {
							$src = imagecreatefromjpeg($tmp_name);
						}
						
						$newwidth = 800;
						$newheight = ($height/$width)*$newwidth;
						$tmp = imagecreatetruecolor($newwidth,$newheight);
		
						imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
						
						$newname = md5(time().$count).".".$ext;
						$targetpath = $path.$newname;
						
						imagejpeg($tmp,$targetpath,100);
						imagedestroy($src);
						imagedestroy($tmp);
					}
					catch(Exception $e) {
						return false;
						//echo $e->getMessage();
					}
				}
				else
				{
					$newname = md5(time().$count).".".$ext;
					$targetpath = $path.$newname;
					move_uploaded_file($tmp_name, $targetpath);
				}
				
				if($width < 200 || $height < 200){
					$im_P = 'convert '.$targetpath.'  -background white -gravity center -extent 200x200 '.$targetpath;
					exec($im_P);
				}
				
				return $newname;
			}
		}
		else {
			return false;	
		}
	}
}
?>

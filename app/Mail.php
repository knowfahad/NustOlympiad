<?php 
namespace App;
require_once("../vendor/autoload.php");
// use Swift_SmtpTransport;
// use Swift_Mailer;
// use Swift_Message;

/**
 * A service class to send mail
 */
class olMail
{
	private $transport;
	private $mailer;

    public function __construct()
    {
    	$this->transport = Swift_SmtpTransport::newInstance('gator3087.hostgator.com', 587, 'ssl')
    	  ->setUsername('web_it@nustolymiad.com')
    	  ->setPassword('olympiad@391');

    	$this->mailer = Swift_Mailer::newInstance($this->transport);
    }

    public function send($subject, $email, $name,  $body){
    	$message = Swift_Message::newInstance('')
			    	  ->setFrom(array('web_it@nustolymiad.com' => 'NUST Olympiad\'17'))
			    	  ->setTo($email, $name)
			    	  ->setBody($body);

    	return $this->mailer->send($message);
    }
}

$mailer = new olMail();
$mailer->send('Verify your account | NUST OLYMPIAD 17', 'suchalriaz@gmail.com', 'suchal riaz', 'Hello!');

// require_once 'PHPMailer-master/PHPMailerAutoload.php';
// $m= new PHPMailer;
// $m->isSMTP();
// $m->SMTPAuth=true;

// $m->Host='wp38.hostgator.com';
// $m->Username='web_it@nustolymiad.com';
// $m->Password='olympiad@391';
// $m->SMTPSecure='ssl';
// $m->Port=587;


// $m->From='web_it@nustolymiad.com';
// $m->FromName='nust olympiad 17';
// $m->addReplyTo('web_it@nustolymiad.com', 'Nust');
// $m->addAddress("suchalriaz@gmail.com", "suchal riaz");

// $message = "To verify your account click on the link:  
// http://localhost/tempScripts/register/verifyemail/verifyEmail.php?";

// $m->Subject='Verify your account | NUST OLYMPIAD 17';
// $m->Body=$message;

// $m->send();

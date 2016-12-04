<?php 
namespace App;
require_once("../vendor/autoload.php");

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
/**
* olmail
*/
class OlMail
{
    private $promise;
    private $sparky;
    
    function __construct($receiver = [], $subject, $htmlmessage, $txtmessage)
    {
        $httpClient = new GuzzleAdapter(new Client());
        $this->sparky = new SparkPost($httpClient, ["key"=>"96cf0a3751f32d6f22be7947660d5690da7f31d6"]);
        $this->promise = $this->sparky->transmissions->post([
            'content' => [
                'from' => [
                    'name' => 'NUST Olympiad',
                    'email' => 'noreply@nustolympiad.com',
                ],
                'subject' => $subject,
                'html' => $htmlmessage,
                'text' => $txtmessage
            ],
            'recipients' => [
                [
                    'address' => [
                        'name' => $receiver['name'],
                        'email' => $receiver['email']
                    ],
                ],
            ],
        ]);
    }

    public function send(){
        $this->sparky->setOptions(['async' => false]);
        try {
            $response = $this->sparky->transmissions->get();

            echo $response->getStatusCode()."\n";
            print_r($response->getBody())."\n";
        }
        catch (\Exception $e) {
            echo $e->getCode()."\n";
            echo $e->getMessage()."\n";
        }
    }
}


$cmail = new olmail(['name'=>'suchal riaz', 'email'=>'suchal@live.com'], 'Welcome onboard!', '<p>Just a reminder that this is the last time you are testing like this.</p>', 'Welcome onboard! Just a reminder, that this is the last time you are testing like this.');
$cmail->send();

// // $message = "To verify your account click on the link:  
// // http://localhost/tempScripts/register/verifyemail/verifyEmail.php?";

// // $m->Subject='Verify your account | NUST OLYMPIAD 17';
// // $m->Body=$message;

// // $m->send();



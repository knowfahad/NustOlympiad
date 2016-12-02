<?php 
namespace codeCourse\capture;

//error_reporting(0);

use codeCourse\Views\View;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\Response;

Class capture
{
	
	protected $view;
	protected $pdf;

	public function __construct()
	{
		$this->view = new View;
	}
	
	public function respond($filename)
	{
		$response = new Response(file_get_contents($this->pdf),200,[
			'Content-Description' => 'File Transfer',
			'Content-Disposition' => 'attachment; filename = "'.$filename.'"',
			'Content-Transfer-Encoding' => 'binary',
			'Content-Type' => 'application/pdf',
			
		]);
		unlink($this->pdf);
		$response->send();
	}
	
	 public function load($filename, array $data = []){
		 $view  = $this->view->render($filename,$data);
		 $this->pdf = $this->captureImage($view);
	 }
	protected function captureImage($view){
		$path = $this->writeFile($view);
		$this->phantomProcess($path)->setTimeout(10)->mustRun();
		
		return $path;
	}
	protected function writeFile($view)
	{
		file_put_contents($path = 'storage/'.md5(uniqid()). '.pdf',$view);
		return $path;
	}
	protected function phantomProcess($path)
	{
		return new Process('bin\phantomjs.exe capture.js ' . $path);
	}
	
	
}
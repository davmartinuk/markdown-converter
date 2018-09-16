<?php

class ConvertMarkdown {
		
	public $appName;
	public $appFooter;
	public $uploadPath;

	public function __construct() {
		
		require_once 'libs/parsedown/Parsedown.php';
		
		$this->appHeader = "=========== Convert Markdown =======\n";
		$this->appFooter = '=========== Copyright '.date("Y")." ========\n";

	}

	public function about(){
		
		echo $this->appHeader;
		echo "Written by David Martin\n";
		echo "September 2018\n";
		echo "Press 1 to return to the Main Menu\n";
		echo $this->appFooter;
		echo "Enter your choice:";

		$choice = trim( fgets(STDIN));
		
		if($choice == 1) {
			$this->mainMenu();
		}

	}
	
	public function mainMenu() {
		
		echo $this->appHeader;
		echo "1 - Upload Markdown\n";
		echo "2 - About\n";
		echo "3 - Quit\n";
		echo $this->appFooter;
		echo "Enter your choice:";

		$choice = trim( fgets(STDIN));
		
		switch ($choice) {
			case '1':
				$this->configureUpload();
				//$this->uploadMarkdown();
				break;

			case '2':
				$this->about();
				break;

			case '3':
				exit();
			
			default:
				echo "Invalid input \n";
				break;
		}

	}	

	public function uploadMarkdown(){
		
		echo "Enter the filename (e.g. markdown.md) then press return\n";

		$fileName = trim( fgets(STDIN));
		$Parsedown = new Parsedown();
		$file = file_get_contents($fileName, true);
		$htmlFile = $this->changeFileType($fileName);
		$outputFile = $this->uploadPath.'/'.date('m-d-Y_hia').'_'.$htmlFile;

		if ($this->checkIfFileExists($fileName)){
				
				if ($this->checkFileIsValid($fileName)){
				
				file_put_contents($outputFile, $Parsedown->text($file));
				
				if ($this->checkIfFileExists($outputFile)){
					echo "\033[32m SUCCESS! \033[0m file created at: ".$outputFile."\n";
					$this->mainMenu();
				} else {
					echo "\033[31m ERROR: \033[0m Unknown error - file has not been created.\n";
					$this->uploadMarkdown();
				}

			} else {
				echo "\033[31m ERROR: \033[0m Invalid file type (only use .md types).\n";
				$this->uploadMarkdown();
			}
		} else {
			echo "\033[31m ERROR: \033[0m Could not find the input file\n";
			$this->uploadMarkdown();
		}

	}

	// Validating MIME and Extension - I'm not 100% sure if this bulletproof
	public function checkFileIsValid($file){
		
		if(mime_content_type ($file) == 'text/plain'){
			
			$allowed =  array('md');
			$ext = pathinfo($file, PATHINFO_EXTENSION);
				if(!in_array($ext,$allowed) ) {
					return false;
				}
				else {
					return true;
				}

		} else {
			return false;
		}
	}

	// Let's check the file has been created successfully.
	public function checkIfFileExists($fileName){

		if (file_exists($fileName)) {
		    return true;
		} else {
		    return false;
		}

	}

	// Adding the .html file type
	public function changeFileType($htmlFilepath){
		return substr_replace($htmlFilepath, 'html', strrpos($htmlFilepath , '.') +1);
	}

	// Folder path to upload - this is where the S3 or FTP would extend from in the future.
	public function configureUpload(){
		echo "Enter the UPLOAD path (Use e.g. './uploads') then press return\n";
		$this->uploadPath = trim( fgets(STDIN));

		//check if folder exists
		if (!file_exists($this->uploadPath)) {
    		mkdir($this->uploadPath, 0777, true);
		}

		$this->uploadMarkdown();

	}

	// This isnt used, was doing things in the wrong order - ran out of time but i'm sure this could be solved in 10mins.
	public function htmlTags($file){

		return '<html><head></head><body>'.$file.'</body></html>';

	}

}

$convertMarkdown = new ConvertMarkdown();

$convertMarkdown->mainMenu();


?>
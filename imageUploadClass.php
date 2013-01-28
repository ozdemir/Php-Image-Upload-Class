<?php
	/*
	
	Emre Özdemir tarafından geliştirilen basit Upload Class'ıdır. Hiç bir izine gerek duymadan alır kullanabilir, geliştirebilirsiniz. Olmasını istediğinizi özellikler ile ilgili veya geliştirdiğiniz kısımları ile ilgili emreoz@gmail.com ' a mail atarak gelişimine katkıda bulunabilirsiniz.
	
	Sınıfı çok basit bulursanız da kullanmayabilirsiniz :)
	
	Teşekkürler,
	
	*/

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title></title>
</head>
<body>
<?php
	class PhotoUpload{
		
		function PhotoUpload($_FILES, $size = 1024, $dir){
			$this->m_file = $_FILES;
			$this->m_source = $_FILES["uploadFile"]["tmp_name"];
			$this->m_max_size = $this->sizeConvert($size);
			$this->dirControl($dir);
			
			$this->variableValue();
			$this->isFormatValidate();
			$this->sizeControl();
			$this->startUpload();
		}
		
		private function rename(){
			return sha1(md5($this->m_name));
		}
		
		private function startUpload(){
			if(move_uploaded_file($this->m_source, $this->m_dir."/".$this->rename().".".$this->m_ext)){
				echo "Yüklendi";
			} else{
				echo "hata var";
			}
		}
		private function dirControl($dir){
			if( !is_dir($dir) && !mkdir($dir, 0755) ){
				$this -> errHandling(3,"The file does not exist!");
			}
			if( !is_writable($dir) && !chmod($dir, 0755) ){
				$this -> errHandling(3,"File is not writable");
			}
			$this->m_dir = $dir;
		}
		
		private function isFormatValidate(){
			$allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "JPEG");
			$extension = end(explode(".", $this->m_name));
			
			if(!in_array($extension, $allowedExts)){
				$this -> errHandling(1, "Invalid format");
			} else {
				$this->m_ext = $extension;
			}
		}

		private function sizeControl(){
			
			if($this->m_size > $this->m_max_size){
				$this->errHandling(2, "Invalid size");
			}
		}

		private function errHandling($errCode = 0, $msg){
				die("Error Code : ". $errCode ."<br />Error Type : ". $msg);
		}

		private function saySomeThing(){
			echo "<br />hellooo";
		}
		
		private function variableValue(){
			$this->m_name = $this->m_file["uploadFile"]["name"];
			$this->m_size = $this->m_file["uploadFile"]["size"];
		}
		
		private function sizeConvert($size){
			return $size * 1024;
		}
		
		function getFormatFile(){
			return $this->m_name;
		}
		
		function getFileSize(){
			return $this->m_size;
		}
		
		function setSize($size){
			$this->m_max_size = $this->sizeConvert($size);
		}

		private $m_file;
		private $m_name, $m_size, $m_ext, $m_max_size, $m_dir, $m_source;
	}
?>
	<?php
		if($_POST){
			$t = new PhotoUpload($_FILES,2048,"images");
		}
	?>
	
	<form method="POST" enctype="multipart/form-data">
		<label for="file">Filename:</label>
		<input type="file" name="uploadFile"><br>
		<input type="submit" name="submit" value="Submit">
	</form>
<?php
/*
$t = new PhotoUpload($file);
echo $file;
*/
?>
</body>
</html>
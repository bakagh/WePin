<?php
class BobDemo{
	const DB_HOST = '127.0.0.1';
	const DB_NAME = 'test';
	const DB_USER = 'lw1378';
	const DB_PASSWORD = '';

	private $conn = null;

	/**
	 * Open the database connection
	 */
	public function __construct(){
		// open database connection
		$connectionString = sprintf("mysql:host=%s;dbname=%s;charset=utf8",
				BobDemo::DB_HOST,
				BobDemo::DB_NAME);

		try {
			$this->conn = new PDO($connectionString,
					BobDemo::DB_USER,
					BobDemo::DB_PASSWORD);
			//for prior PHP 5.3.6
			//$conn->exec("set names utf8");

		} catch (PDOException $pe) {
			die($pe->getMessage());
		}
	}



	/**
	 * insert blob into the files table
	 * @param string $filePath
	 * @param string $mime mimetype
	 */
	public function insertBlob($filePath,$mime){
		$blob = fopen($filePath,'rb');

		$sql = "INSERT INTO files(mime,data) VALUES(:mime,:data)";
		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':mime',$mime);
		$stmt->bindParam(':data',$blob,PDO::PARAM_LOB);

		return $stmt->execute();
	}

	/**
	 * update the files table with the new blob from the file specified
	 * by the filepath
	 * @param int $id
	 * @param string $filePath
	 * @param string $mime
	 * @return boolean
	 */
	function updateBlob($id,$filePath,$mime) {

		$blob = fopen($filePath,'rb');

		$sql = "UPDATE files
				SET mime = :mime,
				data = :data
				WHERE id = :id";

		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':mime',$mime);
		$stmt->bindParam(':data',$blob,PDO::PARAM_LOB);
		$stmt->bindParam(':id',$id);

		return $stmt->execute();

	}

	/**
	 * select data from the the files
	 * @param int $id
	 * @return array contains mime type and BLOB data
	 */
	public function selectBlob($id) {

		$sql = "SELECT mime,
				data
				FROM files
				WHERE id = :id";

		$stmt = $this->conn->prepare($sql);
		$stmt->execute(array(":id" => $id));
		$stmt->bindColumn(1, $mime);
		$stmt->bindColumn(2, $data, PDO::PARAM_LOB);

		$stmt->fetch(PDO::FETCH_BOUND);

		return array("mime" => $mime,
				"data" => $data);

	}

	/**
	 * close the database connection
	 */
	public function __destruct() {
		// close the database connection
		$this->conn = null;
	}
}


$blobObj = new BobDemo();

// test insert gif image
#$blobObj->insertBlob('images/php-mysql-blob.gif',"image/gif");


#$a = $blobObj->selectBlob(1);
#header("Content-Type:" . $a['mime']);
#echo $a['data'];

#$blobObj->insertBlob('images/test2.jpg', "image/jpeg");
#$blobObj->insertBlob('images/Hebe1.jpeg', "image/jpeg");
#$blobObj->insertBlob('images/test.png', "image/png");

    #$a = $blobObj->selectBlob(8);
    #header("Content-Type:" . $a['mime']);
    #echo $a['data'];

#function print_result($from, $to) {
#  for ($i = $from;$i < $to;$i ++) {
#	$a = $blobObj->selectBlob($i);
#	header("Content-Type:" .$a['mime']);
#	echo $a['data'];  
#  }
#}

#print_result(3, 9);
// test insert pdf
//$blobObj->insertBlob('pdf/php-mysql-blob.pdf',"application/pdf");

//$a = $blobObj->selectBlob(2);
// save it to the pdf file
//file_put_contents("pdf/output.pdf", $a['data']);

// $a = $blobObj->selectBlob(2);
// header("Content-Type:" . $a['mime']);
// echo $a['data'];


// replace the PDF by gif file
#$blobObj->updateBlob(2, 'images/php-mysql-blob.gif', "image/gif");

#$a = $blobObj->selectBlob(2);
#header("Content-Type:" . $a['mime']);
#echo $a['data'];





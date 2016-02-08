<?php
class FileFromDB {

    private $filename;
	

    public function __construct($filename) {
        $this->filename = $filename;
    }

    public function upload($file,$nom_envoye) {
        global $PDO;
		//$client_envoye = $_POST
        $stmt = $PDO->prepare("REPLACE INTO FILE ".
                              "(name, type,client_envoye, data) ".
                              "VALUES (?, ?, ?, ?)");
        $stmt->bindParam(1, $this->filename);
		$extension = fopen($file['tmp_name'], 'rb');
        $stmt->bindParam(2, $file['type']);
		$stmt->bindParam(3, $nom_envoye);
        $stmt->bindParam(4, $extension, PDO::PARAM_LOB);
        return $stmt->execute();
    }

    public function headers() {
        global $PDO;
        $stmt = $PDO->prepare("SELECT name, type, UNIX_TIMESTAMP(updated_date) AS updated_date ".
                              "FROM FILE ".
                              "WHERE name = ?");
        $stmt->bindParam(1, $this->filename);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function output($filename=null) {
        global $PDO;
        $stmt = $PDO->prepare("SELECT type, UNIX_TIMESTAMP(updated_date), data ".
                              "FROM FILE ".
                              "WHERE name = ?");
        $stmt->bindParam(1, $this->filename);
        $stmt->execute();
        $stmt->bindColumn(1, $type, PDO::PARAM_STR, 256);
        $stmt->bindColumn(2, $updated_date, PDO::PARAM_INT);
        $stmt->bindColumn(3, $data, PDO::PARAM_LOB);
        $stmt->fetch(PDO::FETCH_BOUND);
        if (is_null($filename)) {
            header("Content-Type: $type");
            header("Content-Disposition: inline; filename={$this->filename}");
            header("Last-Modified: ".date('r', $updated_date));
            //return fpassthru($data);
            return print($data);
        } else {
            $hdle = fopen($filename, 'wb');
            //return stream_copy_to_stream($data, $hdle);
            return fwrite($hdle, $data);
        }
    }

}

?>
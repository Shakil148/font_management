<?php
require_once 'Database.php';

class Font extends Database
{
    // table name
    protected $tableFont = 'fonts';
    protected $tableGroup = 'font_groups';
    protected $groupDetails = 'group_details';

    /**
     * function is used to add record
     * @param array $data
     * @return int $lastInsertedId
     */
    public function add($data, $newTable)
    {
        $this->tableFont = $newTable;
        if (!empty($data)) {
            $fileds = $placholders = [];
            foreach ($data as $field => $value) {
                $fileds[] = $field;
                $placholders[] = ":{$field}";
            }
        }

        $sql = "INSERT INTO {$this->tableFont} (" . implode(',', $fileds) . ") VALUES (" . implode(',', $placholders) . ")";
        $stmt = $this->conn->prepare($sql);
        try {
            $this->conn->beginTransaction();
            $stmt->execute($data);
            $lastInsertedId = $this->conn->lastInsertId();
            $this->conn->commit();
            return $lastInsertedId;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $this->conn->rollback();
        }

    }

    /**
     * function is used to get records
     * @param int $stmt
     * @param int @limit
     * @return array $results
     */
    // delete row using id
    public function deleteRow($id,$table,$attr)
    {
        $this->tableGroup = $table;
        $sql = "DELETE FROM {$this->tableGroup}  WHERE {$attr}={$id}";
        $stmt = $this->conn->prepare($sql);
        try {
            $stmt->execute([$attr => $id]);
            if ($stmt->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }

    }

    /**
     * function is used to get single record based on the column value
     * @param string $fileds
     * @param any $value
     * @return array $results
     */
    public function getRow($field, $value, $table)
    {
        $this->tableFont = $table;
        $sql = "SELECT * FROM {$this->tableFont}  WHERE {$field}=:{$field}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":{$field}" => $value]);
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = [];
        }

        return $result;
    }
    public function getBothRow($field, $value)
    {

        $sql = "SELECT * FROM {$this->tableFont} a left join {$this->groupDetails} b on a.id=b.group_id  WHERE a.{$field}=:{$field}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":{$field}" => $value]);
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = [];
        }

        return $result;
    }

    /**
     * funciton is used to upload file
     * @param array $file
     * @return string $newFileName
     */
    public function uploadPhoto($file)
    {
        if (!empty($file)) {
            $fileTempPath = $file['tmp_name'];
            $fileName = $file['name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];
            $fileNameCmps = explode('.', $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $allowedExtn = ["ttf","TTF"];
            if (in_array($fileExtension, $allowedExtn)) {
                $uploadFileDir = getcwd() . '/assets/uploads/';
                $destFilePath = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTempPath, $destFilePath)) {
                    return $newFileName;
                }
            }

        }
    }
    public function getAllRows($table)
    {
        $this->tableFont = $table;
        $sql = "SELECT * FROM {$this->tableFont} ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $results = [];
        }
        return $results;
    }
    public function getAllRowsWitnCon($table,$where,$attr)
    {
        $this->tableFont = $table;
        $sql = "SELECT * FROM {$this->tableFont} WHERE {$attr}={$where} ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $results = [];
        }
        return $results;
    }
    public function url(){
        return sprintf(
          "%s://%s%s",
          isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
          $_SERVER['SERVER_NAME'],
          $_SERVER['REQUEST_URI']
        );
      }
}

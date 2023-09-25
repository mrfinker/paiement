<?php

/**
 *
 */
class Database extends PDO
{

    public function __construct()
    {
        parent::__construct(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    }

    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        $query = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $query->bindValue(":$key", $value);
        }
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Insert
     * @param string $table A name of table to Insert into
     * @param array $data An associative array
     */
    public function insert($table, array $data)
{
    $filedName = implode(',', array_keys($data)) . '';
    $filedValues = ':' . implode(',:', array_keys($data));
    $query = $this->prepare("INSERT INTO $table  ($filedName) VALUES ($filedValues)");
    foreach ($data as $key => $value) {
        $query->bindValue(":$key", $value);
    }
    
    // Exécutez la requête
    $result = $query->execute();

    // Vérifiez si la requête a réussi
    if ($result) {
        // Récupérez le dernier ID inséré
        $lastInsertId = $this->lastInsertId();

        // Retournez le dernier ID inséré
        return $lastInsertId;
    } else {
        return false;
    }
}

    /**
     * update
     * @param string $table A name of table to Insert into
     * @param array $data An associative array
     * @param array $where the WHERE query part associative array
     */
    public function update($table, array $data, $where)
    {
        ksort($data);
        // print_r($data);
        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key` = :$key, ";
        }
        $fieldDetails = rtrim($fieldDetails, ', ');

        $query = $this->prepare("UPDATE  $table SET $fieldDetails  WHERE  $where");
        foreach ($data as $key => $value) {
            $query->bindValue(":$key", $value);
        }
        return $query->execute();
    }

    public function delete($table, $where, $limit = 1)
    {
        return $this->exec("DELETE FROM $table WHERE $where ");
        // $query->execute();
    }
}

<?php

class Database {
    private $conn;

    public function __construct($dbHost, $dbUser, $dbPassword, $dbName) {
        try {
            $this->conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("<h1>La connexion à la base de données a échoué : " . $e->getMessage() . "</h1>");
        }
    }

    public function getConnection() {
        return $this->conn;
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

  public function insert($table, array $data)
  {
    $filedName = implode(',', array_keys($data)) . '';
    $filedValues = ':' . implode(',:', array_keys($data));
    // print_r($filedName);
    $query = $this->prepare("INSERT INTO $table  ($filedName) VALUES ($filedValues)");
    foreach ($data as $key => $value) {
      $query->bindValue(":$key", $value);
    }
    return $query->execute();
  }

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


?>
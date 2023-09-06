<?php
/**
 *
 */
class Model
{
    public $db;

    public function __construct()
    {
        $this->db = new Database();
        // parrent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTIONS);
    }

    public function find()
    {
        # code...
        // exemple
        //return $this->db->select("SELECT * FROM name_table");
    }
    public function get_total_all_records($query)
    {
        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->rowCount();
    }
    // Select all from a table
    public function getAll($table)
    {
        $query = "SELECT * FROM $table";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        return $rows;
    }

}

<?php

class Superadmin_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function threeLast(string $id)
    {
        return $this->db->select("SELECT * FROM users ORDER BY id DESC LIMIT 3", array("id" => $id));
    }

}

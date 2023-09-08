<?php

class Dashboard_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function threeLast()
    {
        return $this->db->select("SELECT * FROM users ORDER BY id DESC LIMIT 3");
    }

}

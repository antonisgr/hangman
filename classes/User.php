<?php

class User
{
    public $name;
    public $username;
    public $id;
    public $password;
    public $isAdmin;

    /**
     * User constructor.
     *
     * @param $name
     * @param $username
     * @param $id
     * @param $password
     * @param $isAdmin
     */
    public function __construct($name, $username, $password = '', $isAdmin = false, $id = '')
    {
        $this->name = $name;
        $this->username = $username;
        $this->id = $id;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Returns a User object if exists in database.
     *
     * @param $username
     * @param $db
     * @return bool|User
     */
    public static function getUser($username, $db)
    {
        $results = $db->prepared('SELECT * FROM users WHERE username=:username', [":username" => $username]);

        if ($results) {
            $anObj = $results[0]; // take 1st result, which is typeof stdClass
            return new User($anObj->name, $anObj->username, $anObj->password, $anObj->isAdmin, $anObj->id); // map to User
        }
        return false;
    }
}

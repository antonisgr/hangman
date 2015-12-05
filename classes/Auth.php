<?php

class Auth
{
    private $db;
    private $user;

    /**
     * Auth constructor.
     *
     * @param DB $db
     * @param User $user
     */
    public function __construct(DB $db, User $user)
    {
        $this->db = $db;
        $this->user = $user;
    }

    /**
     * Logins user. Parameter is plain text password.
     *
     * @param $password
     * @return bool
     */
    public function login($password)
    {
        if (password_verify($password, $this->user->password)) {
            $_SESSION['user'] = serialize($this->user); //save into session
            return true;
        }

        return false;
    }

    /**
     * Forces login.
     */
    public function forceLogin()
    {
        $_SESSION['user'] = serialize($this->user); //save into session
    }

    /**
     * Registers user.
     */
    public function register()
    {
        $password = password_hash($this->user->password, PASSWORD_DEFAULT);
        $this->db->insert('users', [
            'username' => $this->user->username,
            'password' => $password,
            'isAdmin' => false,
            'name' => $this->user->name
        ]);

        $this->user->password = $password; // update password attribute with the new password
        $this->user->id = $this->db->lastId(); // update id attribute with the id inserted
    }

    /**
     * Checks if user is logged in.
     *
     * @return bool
     */
    public static function isLoggedin()
    {
        return isset($_SESSION['user']) ? true : false;
    }

    /**
     * Logs out user.
     */
    public static function logout()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Returns authed user.
     *
     * @return User|null
     */
    public static function user()
    {
        return isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    }
}

<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
{

    /**
     * @var array Collection of error messages
     */
    public $errors = array();

    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        if (!isset($_SESSION)) {
            session_start();
        }

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        }
        elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        }
        elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // Create a database connection, using the constants from config/db.php (which we loaded in index.php).
            $connStr = 'host=' . DB_HOST . ' port=' . DB_PORT . ' dbname=' . DB_NAME . ' user='
                . DB_USER . ' password=' . DB_PASS;
            $conn = pg_connect($connStr);

            // Change character set to utf8 and check it.
            if (pg_set_client_encoding($conn, 'UTF8') !== 0) {
                $this->errors[] = pg_last_error($conn);
            }

            // If no connection errors (= working database connection)
            if (pg_connection_status($conn) == PGSQL_CONNECTION_OK) {

                // Database query, getting all the info of the selected user
                // (allows login via email address in the username field).
                $sql = 'select user_name, user_email, user_password_hash from users'
                    . ' where user_name = $1 or user_email = $1';
                $rs = pg_query_params($conn, $sql, array($_POST['user_name']));

                if ($rs === false) {
                    // There was an error while executing the query.
                    $this->errors[] = pg_last_error($conn);
                }
                else {
                    // If this user exists...
                    if (pg_num_rows($rs) == 1) {

                        // ...get the result row.
                        $result_row = pg_fetch_object($rs);

                        // Using PHP 5.5's password_verify() function to check if the provided password fits
                        // the hash of that user's password
                        if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {

                            // Write user data into PHP SESSION (a file on your server).
                            $_SESSION['user_name'] = $result_row->user_name;
                            $_SESSION['user_email'] = $result_row->user_email;
                            $_SESSION['user_login_status'] = 1;

                        }
                        else {
                            $this->errors[] = "Wrong password. Try again.";
                        }
                    }
                    else {
                        $this->errors[] = "This user does not exist.";
                    }
                }
            }
            else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }


    /**
     * Perform the logout.
     */
    public function doLogout()
    {
        // Delete the session of the user
        $_SESSION = array();
        session_destroy();

        // Return a little feeedback message
        $this->messages[] = "You have been logged out.";
    }


    /**
     * Return the current state of the user's login.
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }

        // Default return.
        return false;
    }

}

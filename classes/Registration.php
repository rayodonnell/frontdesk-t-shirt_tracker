<?php

/**
 * Class registration
 * handles the user registration
 */
class Registration
{
   /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();

    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function registerNewUser()
    {
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Empty Username";
        }
        elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->errors[] = "Empty Password";
        }
        elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
        }
        elseif (strlen($_POST['user_password_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        }
        elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        }
        elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        }
        elseif (empty($_POST['user_email'])) {
            $this->errors[] = "Email cannot be empty";
        }
        elseif (strlen($_POST['user_email']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        }
        elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
        }
        elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            // Create a database connection.
            $connStr = 'host=' . DB_HOST . ' port=' . DB_PORT . ' dbname=' . DB_NAME . ' user='
                . DB_USER . ' password=' . DB_PASS;
            $conn = pg_connect($connStr);

            // Change character set to utf8 and check it.
            if (pg_set_client_encoding($conn, 'UTF8') !== 0) {
                $this->errors[] = pg_last_error($conn);
            }

            // If no connection errors (= working database connection)
            if (pg_connection_status($conn) == PGSQL_CONNECTION_OK) {

                // Initial escaping, additionally removing everything that could be (html/javascript-) code.
                $user_name = strip_tags($_POST['user_name'], ENT_QUOTES);
                $user_email = strip_tags($_POST['user_email'], ENT_QUOTES);

                // Crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. The PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $user_password_hash = password_hash($_POST['user_password_new'], PASSWORD_DEFAULT);

                // check if user or email address already exists
                $sql = 'select * from users where user_name = $1 or user_email = $2';
                $rs = pg_query_params($conn, $sql, array($user_name, $user_email));

                if ($rs === false) {
                    // There was an error while executing the query.
                    $this->errors[] = pg_last_error($conn);
                }
                else {
                    if (pg_num_rows($rs) == 1) {
                        $this->errors[] = "Sorry, that username / email address is already taken.";
                    }
                    else {
                        // Write new user's data into database: return the new user ID as a
                        // way of checking that the recod was inserted OK.
                        $sql = 'insert into users (user_name, user_password_hash, user_email)'
                            . ' values($1, $2, $3)'
                            . ' returning user_id';
                        $rsInsert = pg_query_params($conn, $sql, array($user_name, $user_password_hash, $user_email));

                        if ($rsInsert === false) {
                            $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                        }
                        else {
                            $this->messages[] = "Your account has been created successfully. You can now log in.";
                        }
                    }
                }
            }
            else {
                $this->errors[] = "Sorry, no database connection.";
            }
        }
        else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}

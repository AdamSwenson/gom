<?php
namespace App\classes\UserManagement\maker;

class CredentialGenerator implements ICredentialGenerator
{
    const USERNAME_LENGTH = 16;
    const PASSWORD_LENGTH = 20;
    const DB_NAME_PREFIX = 'gom_';

    /**
     * Creates random strings to be used as database user names and passwords
     * @param string $salt Salt to be used
     * @param int $startposition Position in the hashed string to start the value at
     * @param int $length Length of generated credential
     * @return string
     */
    private static function generate($salt, $startposition, $length)
    {
        $a = password_hash($salt . microtime(), PASSWORD_BCRYPT);
        $b = substr($a, $startposition, $length);
        return $b;
    }

    public function make_username()
    {
        $td = mcrypt_module_open (MCRYPT_RIJNDAEL_256, "", MCRYPT_MODE_CBC, "");
        $usernameSalt = mcrypt_create_iv (mcrypt_enc_get_iv_size ($td), MCRYPT_DEV_RANDOM);
        $usernameStart = 3;
        return self::generate($usernameSalt, $usernameStart, self::USERNAME_LENGTH);
    }

    public function make_password()
    {
       $td = mcrypt_module_open (MCRYPT_RIJNDAEL_256, "", MCRYPT_MODE_CBC, "");
        $passwordSalt = mcrypt_create_iv (mcrypt_enc_get_iv_size ($td), MCRYPT_DEV_RANDOM);
        $passwordStart = 7;
        return self::generate($passwordSalt, $passwordStart, self::PASSWORD_LENGTH);
    }

    /**
     * This makes a standardized name for the user's database
     * @param  int  $databaseID The automatically generated id of the database
     * @return string
     */
    public function make_db_name($databaseID)
    {
        return self::DB_NAME_PREFIX . $databaseID;
    }

}

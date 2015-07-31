<?php

use Base\User;
use Illuminate\Support\Facades\Auth;
use Map\UserTableMap;
use Propel\Runtime\ActiveQuery\Criteria;

use Propel\Runtime\Propel;



trait SeederTraits
{

    public $user;
    public $faker;

    public function setUp()
    {
        $this->faker = \Faker\Factory::create();
        $this->getUser();
    }

    public function getUser($user_id=1)
    {
        $result = \UserQuery::create()->filterById($user_id)->findOne();
        if (!$result)
        {
        $this->makeUser($user_id);
        }
        $this->user = \UserQuery::create()->filterById($user_id)->findOne();

        Auth::loginUsingId($user_id);
    }

    public function makeUser($user_id=1)
    {
        $query = "INSERT INTO `users` (`id`, `username`, `displayname`, `password`, `email`, `activation_token`, `last_activation_request`, `lost_password_request`, `active`, `title`, `sign_up_stamp`, `last_sign_in_stamp`)
                VALUES (:userid, :username, :username, :password, :email, :activation, 1433864705, 0, 0, 'Teacher', 1433864705, 0)";
        $con = Propel::getWriteConnection(UserTableMap::DATABASE_NAME);
        if($user_id === 1){
            $vals = ['userid' => $user_id,
                'username' => 'scratchUser1',
                'password' => 'd673ce55ca650ab8fd9be35be51c8cd2a40884b7aa3d8192aebad52fafb77d041',
                'email' => 'nicomachus@gmail.com',
                'activation' => 'c279f3d4272d2a4bf0f9cf54712ba766'];
        }else{
            $vals = [
                'userid' => $user_id,
                'username' => $this->faker->userName(),
                'password' => $this->faker->sha1(),
                'email' => $this->faker->email(),
                'activation' => $this->faker->sha1
            ];
        }
        $stmt = $con->prepare($query, $vals);
        $stmt->execute();
    }

}
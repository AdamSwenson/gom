<?php

use Illuminate\Database\Seeder;

class AccessKeysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('access_keys')->delete();

        $query = <<<MYSQL
INSERT INTO `access_keys` (`id`, `access_key`, `student_id`, `exam_id`, `email_sent`, `access_expires`, `created_at`, `updated_at`, `student_info`)
VALUES
	(1, '634b0f6bb2e56e46da6ab48d284d08b101ec1aa168cd715a9a0e570f5947135b', 1, 1, 0, '2019-01-01', '2016-05-14 09:53:50', '2016-05-14 09:53:50', '{\"studentName\":\"name1\", \"studentIdentifier\":\"identifier1\"}');
MYSQL;
        DB::insert($query);

        //
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(ExamTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
        $this->call(ElementTableSeeder::class);
        $this->call(StudentTableSeeder::class);
        $this->call(KumiTableSeeder::class);
        //$this->call('ItemSeeder');
        //$this->call('ItemAssignmentSeeder');
        Model::reguard();
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('domain')->insert([
            'name' => 'default',
        ]);

        DB::table('key')->insert([
            'domain_id' => 1,
            'key' => str_random(64),
            'comment' => 'Example key'
        ]);

        DB::table('account')->insert([
            'domain_id' => 1,
            'name' => 'example',
            'password' => 'secret',
            'status' => 1,
            'relative_dir' => 'example_dir',
        ]);
    }
}

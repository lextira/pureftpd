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
        \App\Data\Models\Domain::create([
            'name' => 'default',
        ]);

        \App\Data\Models\Key::create([
            'domain_id' => 1,
            'token' => str_random(64),
            'description' => 'Example key'
        ]);

        \App\Data\Models\Account::create([
            'domain_id' => 1,
            'login' => 'example',
            'password' => 'secret',
            'status' => 1,
            'relative_dir' => 'example_dir',
        ]);
    }
}

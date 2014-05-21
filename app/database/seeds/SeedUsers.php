<?php
/**
 * Created by PhpStorm.
 * User: chrissmits
 * Date: 21/05/14
 * Time: 17:47
 */

class SeedUsers extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
                'username' => 'admin',
                'email' => 'admin@ws.com',
                'password' => 'vetcool08',
                'password_confirmation' => 'vetcool08',
                'confirmed' => 1
            )
        );
    }

}
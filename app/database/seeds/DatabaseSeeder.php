<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        $this->call('SeedUsers');
        $this->call('SeedCategories');
        $this->call('SeedProducts');
        $this->call('SeedStatus');
	}

}
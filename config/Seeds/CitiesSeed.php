<?php

use Migrations\AbstractSeed;

/**
 * Cities seed.
 */
class CitiesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->seed(1234);
        $data = [];
        for ($i = 0; $i < 2000; $i++) {
            $data[] = [
                'name'          => $faker->unique()->city, 
                'country_id'    => $faker->numberBetween(1,194),
            ];
        }
        #var_dump($data);
        
        $table = $this->table('cities');
        $table->insert($data)->save();
    }
}

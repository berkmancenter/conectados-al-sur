<?php
use Migrations\AbstractSeed;

/**
 * Countries seed.
 */
class CountriesSeed extends AbstractSeed
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
        $data = [];
        for ($i = 0; $i < 2000; $i++) {
            try {
                $data[] = [
                    'name' => $faker->unique()->country,
                ];
            } catch (\OverflowException $e) {
                break;
            }
        }
        sort($data);
        #var_dump($data);
        
        $table = $this->table('countries');
        $table->insert($data)->save();
    }
}

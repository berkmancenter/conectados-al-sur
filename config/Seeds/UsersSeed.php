<?php
use Migrations\AbstractSeed;

class UsersSeed extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->seed(1111);
        $data = [];
        $offset = 8;
        for ($i = 1 + $offset; $i < 50; $i++) {
            $created  = $faker->dateTimeThisDecade;
            $modified = $faker->dateTimeBetween($startDate = $created, $endDate = 'now', $timezone = null);

            $data[] = [
                'name'          => $faker->name, 
                'email'         => $faker->unique()->email,
                'contact'       => $faker->unique()->email,
                'password'      => $faker->password,
                'role_id'       => 0,
                'genre_id'      => $faker->numberBetween(1,3),
                'main_organization'    => $faker->company,
                'created'       => $created->format('Y-m-d H:i:s'),
                'modified'      => $modified->format('Y-m-d H:i:s'),
            ];
        }
        #var_dump($data);
        
        $table = $this->table('users');
        $table->insert($data)->save();
    }
}

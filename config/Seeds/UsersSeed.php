<?php
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
        $faker->seed(1111); # fixed number! --> same results
        $data = [];
        $offset = 6;
        for ($i = 0 + $offset; $i < 50; $i++) {
            $created  = $faker->dateTimeThisDecade;
            $modified = $faker->dateTimeBetween($startDate = $created, $endDate = 'now', $timezone = null);

            $instance_id = 1;
            $min_org_id = 2;
            $max_org_id = 10;
            if ($i > 30) {
                $instance_id = 2;
                $min_org_id = 12;
                $max_org_id = 15;
            }

            $data[] = [
                'id'            => $i,
                'name'          => $faker->name, 
                'email'         => $faker->unique()->email,
                'contact'       => $faker->unique()->email,
                'password'      => $faker->password,
                'role_id'       => 0,
                'instance_id'   => $instance_id,
                'genre_id'      => $faker->numberBetween(1,3),
                'main_organization'    => $faker->company,
                'organization_type_id' => $faker->numberBetween($min_org_id,$max_org_id),
                'created'       => $created->format('Y-m-d H:i:s'),
                'modified'      => $modified->format('Y-m-d H:i:s'),
            ];
        }
        #var_dump($data);
        
        $table = $this->table('users');
        $table->insert($data)->save();
    }
}

<?php
use Migrations\AbstractSeed;

class InstancesUsersSeed extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->seed(1111);
        $data = [];
        $offset = 8;
        for ($i = 1 + $offset; $i < 50; $i++) {

            $instance_id = 1;
            if ($i > 30) {
                $instance_id = 2;
            }
            $data[] = [
                'user_id'       => $i,
                'instance_id'   => $instance_id
            ];


            if (rand(0,1) == 0) {

                $other_instance_id = 2;
                if ($instance_id == 2) {
                    $other_instance_id = 1;
                }
                $data[] = [
                    'user_id'       => $i,
                    'instance_id'   => $other_instance_id
                ];
            }

        }
        #var_dump($data);
        
        $table = $this->table('instances_users');
        $table->insert($data)->save();
    }
}

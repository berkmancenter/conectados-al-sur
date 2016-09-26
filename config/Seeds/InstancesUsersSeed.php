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

            // register user
            $data[] = [
                'instance_id'   => 1,
                'user_id'       => $i,
                'role_id'       => 0,
                'contact'       => $faker->unique()->email,
                'main_organization' => '[null]',
                'organization_type_id' => 1
            ];
            
            $instance_id = 2;
            $min_org_id = 3;
            $max_org_id = 11;
            if ($i > 30) {
                $instance_id = 3;
                $min_org_id = 13;
                $max_org_id = 16;
            }
            $data[] = [
                'user_id'       => $i,
                'instance_id'   => $instance_id,
                'contact'       => $faker->unique()->email,
                'role_id'       => 0,
                'main_organization' => $faker->company,
                'organization_type_id' => $faker->numberBetween($min_org_id,$max_org_id)
            ];


            if (rand(0,1) == 0) {

                $other_instance_id = 3;
                $min_org_id = 13;
                $max_org_id = 16;
                if ($instance_id == 3) {
                    $other_instance_id = 2;
                    $min_org_id = 3;
                    $max_org_id = 11;
                }
                $data[] = [
                    'user_id'       => $i,
                    'instance_id'   => $other_instance_id,
                    'contact'       => $faker->unique()->email,
                    'role_id'       => 0,
                    'main_organization'    => $faker->company,
                    'organization_type_id' => $faker->numberBetween($min_org_id,$max_org_id)
                ];
            }

        }
        #var_dump($data);
        
        $table = $this->table('instances_users');
        $table->insert($data)->save();
    }
}

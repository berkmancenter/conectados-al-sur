<?php
use Migrations\AbstractSeed;

/**
 * Projects seed.
 */
class CategoriesProjectsSeed extends AbstractSeed
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
        $categories = [];
        for ($i = 0; $i < 300; $i++) {
           
            $faker->unique($reset = true);
            $categories[] = [
                'project_id'    => $i,
                'category_id'   => $faker->unique()->numberBetween(1,18),
            ];
            for ($k = 0; $k < 3; $k++) {
                if ( rand(0,1) == 0) {
                    $categories[] = [
                        'project_id'    => $i,
                        'category_id'   => $faker->unique()->numberBetween(1,18),
                    ];
                }
            }
        }
        sort($categories);
        #var_dump($categories);
        
        $categories_table = $this->table('categories_projects');
        $categories_table->insert($categories)->save();
    }
}

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
        $faker->seed(1111);
        $categories = [];
        for ($i = 1; $i < 400; $i++) {
           
            $min_cat_id = 2;
            $max_cat_id = 19;
            if ($i > 300) {
                $min_cat_id = 21;
                $max_cat_id = 24;
            }

            $faker->unique($reset = true);
            $categories[] = [
                'project_id'    => $i,
                'category_id'   => $faker->unique()->numberBetween($min_cat_id,$max_cat_id),
            ];
            for ($k = 0; $k < 3; $k++) {
                if ( rand(0,1) == 0) {
                    $categories[] = [
                        'project_id'    => $i,
                        'category_id'   => $faker->unique()->numberBetween($min_cat_id,$max_cat_id),
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

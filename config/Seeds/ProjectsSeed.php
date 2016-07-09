<?php
use Migrations\AbstractSeed;

/**
 * Projects seed.
 */
class ProjectsSeed extends AbstractSeed
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
        $cat_faker = Faker\Factory::create();
        $faker->seed(1234);
        $cat_faker->seed(1234);
        $data = [];
        $categories = [];
        for ($i = 0; $i < 15; $i++) {
            $created  = $faker->dateTimeThisYear;
            $modified = $faker->dateTimeBetween($startDate = $created, $endDate = 'now', $timezone = null);

            $start  = $faker->dateTimeThisCentury;
            $finish = $faker->dateTimeBetween($startDate = $start, $endDate = 'now', $timezone = null);

            $data[] = [
                'name'          => $faker->unique()->sentence($nbWords = 6), 
                'user_id'       => $faker->numberBetween(1,10),
                'description'   => $faker->paragraph($nbSentences = 3),
                'url'           => $faker->url,
                'contribution'  => $faker->paragraph($nbSentences = 2),
                'contributing'  => $faker->paragraph($nbSentences = 4),
                'organization'  => $faker->company,
                'organization_type_id' => $faker->numberBetween(1,5),
                'project_stage_id'     => $faker->numberBetween(1,5),
                'city_id'              => $faker->numberBetween(1,200),
                'created'       => $created->format('Y-m-d H:i:s'),
                'modified'      => $modified->format('Y-m-d H:i:s'),
                'start_date'    => $start->format('Y-m-d'),
                'finish_date'   => $finish->format('Y-m-d'),
            ];

            $cat_faker->unique($reset = true);
            $categories[] = [
                'project_id'    => $i,
                'category_id'   => $cat_faker->unique()->numberBetween(1,18),
            ];
            for ($k = 0; $k < 3; $k++) {
                if ( rand(0,1) == 0) {
                    $categories[] = [
                        'project_id'    => $i,
                        'category_id'   => $cat_faker->unique()->numberBetween(1,18),
                    ];
                }
            }
        }
        sort($categories);
        #var_dump($data);
        #var_dump($categories);
        
        $table = $this->table('projects');
        $categories_table = $this->table('categories_projects');

        ## ejecutar en orden (correr script dos veces y comentar):
        # primero esto
        $table->insert($data)->save();

        # luego esto
        #$categories_table->insert($categories)->save();
    }
}

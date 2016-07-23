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
        $country_ids =
        [4, 8, 10, 12, 16, 20, 24, 28, 31, 32, 36, 40, 44, 48, 50, 51, 52, 56, 60, 64,
         68, 70, 72, 74, 76, 84, 90, 92, 96, 100, 104, 108, 112, 116, 120, 124, 132, 
         136, 140, 144, 148, 152, 156, 158, 162, 166, 170, 174, 175, 178, 180, 184,
         188, 191, 192, 196, 203, 204, 208, 212, 214, 218, 222, 226, 231, 232, 233,
         234, 238, 239, 242, 246, 250, 254, 258, 262, 266, 268, 270, 276, 288, 292,
         296, 300, 304, 308, 316, 320, 324, 328, 332, 334, 336, 340, 344, 348, 352,
         356, 360, 364, 368, 372, 376, 380, 384, 388, 392, 398, 400, 404, 408, 410,
         414, 417, 418, 422, 426, 428, 430, 434, 438, 440, 442, 446, 450, 454, 458,
         462, 466, 470, 478, 480, 484, 492, 496, 498, 499, 500, 504, 508, 512, 516,
         520, 524, 528, 531, 533, 534, 540, 548, 554, 558, 562, 566, 570, 574, 578,
         580, 581, 583, 584, 585, 586, 591, 598, 600, 604, 608, 612, 616, 620, 624,
         626, 630, 634, 638, 642, 643, 646, 652, 654, 660, 662, 663, 666, 670, 674,
         678, 682, 686, 688, 690, 694, 702, 703, 704, 705, 706, 710, 716, 724, 728,
         729, 732, 740, 744, 748, 752, 756, 760, 762, 764, 768, 772, 776, 780, 784,
         788, 792, 795, 796, 798, 800, 804, 807, 818, 826, 831, 832, 833, 834, 840,
         850, 854, 858, 860, 862, 876, 882, 887, 894];

        $faker = Faker\Factory::create();
        $cat_faker = Faker\Factory::create();
        $faker->seed(1234);
        $cat_faker->seed(1234);
        $data = [];
        $categories = [];
        for ($i = 0; $i < 300; $i++) {

            $created  = $faker->dateTimeThisYear;
            $modified = $faker->dateTimeBetween($startDate = $created, $endDate = 'now', $timezone = null);

            $start  = $faker->dateTimeThisCentury;
            $finish = $faker->dateTimeBetween($startDate = $start, $endDate = 'now', $timezone = null);

            // country: prefer CHILE, ARGENTINA, BRASIL
            $country_id = 152;
            if ($i < 5) {
                $country_id = 152; // 5 for chile
            } else if ($i < 25) {
                $country_id = 32;  // 20 for argentina
            } else if ($i < 75) {
                $country_id = 76;  // 50 for brasil
            } else {
                $country_id = $country_ids[$faker->numberBetween(1,count($country_ids)-1)];
            }

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
                'country_id'           => $country_id,
                'city_id'              => 0,
                'created'       => $created->format('Y-m-d H:i:s'),
                'modified'      => $modified->format('Y-m-d H:i:s'),
                'start_date'    => $start->format('Y-m-d'),
                'finish_date'   => $finish->format('Y-m-d'),
            ];

            $cat_faker->unique($reset = true);
            $categories[] = [
                'project_id'    => $i+1,
                'category_id'   => $cat_faker->unique()->numberBetween(1,18),
            ];
            for ($k = 0; $k < 3; $k++) {
                if ( rand(0,1) == 0) {
                    $categories[] = [
                        'project_id'    => $i+1,
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

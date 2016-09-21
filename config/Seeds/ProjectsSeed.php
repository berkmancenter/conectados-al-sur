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
        $country_ids = [
             4,   8,  10,  12,  16,  20,  24,  28,  31,  32,  36,  40,  44,  48,  50,
            51,  52,  56,  60,  64,  68,  70,  72,  76,  84,  90,  92,  96, 100, 104,
           108, 112, 116, 120, 124, 132, 136, 140, 144, 148, 152, 156, 158, 170, 174,
           178, 180, 184, 188, 191, 192, 196, 203, 204, 208, 212, 214, 218, 222, 226,
           231, 232, 233, 234, 238, 242, 246, 250, 254, 258, 260, 262, 266, 268, 270, 
           275, 276, 288, 292, 296, 300, 304, 308, 316, 320, 324, 328, 332, 336, 340, 
           344, 348, 352, 356, 360, 364, 368, 372, 376, 380, 384, 388, 392, 398, 400, 
           404, 408, 410, 414, 417, 418, 422, 426, 428, 430, 434, 438, 440, 442, 446, 
           450, 454, 458, 462, 466, 470, 478, 480, 484, 492, 496, 498, 499, 500, 504, 
           508, 512, 516, 520, 524, 528, 533, 540, 548, 554, 558, 562, 566, 570, 574, 
           578, 580, 583, 584, 585, 586, 591, 598, 600, 604, 608, 612, 616, 620, 624, 
           626, 630, 634, 638, 642, 643, 646, 654, 659, 660, 662, 666, 670, 674, 678, 
           682, 686, 688, 690, 694, 702, 703, 704, 705, 706, 710, 716, 724, 728, 729, 
           732, 740, 744, 748, 752, 756, 760, 762, 764, 768, 772, 776, 780, 784, 788, 
           792, 795, 796, 798, 800, 804, 807, 818, 826, 833, 834, 840, 850, 854, 858, 
           860, 862, 876, 882, 887
        ];

        $city_ids = [ 0 ];

        $faker = Faker\Factory::create();
        $faker->seed(1111);
        $data = [];
        for ($i = 1; $i < 400; $i++) {

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

            $instance_id = 2;
            $min_org_id = 3;
            $max_org_id = 11;

            $valid_user_ids = [1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30];
            $user_list_id = $faker->numberBetween(0, count($valid_user_ids)-1);
            if ($i > 300) {
                $instance_id = 3;
                $min_org_id = 13;
                $max_org_id = 16;

                $valid_user_ids = [1, 2, 5, 6, 7, 8, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49];
                $user_list_id = $faker->numberBetween(0, count($valid_user_ids)-1);
            }
            $user_id = $valid_user_ids[$user_list_id];

            $data[] = [
                'name'          => $faker->unique()->sentence($nbWords = 4), 
                'user_id'       => $user_id,
                'instance_id'   => $instance_id,
                'description'   => $faker->paragraph($nbSentences = 2),
                'url'           => $faker->url,
                'contribution'  => $faker->paragraph($nbSentences = 2),
                'contributing'  => $faker->paragraph($nbSentences = 4),
                'organization'  => $faker->company,
                'organization_type_id' => $faker->numberBetween($min_org_id,$max_org_id),
                'project_stage_id'     => $faker->numberBetween(1,5),
                'country_id'           => $country_id,
                'city_id'              => 0,//$city_ids[$faker->numberBetween(0,count($city_ids)-1)],
                'latitude'      => $faker->randomFloat(4, -70, 70),
                'longitude'     => $faker->randomFloat(4, -170,170),
                'created'       => $created->format('Y-m-d H:i:s'),
                'modified'      => $modified->format('Y-m-d H:i:s'),
                'start_date'    => $start->format('Y-m-d'),
                'finish_date'   => $finish->format('Y-m-d'),
            ];
        }
        #var_dump($data);        
        $table = $this->table('projects');
        $table->insert($data)->save();
    }
}

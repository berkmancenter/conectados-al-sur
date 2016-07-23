<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CountriesFixture
 *
 */
class CountriesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'cod_n3' => ['type' => 'string', 'fixed' => true, 'length' => 3, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'latitude' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'longitude' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'name_en' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'name_es' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'cod_n3' => 'L',
            'latitude' => 1,
            'longitude' => 1,
            'name_en' => 'Lorem ipsum dolor sit amet',
            'name_es' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}

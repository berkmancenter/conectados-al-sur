<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrganizationTypesFixture
 *
 */
class OrganizationTypesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 100, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'name_es' => ['type' => 'string', 'length' => 100, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'fixed' => null],
        'instance_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'instance_id'], 'length' => []],
            'organization_types_id_key' => ['type' => 'unique', 'columns' => ['id'], 'length' => []],
            'organization_types_name_key' => ['type' => 'unique', 'columns' => ['name'], 'length' => []],
            'organization_types_name_es_key' => ['type' => 'unique', 'columns' => ['name_es'], 'length' => []],
            'organization_types_instance_id_fkey' => ['type' => 'foreign', 'columns' => ['instance_id'], 'references' => ['instances', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
            'name' => 'Lorem ipsum dolor sit amet',
            'name_es' => 'Lorem ipsum dolor sit amet',
            'instance_id' => 1
        ],
    ];
}

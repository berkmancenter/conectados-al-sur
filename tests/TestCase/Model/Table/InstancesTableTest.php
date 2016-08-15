<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstancesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstancesTable Test Case
 */
class InstancesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InstancesTable
     */
    public $Instances;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.instances',
        'app.categories',
        'app.projects',
        'app.users',
        'app.genres',
        'app.organization_types',
        'app.project_stages',
        'app.countries',
        'app.subcontinents',
        'app.continents',
        'app.cities',
        'app.categories_projects'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Instances') ? [] : ['className' => 'App\Model\Table\InstancesTable'];
        $this->Instances = TableRegistry::get('Instances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Instances);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategoriesProjectsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategoriesProjectsTable Test Case
 */
class CategoriesProjectsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CategoriesProjectsTable
     */
    public $CategoriesProjects;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.categories_projects',
        'app.projects',
        'app.users',
        'app.roles',
        'app.instances',
        'app.categories',
        'app.organization_types',
        'app.genres',
        'app.project_stages',
        'app.countries',
        'app.subcontinents',
        'app.continents',
        'app.cities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CategoriesProjects') ? [] : ['className' => 'App\Model\Table\CategoriesProjectsTable'];
        $this->CategoriesProjects = TableRegistry::get('CategoriesProjects', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CategoriesProjects);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

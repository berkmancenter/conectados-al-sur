<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectStagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectStagesTable Test Case
 */
class ProjectStagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectStagesTable
     */
    public $ProjectStages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.project_stages',
        'app.projects',
        'app.users',
        'app.genres',
        'app.organization_types',
        'app.cities',
        'app.countries',
        'app.cities_countries',
        'app.categories',
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
        $config = TableRegistry::exists('ProjectStages') ? [] : ['className' => 'App\Model\Table\ProjectStagesTable'];
        $this->ProjectStages = TableRegistry::get('ProjectStages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProjectStages);

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
}

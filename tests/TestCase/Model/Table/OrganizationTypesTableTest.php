<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrganizationTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrganizationTypesTable Test Case
 */
class OrganizationTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrganizationTypesTable
     */
    public $OrganizationTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.organization_types',
        'app.projects',
        'app.users',
        'app.genres',
        'app.project_stages',
        'app.countries',
        'app.cities',
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
        $config = TableRegistry::exists('OrganizationTypes') ? [] : ['className' => 'App\Model\Table\OrganizationTypesTable'];
        $this->OrganizationTypes = TableRegistry::get('OrganizationTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrganizationTypes);

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

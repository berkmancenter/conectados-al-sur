<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CitiesCountriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CitiesCountriesTable Test Case
 */
class CitiesCountriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CitiesCountriesTable
     */
    public $CitiesCountries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cities_countries',
        'app.countries',
        'app.cities',
        'app.projects',
        'app.users',
        'app.genres',
        'app.organization_types',
        'app.project_stages',
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
        $config = TableRegistry::exists('CitiesCountries') ? [] : ['className' => 'App\Model\Table\CitiesCountriesTable'];
        $this->CitiesCountries = TableRegistry::get('CitiesCountries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CitiesCountries);

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

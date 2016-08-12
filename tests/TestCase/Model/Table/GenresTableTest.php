<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GenresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GenresTable Test Case
 */
class GenresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GenresTable
     */
    public $Genres;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.genres',
        'app.users',
        'app.organization_types',
        'app.projects',
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
        $config = TableRegistry::exists('Genres') ? [] : ['className' => 'App\Model\Table\GenresTable'];
        $this->Genres = TableRegistry::get('Genres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Genres);

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

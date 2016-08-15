<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContinentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContinentsTable Test Case
 */
class ContinentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContinentsTable
     */
    public $Continents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.continents',
        'app.subcontinents'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Continents') ? [] : ['className' => 'App\Model\Table\ContinentsTable'];
        $this->Continents = TableRegistry::get('Continents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Continents);

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

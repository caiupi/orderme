<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DesksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DesksTable Test Case
 */
class DesksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DesksTable
     */
    protected $Desks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Desks',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Desks') ? [] : ['className' => DesksTable::class];
        $this->Desks = $this->getTableLocator()->get('Desks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Desks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DesksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DesksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

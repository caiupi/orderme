<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DishsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DishsTable Test Case
 */
class DishsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DishsTable
     */
    protected $Dishs;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Dishs',
        'app.Carts',
        'app.Orders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Dishs') ? [] : ['className' => DishsTable::class];
        $this->Dishs = $this->getTableLocator()->get('Dishs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Dishs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DishsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

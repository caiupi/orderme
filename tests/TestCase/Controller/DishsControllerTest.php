<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\DishsController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\DishsController Test Case
 *
 * @uses \App\Controller\DishsController
 */
class DishsControllerTest extends TestCase
{
    use IntegrationTestTrait;


    public function getFixtures(): array
    {
        $this->addFixture('app.Dishs')
            ->addFixture('app.Carts');

        return parent::getFixtures();
    }
    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Dishs',
        'app.Carts',
        'app.Orders',
        'app.Users',
    ];
    protected function login($userId = 2)
    {
        $users = TableRegistry::getTableLocator()->get('Users');
        $user = $this->Users->get($userId);
        $this->session(['Auth' => $user]);
        //print_r($user);
    }
    public function setUp(): void
    {
        parent::setUp();
        $this->loadRoutes();
        $this->Dishs=$this->getTableLocator()->get('Dishs');
        $this->Users=$this->getTableLocator()->get('Users');
    }
    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\DishsController::index()
     */
    public function testIndex(): void
    {
        $query=$this->Dishs->find()->where(['id'=>1]);
        $result = $query->enableHydration(false)->toArray();
        $expected = [[
            'id' => 1,
            'name' => 'Toscano',
            'description' => 'Antipasto Toscano',
            'type' => 'Antipasto',
            'price' => 10,
        ],];
        $this->assertEquals($expected, $result);
        $query=$this->Dishs->find()->where(['id'=>2]);
        $result = $query->enableHydration(false)->toArray();
        $expected = [[
            'id' => 2,
            'name' => 'Toscano',
            'description' => 'Antipasto Toscano',
            'type' => 'Antipasto',
            'price' => 10,
        ],];
        $this->assertEquals($expected, $result);
        echo '-------------------';
        //$this->assertTrue(is_a($this->Dishs, 'DishsController'));
        //print_r($data);
        //$this->login(1);
        $this->get('/dishs');
        $this->assertResponseOk();
        $this->assertResponseContains('Dishs');


        //$this->assertResponseSuccess();

        //$this->assertTrue(!empty($dishs));

        //$this->get('/dishs');
        //$this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
        //$this->assertResponseOk();
        //$this->login(2);
        //$this->assertRedirect(['controller' => 'Dishs', 'action' => 'index']);
        //$this->assertResponseContains('Dishs');
        //$this->assertResponseSuccess();
        ///$this->assertRedirect(['controller' => 'Dishs', 'action' => 'index']);
        //$this->assertNoRedirect();
        //$this->assertRedirectContains('/dishs/index/');
        //$this->assertTemplate('index');
        //$this->assertHeaderContains('Content-Type', 'html');
    }
    public function testIndexWithLoginNormalUser()
    {
        $this->login(1);
        $this->get('/dishs/index');
        $this->assertResponseOk();
        $this->assertResponseContains('Dishs');
    }
    public function testIndexWithLoginAdmin()
    {
        $this->login(2);
        $this->get('/dishs/index');
        $this->assertRedirect(['controller' => 'Dishs', 'action' => 'admin']);
    }


    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\DishsController::view()
     */
    public function testView(): void
    {
        $this->login(2);
        $this->get('/dishs/view/');
        $this->assertResponseFailure();
        $this->get('/dishs/view/1');
        $this->assertResponseOk();
    }
    public function testViewWithNoLogin(){
        $this->get('/dishs/view');
        $this->assertRedirectContains('/users/login');
    }
    public function testViewWithLoginNormalUser(){
        $this->login(1);
        $this->get('/dishs/view');
        $this->assertRedirectContains('/dishs');
        $this->assertRedirect(['controller' => 'Dishs', 'action' => 'index']);
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\DishsController::add()
     */
    public function testAdd(): void
    {
        $this->login(2);
        $this->get('/dishs/add');
        //$this->assertResponseOk();
        //$this->assertResponseContains('Dishs');
        $data = [[
            //'id' => 3,
            'name' => 'Pesto',
            'description' => 'Spaghetti al pesto',
            'type' => 'Primi',
            'price' => 12,
        ],];
        $expected = [[
            'id' => 3,
            'name' => 'Toscano',
            'description' => 'Antipasto Toscano',
            'type' => 'Antipasto',
            'price' => 10,
        ],];
        $this->post('/dishs/add', $expected);
        //$this->assertResponseSuccess();
        $this->assertResponseOk();
        $query=$this->Dishs->find()->where(['id'=>3]);
        $result = $query->enableHydration(false)->toArray();
        //$this->post('/dishs/add/', $expected);
        //print_r($result);

        //$this->assertEquals($expected, $result);

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\DishsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\DishsController::delete()
     */
    public function testDelete(): void
    {

        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeFilter method
     *
     * @return void
     * @uses \App\Controller\DishsController::beforeFilter()
     */
    public function testBeforeFilter(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test admin method
     *
     * @return void
     * @uses \App\Controller\DishsController::admin()
     */
    public function testAdmin(): void
    {
        $this->login(2);
        $this->get('/dishs/admin');
        $this->assertResponseOk();
    }
    public function testAdminWithLoginNormalUser(){
        $this->login(1);
        $this->get('/dishs/admin');
        $this->assertHeaderContains('Content-Type', 'html');
        $this->assertRedirectContains('/dishs');
        $this->assertRedirect(['controller' => 'Dishs', 'action' => 'index']);
    }
    public function testAdminWithLoginAdmin()
    {
        $this->login(2);
        $this->get('/dishs/admin');
        $this->assertResponseOk();
        $this->assertResponseContains('Dishs');
    }
    public function testAdminWithNoLogin(){
        $this->get('/dishs/admin');
        //$this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
        $this->assertRedirectContains('/users/login');
    }

}

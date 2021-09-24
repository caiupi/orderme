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
    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Dishs',
        'app.Orders',
        'app.Users',
        'app.Desks',
    ];

    protected function login($userId = 2)
    {
        $user = $this->Users->get($userId);
        $this->session(['Auth' => $user]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->loadRoutes();
        $this->Dishs = $this->getTableLocator()->get('Dishs');
        $this->Users = $this->getTableLocator()->get('Users');
        $this->Desks = $this->getTableLocator()->get('Desks');
        $this->configRequest(['environment' => ['HTTPS' => 'on']]);
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\DishsController::index()
     */
    public function testIndex(): void
    {
        $this->get('/dishs/index');
        $this->assertResponseOk();
        $this->assertResponseContains('Dishs');
        $this->assertNoRedirect();
        $this->assertSession('Login if you need to order.', 'Flash.flash.0.message');
        $query = $this->Dishs->find()->where(['id' => 1]);
        $result = $query->enableHydration(false)->toArray();
        $expected = [[
            'id' => 1,
            'name' => 'Toscano',
            'description' => 'Antipasto Toscano',
            'type' => 'Antipasto',
            'price' => 10,
        ],];
        $this->assertEquals($expected, $result);
        $query = $this->Dishs->find()->where(['id' => 2]);
        $result = $query->enableHydration(false)->toArray();
        $expected = [[
            'id' => 2,
            'name' => 'Toscano',
            'description' => 'Antipasto Toscano',
            'type' => 'Antipasto',
            'price' => 10,
        ],];
        $this->assertEquals($expected, $result);
    }

    public function testIndexWithLoginNormalUser()
    {
        $this->login(1);
        $this->get('/dishs/index');
        $this->assertResponseOk();
        $this->assertNoRedirect();
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
        $this->assertNoRedirect();
    }

    public function testViewWithNoLogin()
    {
        $this->get('/dishs/view');
        $this->assertRedirectContains('/users/login');
    }

    public function testViewWithLoginNormalUser()
    {
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
        $this->assertResponseOk();
        $this->assertResponseContains('Dishs');
        $data = [[
            'id' => 3,
            'name' => 'Pesto',
            'description' => 'Spaghetti al pesto',
            'type' => 'Primi',
            'price' => 12,
        ],];
        $this->post('/dishs/add', $data[0]);
        $this->assertResponseSuccess();
        $query = $this->Dishs->find()->where(['id' => 3]);
        $result = $query->enableHydration(false)->toArray();
        $this->assertEquals($result, $data);
        $this->assertRedirect(['controller' => 'Dishs', 'action' => 'index']);
    }


    public function testAddWithLoginNormalUser()
    {
        $this->login(1);
        $this->get('/dishs/add');
        $this->assertRedirectContains('/dishs');
        $this->assertRedirect(['controller' => 'Dishs', 'action' => 'index']);
    }
    public function testWithOutNoLogin()
    {
        $this->get('/dishs/add');
        $this->assertRedirectContains('/users/login');
        $this->get('/dishs/edit');
        $this->assertRedirectContains('/users/login');
        $this->get('/dishs/delete');
        $this->assertRedirectContains('/users/login');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\DishsController::edit()
     */
    public function testEdit(): void
    {
        $this->login(2);
        $data = [[
            'id' => 1,
            'name' => 'Pesto',
            'description' => 'Spaghetti al pesto',
            'type' => 'Primi',
            'price' => 12,
        ],];
        $this->get('/dishs/edit');
        $this->assertResponseFailure();
        $this->get('/dishs/edit/1');
        $this->assertResponseOk();
        $this->patch('/dishs/edit/1',$data[0]);
        $this->assertResponseSuccess();
        $query = $this->Dishs->find()->where(['id' => 1]);
        $result = $query->enableHydration(false)->toArray();
        $this->assertEquals($result, $data);
        $this->assertRedirect(['controller' => 'Dishs', 'action' => 'index']);
    }
    public function testEditWithLoginNormalUser()
    {
        $this->login(1);
        $this->get('/dishs/edit');
        $this->assertHeaderContains('Content-Type', 'html');
        $this->assertRedirectContains('/dishs');
        $this->assertRedirect(['controller' => 'Dishs', 'action' => 'index']);
    }
    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\DishsController::delete()
     */
    public function testDelete(): void
    {
        $this->get('/dishs/delete');
        $this->assertRedirectContains('/users/login');
        $this->login(1);
        $this->get('/dishs/delete');
        $this->assertSession('You need to be an administrator for access the page.', 'Flash.flash.0.message');
        $this->assertRedirect(['controller' => 'Dishs', 'action' => 'index']);
    }
    public function testDeletedWithAdmin(){
        $this->login(2);
        $data = [[
            'id' => 3,
            'name' => 'Pesto',
            'description' => 'Spaghetti al pesto',
            'type' => 'Primi',
            'price' => 12,
        ],];
        $this->post('/dishs/add', $data[0]);
        $this->assertResponseSuccess();
        $this->delete('/dishs/delete/3');
        $this->assertSession('The dish has been deleted.', 'Flash.flash.0.message');
        $query = $this->Dishs->find();
        $result = $query->enableHydration(false)->toArray();
        $result_count = count($result);
        $expected_count = 2;
        $this->assertEquals($expected_count, $result_count);
    }

    /**
     * Test beforeFilter method
     *
     * @return void
     * @uses \App\Controller\DishsController::beforeFilter()
     */
    public function testBeforeFilter(): void
    {
        $this->get('/dishs/admin');
        $this->assertRedirectContains('/users/login');
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
        $this->assertNoRedirect();
        $this->assertResponseContains('Dishs');
    }

    public function testAdminWithLoginNormalUser()
    {
        $this->login(1);
        $this->get('/dishs/admin');
        $this->assertSession('You need to be an administrator for access the page.', 'Flash.flash.0.message');
        $this->assertRedirect(['controller' => 'Dishs', 'action' => 'index']);
    }

    public function testAdminWithLoginAdmin()
    {
        $this->login(2);
        $this->get('/dishs/admin');
        $this->assertHeaderContains('Content-Type', 'html');
        $this->assertResponseOk();
        $this->assertResponseContains('Dishs');
        $this->assertNoRedirect();
    }
}

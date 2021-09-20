<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CartsController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CartsController Test Case
 *
 * @uses \App\Controller\CartsController
 */
class CartsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Carts',
        'app.Users',
        'app.Dishs',
        'app.Desks',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\CartsController::index()
     */
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
        $this->Carts = $this->getTableLocator()->get('Carts');
        $this->Desks = $this->getTableLocator()->get('Desks');
        $this->configRequest(['environment' => ['HTTPS' => 'on']]);
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }
    public function testIndex(): void
    {
        $this->get('/carts');
        $this->assertRedirectContains('/users/login');
        $this->assertSession('First you need to login.', 'Flash.flash.0.message');
        $this->login(1);
        $this->get('/carts');
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
        $this->assertSession('First you need to reserve a table.', 'Flash.flash.0.message');
        $this->login(2);
        $this->get('/carts');
        $this->assertRedirect(['controller' => 'Carts', 'action' => 'admin']);
        $this->login(3);
        $this->get('/carts');
        $this->assertNoRedirect();
        $result_count = $this->Carts->find()->count();
        $expected_count = 3;
        $this->assertEquals($expected_count, $result_count);
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\CartsController::view()
     */
    public function testView(): void
    {
        $this->get('/carts/view');
        $this->assertRedirectContains('/users/login');
        $this->assertSession('First you need to login.', 'Flash.flash.0.message');
        $this->login(1);
        $this->get('/carts/view/');
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
        $this->assertSession('First you need to reserve a table.', 'Flash.flash.0.message');
        $this->login(2);
        $this->get('/carts/view/');
        $this->assertResponseFailure();
        $this->get('/carts/view/2');
        $this->assertResponseOk();
        $this->assertNoRedirect();
        $this->login(3);
        $this->get('/carts/view/');
        $this->assertRedirect(['controller' => 'Carts', 'action' => 'index']);
        $this->assertSession('You need to be an administrator for access the page.', 'Flash.flash.0.message');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\CartsController::add()
     */
    public function testAdd(): void
    {
        $this->login(3);
        $this->get('/carts/add/');
        $this->assertResponseFailure();
        $data = [            [
            'id' => 4,
            'user_id' => 3,
            'dish_id' => 2,
            'quantity' => 1,
        ],];
        $this->post('/carts/add/2', $data[0]);
        $this->assertResponseSuccess();
        $query = $this->Carts->find()->where(['id' => 4]);
        $result = $query->enableHydration(false)->toArray();
        $this->assertEquals($result, $data);
    }
    public function testAddWithLoginNormalUserWithNoTable(): void
    {
        $this->login(1);
        $this->get('/carts/add/');
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
        $this->assertSession('First you need to reserve a table.', 'Flash.flash.0.message');
    }
    public function testAddAdminUser(): void
    {
        $this->login(2);
        $this->get('/carts/add/');
        $this->assertResponseFailure();
        $data = [            [
            'id' => 4,
            'user_id' => 2,
            'dish_id' => 2,
            'quantity' => 1,
        ],];
        $this->post('/carts/add/2', $data[0]);
        $this->assertResponseSuccess();
        $query = $this->Carts->find()->where(['id' => 4]);
        $result = $query->enableHydration(false)->toArray();
        $this->assertEquals($result, $data);
    }
    public function testWithOutLogin()
    {
        $this->get('/desks/add');
        $this->assertRedirectContains('/users/login');
        $this->get('/desks/edit');
        $this->assertRedirectContains('/users/login');
        $this->get('/desks/delete');
        $this->assertRedirectContains('/users/login');
    }
    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\CartsController::edit()
     */
    public function testEdit(): void
    {
        $this->login(2);
        $this->get('/carts/edit/');
        $this->assertResponseFailure();
        $data = [            [
            'id' => 2,
            'user_id' => 2,
            'dish_id' => 2,
            'quantity' => 1,
        ],];
        $this->post('/carts/edit/2', $data[0]);
        $this->assertResponseSuccess();
        $query = $this->Carts->find()->where(['id' => 2]);
        $result = $query->enableHydration(false)->toArray();
        $this->assertEquals($result, $data);
    }
    public function testEditWithLoginNormalUserWithNoTable(): void
    {
        $this->login(1);
        $this->get('/carts/edit/');
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
        $this->assertSession('First you need to reserve a table.', 'Flash.flash.0.message');
    }
    public function testEditWithLoginNormalUserWithTable(): void
    {
        $this->login(1);
        $this->get('/carts/edit/');
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
        $this->assertSession('First you need to reserve a table.', 'Flash.flash.0.message');
    }
    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\CartsController::delete()
     */
    public function testDeleteWithLoginNormalUserWithNoTable(): void
    {
        $this->login(1);
        $this->get('/carts/delete/');
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
        $this->assertSession('First you need to reserve a table.', 'Flash.flash.0.message');
    }
    public function testDeleteWithLoginNormalUserWithTable(): void
    {
        $this->login(3);
        $this->delete('/carts/delete/3');
        $this->assertResponseSuccess();
        $this->assertSession('The dish has been deleted.', 'Flash.flash.0.message');
        $query = $this->Carts->find();
        $result = $query->enableHydration(false)->toArray();
        $result_count = count($result);
        $expected_count = 2;
        $this->assertEquals($expected_count, $result_count);
    }
    public function testDelete(): void
    {
        $this->login(2);
        $this->delete('/carts/delete/2');
        $this->assertResponseSuccess();
        $this->assertSession('The dish has been deleted.', 'Flash.flash.0.message');
        $query = $this->Carts->find();
        $result = $query->enableHydration(false)->toArray();
        $result_count = count($result);
        $expected_count = 2;
        $this->assertEquals($expected_count, $result_count);
    }
    public function testBeforeFilter(): void
    {
        $this->get('/carts/admin');
        $this->assertRedirectContains('/users/login');
        $this->assertSession('First you need to login.', 'Flash.flash.0.message');
    }
    public function testAdmin(): void
    {
        $this->login(2);
        $this->get('/carts/admin');
        $this->assertResponseOk();
        $this->assertNoRedirect();
    }
    public function testAdminWithLoginNormalUserWithNoTable()
    {
        $this->login(1);
        $this->get('/carts/admin');
        $this->assertHeaderContains('Content-Type', 'html');
        $this->assertRedirectContains('/desks');
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
    }
    public function testAdminWithLoginNormalUserWithTable()
    {
        $this->login(3);
        $this->get('/carts/admin');
        $this->assertHeaderContains('Content-Type', 'html');
        $this->assertRedirectContains('/carts');
        $this->assertRedirect(['controller' => 'Carts', 'action' => 'index']);
    }
}

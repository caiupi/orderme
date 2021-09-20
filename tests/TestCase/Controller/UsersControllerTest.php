<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */

    public $fixtures = [
        'app.Users',
        'app.Carts',
        'app.Desks',
        'app.Orders',
    ];

    protected function login($userId = 2)
    {
        $users = TableRegistry::getTableLocator()->get('Users');
        $user = $this->Users->get($userId);
        $this->session(['Auth' => $user]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->loadRoutes();
        $this->Desks = $this->getTableLocator()->get('Desks');
        $this->Users = $this->getTableLocator()->get('Users');
        $this->Carts = $this->getTableLocator()->get('Carts');
        $this->Orders = $this->getTableLocator()->get('Orders');
        $this->configRequest(['environment' => ['HTTPS' => 'on']]);
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }
    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\UsersController::index()
     */
    public function testIndex(): void
    {
        $this->get('/users');
        $this->assertRedirectContains('/users/login');
        $this->login(1);
        $this->get('/users');
        $this->assertNoRedirect();
        $result_count = $this->Users->find()->count();
        $expected_count = 3;
        $this->assertEquals($expected_count, $result_count);
        $this->login(2);
        $this->get('/users');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'admin']);
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\UsersController::view()
     */
    public function testView(): void
    {
        $this->login(2);
        $this->get('/users/view/');
        $this->assertResponseFailure();
        $this->get('/users/view/2');
        $this->assertResponseOk();
        $this->assertNoRedirect();
    }
    public function testViewWithNoLogin()
    {
        $this->get('/users/view');
        $this->assertRedirectContains('/users/login');
    }
    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\UsersController::add()
     */
    public function testAdd(): void
    {
        $this->login(2);
        $this->get('/users/add');
        $this->assertResponseOk();
        $this->assertResponseContains('/users');
        $data = [            [
            'id' => 4,
            'email' => 'user2@admin.com',
            'password' => 'user',
            'role' => 'user',
            'name' => 'Eduart',
        ],];
        $this->post('/users/add', $data[0]);
        $this->assertResponseSuccess();
        $query = $this->Users->find()->where(['id' => 4]);
        $result = $query->enableHydration(false)->toArray();
        $this->assertEquals($result[0]['id'], $data[0]['id']);
        $this->assertEquals($result[0]['email'], $data[0]['email']);
        $this->assertEquals($result[0]['role'], $data[0]['role']);
        $this->assertEquals($result[0]['name'], $data[0]['name']);
    }
    public function testAddWithLoginNormalUser()
    {
        $this->login(1);
        $this->get('/users/add');
        $this->assertResponseOk();
        $this->assertResponseContains('/users');
        $this->assertNoRedirect();
        $data = [            [
            'id' => 4,
            'email' => 'user2@admin.com',
            'password' => 'user',
            'role' => 'user',
            'name' => 'Eduart',
        ],];
        $this->post('/users/add', $data[0]);
        $this->assertResponseSuccess();
        $query = $this->Users->find()->where(['id' => 4]);
        $result = $query->enableHydration(false)->toArray();
        $this->assertEquals($result[0]['id'], $data[0]['id']);
        $this->assertEquals($result[0]['email'], $data[0]['email']);
        $this->assertEquals($result[0]['role'], $data[0]['role']);
        $this->assertEquals($result[0]['name'], $data[0]['name']);
    }
    public function testAddWithNoLoginUser()
    {
        $this->get('/users/add');
        $this->assertResponseOk();
        $this->assertResponseContains('/users');
        $this->assertNoRedirect();
        $data = [            [
            'id' => 4,
            'email' => 'user2@admin.com',
            'password' => 'user',
            'role' => 'user',
            'name' => 'Eduart',
        ],];
        $this->post('/users/add', $data[0]);
        $this->assertResponseSuccess();
        $query = $this->Users->find()->where(['id' => 4]);
        $result = $query->enableHydration(false)->toArray();
        $this->assertEquals($result[0]['id'], $data[0]['id']);
        $this->assertEquals($result[0]['email'], $data[0]['email']);
        $this->assertEquals($result[0]['role'], $data[0]['role']);
        $this->assertEquals($result[0]['name'], $data[0]['name']);
    }
    public function testWithOutNoLogin()
    {
        $this->get('/users/edit');
        $this->assertRedirectContains('/users/login');
        $this->get('/users/delete');
        $this->assertRedirectContains('/users/login');
        $this->get('/users/logout');
        $this->assertRedirectContains('/users/login');
    }
    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\UsersController::edit()
     */
    public function testEdit(): void
    {
        $this->login(2);
        $data = [            [
            'id' => 2,
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'role' => 'admin',
            'name' => 'Eduart',
        ],];
        $this->get('/users/edit');
        $this->assertResponseFailure();
        $this->get('/users/edit/2');
        $this->assertResponseOk();
        $this->patch('/users/edit/2',$data[0]);
        $this->assertResponseSuccess();
        $query = $this->Users->find()->where(['id' => 2]);
        $result = $query->enableHydration(false)->toArray();
        $this->assertEquals($result, $data);
        $this->assertRedirect(['controller' => 'Users', 'action' => 'index']);
    }
    public function testEditWithLoginNormalUser()
    {
        $this->login(1);
        $this->get('/users/edit');
        $this->assertResponseFailure();
    }
    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\UsersController::delete()
     */
    public function testDelete(): void
    {
        $this->login(2);
        $this->delete('/users/delete/1');
        $this->assertResponseFailure();
    }
    public function testBeforeFilter(): void
    {
        $this->get('/users/admin');
        $this->assertRedirectContains('/users/login');
        $this->assertRedirectContains('/users/login');
    }
    public function testAdminWithLoginNormalUser()
    {
        $this->login(1);
        $this->get('/users/admin');
        $this->assertHeaderContains('Content-Type', 'html');
        $this->assertRedirectContains('/users');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'index']);
    }
    public function testAdmin(): void
    {
        $this->login(2);
        $this->get('/users/admin');
        $this->assertResponseOk();
        $this->assertNoRedirect();
    }
    public function testLogin(){
        $this->get('/users/login');
        $this->assertResponseOk();
        $this->login(1);
        $this->get('/users/login');
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
        $this->login(2);
        $this->get('/users/login');
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
    }
    public function testLogout(){
        $this->get('/users/logout');
        $this->assertRedirectContains('/users/login');
        $this->login(1);
        $this->get('/users/logout');
        $this->assertRedirect(['controller' => 'Pages', 'action' => 'home']);
        $this->login(2);
        $this->get('/users/logout');
        $this->assertRedirect(['controller' => 'Pages', 'action' => 'home']);
    }

}

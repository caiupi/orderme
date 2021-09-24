<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\DesksController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\DesksController Test Case
 *
 * @uses \App\Controller\DesksController
 */
class DesksControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Desks',
        'app.Users',
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
        $this->configRequest(['environment' => ['HTTPS' => 'on']]);
        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\DesksController::index()
     */
    public function testIndex(): void
    {
        $this->get('/desks');
        $this->assertRedirectContains('/users/login');
        $this->login(1);
        $this->get('/desks');
        $this->assertNoRedirect();
        $result_count = $this->Desks->find()->count();
        $expected_count = 3;
        $this->assertEquals($expected_count, $result_count);
        $this->login(2);
        $this->get('/desks');
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'admin']);
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\DesksController::view()
     */
    public function testView(): void
    {
        $this->login(2);
        $this->get('/desks/view/');
        $this->assertResponseFailure();
        $this->get('/desks/view/2');
        $this->assertResponseOk();
        $this->assertNoRedirect();
    }

    public function testViewWithNoLogin()
    {
        $this->get('/desks/view');
        $this->assertRedirectContains('/users/login');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\DesksController::add()
     */
    public function testAdd(): void
    {
        $this->login(2);
        $this->get('/desks/add');
        $this->assertResponseOk();
        $this->assertResponseContains('Desks');
        $data = [[
            'id' => 4,
            'user_id' => 3,
            'available' => 0,
            'ordered' => 0,
        ],];
        $this->post('/desks/add', $data[0]);
        $this->assertResponseSuccess();
        $query = $this->Desks->find()->where(['id' => 4]);
        $result = $query->enableHydration(false)->toArray();
        $this->assertEquals($result, $data);
    }

    public function testAddWithLoginNormalUser()
    {
        $this->login(1);
        $this->get('/desks/add');
        $this->assertRedirectContains('/desks');
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
        $this->assertSession('You need to be an administrator for access the page.', 'Flash.flash.0.message');
    }
    public function testWithOutLogin()
    {
        $this->get('/desks/add');
        $this->assertRedirectContains('/users/login');
        $this->get('/desks/edit');
        $this->assertRedirectContains('/users/login');
        $this->get('/desks/delete');
        $this->assertRedirectContains('/users/login');
        $this->get('/desks/reserve');
        $this->assertRedirectContains('/users/login');
    }
    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\DesksController::edit()
     */
    public function testEdit(): void
    {
        $this->login(2);
        $data = [[
            'id' => 1,
            'user_id' => 1,
            'available' => 0,
            'ordered' => 0,
        ],];
        $this->get('/desks/edit');
        $this->assertResponseFailure();
        $this->get('/desks/edit/1');
        $this->assertResponseOk();
        $this->patch('/desks/edit/1',$data[0]);
        $this->assertResponseSuccess();
        $query = $this->Desks->find()->where(['id' => 1]);
        $result = $query->enableHydration(false)->toArray();
        $this->assertEquals($result, $data);
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
    }

    public function testEditWithLoginNormalUser()
    {
        $this->login(1);
        $this->get('/desks/edit');
        $this->assertHeaderContains('Content-Type', 'html');
        $this->assertRedirectContains('/desks');
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
    }
    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\DesksController::delete()
     */
    public function testDelete(): void
    {
        $this->login(1);
        $this->get('/desks/delete');
        $this->assertRedirect(['controller' => 'desks', 'action' => 'index']);
        $this->assertSession('You need to be an administrator for access the page.', 'Flash.flash.0.message');
        $this->login(2);
        $this->delete('/desks/delete/2');
        $this->assertSession('The desk has been deleted.', 'Flash.flash.0.message');
        $query = $this->Desks->find();
        $result = $query->enableHydration(false)->toArray();
        $result_count = count($result);
        $expected_count = 2;
        $this->assertEquals($expected_count, $result_count);
    }
    public function testBeforeFilter(): void
    {
        $this->get('/desks/admin');
        $this->assertRedirectContains('/users/login');
        $this->assertSession('First you need to login.', 'Flash.flash.0.message');
    }
    public function testAdmin(): void
    {
        $this->login(2);
        $this->get('/desks/admin');
        $this->assertResponseOk();
        $this->assertNoRedirect();
    }
    public function testAdminWithLoginNormalUser()
    {
        $this->login(1);
        $this->get('/desks/admin');
        $this->assertHeaderContains('Content-Type', 'html');
        $this->assertRedirectContains('/desks');
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
    }
    public function testReserve()
    {
        $this->login(1);
        $this->get('/desks/reserve/1');
        $this->assertSession('The desk number: 1 has been reserved.', 'Flash.flash.0.message');
        $this->assertRedirect(['controller' => 'Carts', 'action' => 'index']);
    }
    public function testReserveWithUserThatHaveReservedATable()
    {
        $this->login(3);
        $this->get('/desks/reserve/3');
        $this->assertSession('The desk could not be reserved. You have already reserved a table.', 'Flash.flash.0.message');
        $this->assertRedirect(['controller' => 'Desks', 'action' => 'index']);
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Dishs Controller
 *
 * @property \App\Model\Table\DishsTable $Dishs
 * @method \App\Model\Entity\Dish[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DishsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if (!$this->Authentication->getResult()->isValid()) {
            $this->Flash->set(__('Login if you need to order.'));
        } else {
            $user = $this->request->getAttribute('identity')->getOriginalData();
            if ($user->isAdmin()) {
                $this->Flash->set(__('You are redirected to the administration Dishes page'));
                return $this->redirect(['action' => 'admin']);
            }
        }
        $dishes = $this->paginate($this->Dishs->find()
            ->select(['name', 'description', 'type', 'price']));
        $this->set(compact('dishes'));
    }

    /**
     * View method
     *
     * @param string|null $id Dish id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if (!$this->Authentication->getResult()->isValid()) {
            $this->Flash->error(__('First you need to login.'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        } else {
            $user = $this->request->getAttribute('identity')->getOriginalData();
            if (!$user->isAdmin()) {
                $this->Flash->error(__('You need to be an administrator for access the page.'));
                return $this->redirect(['action' => 'index']);
            }
            $dish = $this->Dishs->get($id, [
                'contain' => ['Carts', 'Orders'],
            ]);

            $this->set(compact('dish'));
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if (!$this->Authentication->getResult()->isValid()) {
            $this->Flash->error(__('First you need to login.'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        } else {
            $user = $this->request->getAttribute('identity')->getOriginalData();
            if (!$user->isAdmin()) {
                $this->Flash->error(__('You need to be an administrator for access the page.'));
                return $this->redirect(['action' => 'index']);
            }
            $dish = $this->Dishs->newEmptyEntity();
            if ($this->request->is('post')) {
                $dish = $this->Dishs->patchEntity($dish, $this->request->getData());
                if ($this->Dishs->save($dish)) {
                    $this->Flash->success(__('The dish has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The dish could not be saved. Please, try again.'));
            }
            $this->set(compact('dish'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Dish id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if (!$this->Authentication->getResult()->isValid()) {
            $this->Flash->error(__('First you need to login.'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        } else {
            $user = $this->request->getAttribute('identity')->getOriginalData();
            if (!$user->isAdmin()) {
                $this->Flash->error(__('You need to be an administrator for access the page.'));
                return $this->redirect(['action' => 'index']);
            }
            $dish = $this->Dishs->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $dish = $this->Dishs->patchEntity($dish, $this->request->getData());
                if ($this->Dishs->save($dish)) {
                    $this->Flash->success(__('The dish has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The dish could not be saved. Please, try again.'));
            }
            $this->set(compact('dish'));
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Dish id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if (!$this->Authentication->getResult()->isValid()) {
            $this->Flash->error(__('First you need to login.'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        } else {
            $user = $this->request->getAttribute('identity')->getOriginalData();
            if (!$user->isAdmin()) {
                $this->Flash->error(__('You need to be an administrator for access the page.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->request->allowMethod(['post', 'delete']);
            $dish = $this->Dishs->get($id);
            if ($this->Dishs->delete($dish)) {
                $this->Flash->success(__('The dish has been deleted.'));
            } else {
                $this->Flash->error(__('The dish could not be deleted. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->
            addUnauthenticatedActions(['index', 'view']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function admin()
    {
        if (!$this->Authentication->getResult()->isValid()) {
            $this->Flash->error(__('First you need to login.'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        } else {
            $user = $this->request->getAttribute('identity')->getOriginalData();
            if (!$user->isAdmin()) {
                $this->Flash->error(__('You need to be an administrator for access the page.'));
                return $this->redirect(['action' => 'index']);
            }
            $dishs = $this->paginate($this->Dishs);

            $this->set(compact('dishs'));
        }
    }
}

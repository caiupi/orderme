<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Carts Controller
 *
 * @property \App\Model\Table\CartsTable $Carts
 * @method \App\Model\Entity\Cart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CartsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $user= $this->request->getAttribute('identity')->getOriginalData();
        if ($user->isAdmin()){
            $this->Flash->set(__('You are redirected to the administration Carts page'));
            return $this->redirect(['action' => 'admin']);
        }
        $desk=$this->Carts->Users->Desks->find()->select(['id'])->where(['user_id'=>$user->id])->first();
        $this->paginate = [
            'contain' => ['Dishs'],
        ];
        $carts = $this->paginate($this->Carts->find()->where(['user_id'=>$user->id]));
        $dishs = $this->Carts->Dishs->find();
        $this->set('desk',$desk->id);
        $this->set('dishs',$dishs);
        $this->set(compact('carts'));
    }

    /**
     * View method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user= $this->request->getAttribute('identity')->getOriginalData();
        if (!$user->isAdmin()){
            $this->Flash->error(__('You need to be an administrator for access the page.'));
            return $this->redirect(['action' => 'index']);
        }
        $cart = $this->Carts->get($id, [
            'contain' => ['Users', 'Dishs'],
        ]);

        $this->set(compact('cart'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user= $this->request->getAttribute('identity')->getOriginalData();
        if (!$user->isAdmin()){
            $this->Flash->error(__('You need to be an administrator for access the page.'));
            return $this->redirect(['action' => 'index']);
        }
        $cart = $this->Carts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cart = $this->Carts->patchEntity($cart, $this->request->getData());
            if ($this->Carts->save($cart)) {
                $this->Flash->success(__('The cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));
        }
        $users = $this->Carts->Users->find('list', ['limit' => 200]);
        $dishs = $this->Carts->Dishs->find('list', ['limit' => 200]);
        $this->set(compact('cart', 'users', 'dishs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cart = $this->Carts->get($id);
        if ($this->Carts->delete($cart)) {
            $this->Flash->success(__('The cart has been deleted.'));
        } else {
            $this->Flash->error(__('The cart could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function add($dishId): ?\Cake\Http\Response
    {
        $cart = $this->Carts->newEmptyEntity();
        $cart->user_id=$this->request
            ->getAttribute('identity')->id;
        $cart->dish_id=$dishId;
        $cart->quantity=1;
        if ($this->Carts->save($cart)) {
            $this->Flash->success(__('The dish has been added to cart.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The dish could not be added. Please, try again.'));
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        if(!$this->Authentication->getResult()->isValid()){
            $this->Flash->error(__('First you need to login.'));
        }else {
            $userId = $this->request->getAttribute('identity')->id;
            $userDesk = $this->Carts->Users->Desks->find()->select(['id'])->where(['user_id' => $userId])->first();
            if (is_null($userDesk)) {
                $this->Flash->error(__('First you need to reserve a table.'));
                return $this->redirect(['controller' => 'desks', 'action' => 'index']);
            }
        }
    }
    public function admin()
    {
        $user= $this->request->getAttribute('identity')->getOriginalData();
        if (!$user->isAdmin()){
            $this->Flash->error(__('You need to be an administrator for access the page.'));
            return $this->redirect(['action' => 'index']);
        }
        $userId=$this->request->getAttribute('identity')->id;
        $desk=$this->Carts->Users->Desks->find()->select(['id'])->where(['user_id'=>$userId])->first();

        $this->paginate = [
            'contain' => ['Users', 'Dishs'],
        ];
        $carts = $this->paginate($this->Carts);
        $dishs = $this->Carts->Dishs->find();
        $this->set('desk',$desk->id);
        $this->set('dishs',$dishs);
        $this->set(compact('carts'));

    }
}

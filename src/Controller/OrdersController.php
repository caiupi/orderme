<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
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
            $this->Flash->set(__('You are redirected to the administration Orders page'));
            return $this->redirect(['action' => 'admin']);
        }
        $ordersUser=$this->Orders->find()->where(['user_id'=>$user->id]);
        $total=0;
        foreach ($ordersUser as $row){
            $dishPrice=$this->Orders->Dishs->find()->where(['id'=>$row->dish_id])->select(['price'])->first()->price;
            $total+=$dishPrice;
        }
        $this->paginate = [
            'contain' => ['Dishs'],
        ];
        $orders = $this->paginate($this->Orders->find()->where(['user_id'=>$user->id]));
        $this->set(compact('orders'));
        $this->set('total',$total);
        $this->set('user',$user);
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Users', 'Dishs'],
        ]);

        $this->set(compact('order'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user= $this->request->getAttribute('identity')->getOriginalData();
        if (!$user->isAdmin()){
            $this->Flash->error(__('You need to be an administrator for access the page.'));
            return $this->redirect(['action' => 'index']);
        }
        $order = $this->Orders->newEmptyEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $users = $this->Orders->Users->find('list', ['limit' => 200]);
        $dishs = $this->Orders->Dishs->find('list', ['limit' => 200]);
        $this->set(compact('order', 'users', 'dishs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
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
        $order = $this->Orders->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $users = $this->Orders->Users->find('list', ['limit' => 200]);
        $dishs = $this->Orders->Dishs->find('list', ['limit' => 200]);
        $this->set(compact('order', 'users', 'dishs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $user= $this->request->getAttribute('identity')->getOriginalData();
        if (!$user->isAdmin()){
            $this->Flash->error(__('You need to be an administrator for access the page.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function press()
    {
        $userId=$this->request->getAttribute('identity')->id;
        $cartsUser=$this->Orders->Users->Carts->find()->where(['user_id'=>$userId]);
        if($cartsUser->count()==0){
            $this->Flash->error(__('The cart can not be empty. Please, try again.'));
           return $this->redirect(['controller'=>'Carts','action' => 'index']);
        }
        foreach ($cartsUser as $row) {
            $order = $this->Orders->newEmptyEntity();
            $order->user_id=$userId;
            $order->dish_id=$row->dish_id;
            $order->quantity=$row->quantity;
            if ($this->Orders->save($order)) {
            }else{
                $this->Flash->error(__('The order could not be saved. Please, try again.'));
            }
        }
        foreach ($cartsUser as $row){
            if ($this->Orders->Users->Carts->delete($row)){
            }else{
                $this->Flash->error(__('The cart elements can not be eliminate. Please, try again.'));
            }
        }
        $this->Flash->success(__('The order has been created.'));
        $orders = $this->paginate($this->Orders);
        $this->set(compact('orders'));
        return $this->redirect(['action' => 'index']);
    }
    public function payment()
    {
        $userId=$this->request->getAttribute('identity')->id;
        $desksUser=$this->Orders->Users->Desks->find()->where(['user_id'=>$userId])->first();
        if($desksUser==null){
            $this->Flash->error(__('You dont have order any dishs. First you have to order.'));
            return $this->redirect(['controller'=>'Carts','action' => 'index']);
        }
        //Empty the cart and the order records of the user
        $ordersUser=$this->Orders->find()->where(['user_id'=>$userId]);
        $cardsUser=$this->Orders->Users->Carts->find()->where(['user_id'=>$userId]);
        foreach ($ordersUser as $row){
            if ($this->Orders->delete($row)){
            }else{
                $this->Flash->error(__('The orders could not be deleted. Please, try again.'));
            }
        }
        foreach ($cardsUser as $row){
            if ($this->Orders->Users->Carts->delete($row)){
            }else{
                $this->Flash->error(__('The orders could not be deleted. Please, try again.'));
            }
        }
        $desksUser->ordered=true;
        $desksUser->available=true;
        $desksUser->user_id=null;
        $this->Orders->Users->Desks->save($desksUser);
        $this->Flash->success(__('Thank you. See you soon.'));
        return $this->redirect(['controller'=>'Dishs','action' => 'index']);
    }
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        if(!$this->Authentication->getResult()->isValid()){
            $this->Flash->error(__('First you need to login.'));
        }else {
            $userId = $this->request->getAttribute('identity')->id;
            $userDesk = $this->Orders->Users->Desks->find()->select(['id'])->where(['user_id' => $userId])->first();
            if (is_null($userDesk)) {
                $this->Flash->error(__('First you need to reserve a table.'));
                return $this->redirect(['controller' => 'desks', 'action' => 'index']);
            }
        }
    }
    public function admin(){
        $user= $this->request->getAttribute('identity')->getOriginalData();
        if (!$user->isAdmin()){
            $this->Flash->error(__('You need to be an administrator for access the page.'));
            return $this->redirect(['action' => 'index']);
        }
        $userId=$this->request->getAttribute('identity')->id;
        $ordersUser=$this->Orders->find()->where(['user_id'=>$userId])->select(['dish_id'])->toArray();
        $total=0;
        foreach ($ordersUser as $row){
            $dishPrice=$this->Orders->Dishs->find()->where(['id'=>$row->dish_id])->select(['price'])->first()->price;
            $total+=$dishPrice;
        }
        $this->paginate = [
            'contain' => ['Users', 'Dishs'],
        ];
        $orders = $this->paginate($this->Orders);

        $this->set(compact('orders'));
        $this->set('total',$total);
    }
}

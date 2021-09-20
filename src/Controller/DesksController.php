<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Desks Controller
 *
 * @property \App\Model\Table\DesksTable $Desks
 * @method \App\Model\Entity\Desk[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DesksController extends AppController
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
            $this->Flash->set(__('You are redirected to the administration Desks page'));
            return $this->redirect(['action' => 'admin']);
        }
        $userDesk=$this->Desks->find()->select(['id'])->where(['user_id'=>$user->id])->first();
        if(!is_null($userDesk)){
            $this->Flash->set(__( $user->name.', you have already reserved table: '.$userDesk->id));
        }
        $desks = $this->paginate($this->Desks->find()->where(['available'=>true]));
        $this->set(compact('desks'));
    }

    /**
     * View method
     *
     * @param string|null $id Desk id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $desk = $this->Desks->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('desk'));
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
        $desk = $this->Desks->newEmptyEntity();
        if ($this->request->is('post')) {
            $desk = $this->Desks->patchEntity($desk, $this->request->getData());
            if ($this->Desks->save($desk)) {
                $this->Flash->success(__('The desk has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The desk could not be saved. Please, try again.'));
        }
        $users = $this->Desks->Users->find('list', ['limit' => 200]);
        $this->set(compact('desk', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Desk id.
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
        $desk = $this->Desks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $desk = $this->Desks->patchEntity($desk, $this->request->getData());
            if ($this->Desks->save($desk)) {
                $this->Flash->success(__('The desk has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The desk could not be saved. Please, try again.'));
        }
        $users = $this->Desks->Users->find('list', ['limit' => 200]);
        $this->set(compact('desk', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Desk id.
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
        $desk = $this->Desks->get($id);
        if ($this->Desks->delete($desk)) {
            $this->Flash->success(__('The desk has been deleted.'));
        } else {
            $this->Flash->error(__('The desk could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function reserve($id = null)
    {
        $userId=$this->request->getAttribute('identity')->id;
        $userDesk=$this->Desks->find()->select(['id'])->where(['user_id'=>$userId])->first();
        if(!is_null($userDesk)){
            $this->Flash->error(__('The desk could not be reserved. You have already reserved a table.'));
            return $this->redirect(['action' => 'index']);
        }
        $desk = $this->Desks->get($id, [
            'contain' => [],
        ]);
        $desk->available = false;
        $desk->user_id=$this->request->getAttribute('identity')->id;
        if ($this->Desks->save($desk)) {
            $this->Flash->success(__('The desk number: '.$desk->id.' has been reserved.'));
            return $this->redirect(['controller'=>'Carts','action' => 'index']);
        }
        $this->Flash->error(__('The desk could not be reserved. Please, try again.'));

    }
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        if(!$this->Authentication->getResult()->isValid()){
                $this->Flash->error(__('First you need to login.'));
        }
    }
    public function admin(){
        $user= $this->request->getAttribute('identity')->getOriginalData();
        if (!$user->isAdmin()){
            $this->Flash->error(__('You need to be an administrator for access the page.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $desks = $this->paginate($this->Desks);
        $this->set(compact('desks'));
    }
}

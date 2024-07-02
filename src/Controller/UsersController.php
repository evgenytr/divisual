<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{

    /*
    function initialize()
    {
        parent::initialize();
       // $this->Auth->allow(['index','add']);
    }
    */
    
       public function login()
       {
           if ($this->request->is('post')) {
               $user = $this->Auth->identify();
               if ($user) {
                   $this->Auth->setUser($user);
                   return $this->redirect($this->Auth->redirectUrl());
               }
               $this->Flash->error(__('Invalid username or password, try again'));
           }
       }

       public function logout()
       {
           return $this->redirect($this->Auth->logout());
       }
       
       


     public function index()
     {
        $this->set('users', $this->Users->find('all'));
    }

    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post','delete']);
        $client = $this->Users->get($id);
        if ($this->Users->delete($client)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
?>
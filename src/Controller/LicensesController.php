<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Braintree;

/**
 * Licenses Controller
 *
 * @property \App\Model\Table\LicensesTable $Licenses
 *
 * @method \App\Model\Entity\License[] paginate($object = null, array $settings = [])
 */
class LicensesController extends AppController
{
    function initialize()
    {
        parent::initialize();
       $this->Auth->allow(['purchase','check','checkout']);
     // $this->Auth->allow();
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clients']
        ];
        $licenses = $this->paginate($this->Licenses);

        $this->set(compact('licenses'));
        $this->set('_serialize', ['licenses']);
    }

    /**
     * View method
     *
     * @param string|null $id License id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $license = $this->Licenses->get($id, [
            'contain' => ['Clients']
        ]);

        $this->set('license', $license);
        $this->set('_serialize', ['license']);
    }
    
    public function activate($id = null)
    {
        $license = $this->Licenses->get($id,[
            'contain' => ['Clients']
        ]);
            
        $license['is_active']=true;
        $this->Licenses->save($license);
        $client = $license->client;
        
        $email = new Email('default');
        $email->viewVars(['client' => $license->client]);
        $email->viewVars(['license' => $license]);
        $email->viewVars(['todayDate' => date("m, d, Y")]);
           
        $email->from(['orders@divisual.net' => 'DiVisual Academic License'])
            ->template('academicactivated')
            ->emailFormat('both')
            ->to($client['email'])
            ->subject('DiVisual® Mapping System Academic License Activated')
            ->send(); 
        
        $this->redirect(['action' => 'view',$id]);
    }
    
    public function deactivate($id = null)
    {
        $license = $this->Licenses->get($id);
        $license['is_active']=false;
        $this->Licenses->save($license);
        $this->redirect(['action' => 'view',$id]);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {     
          
        $license = $this->Licenses->newEntity();
        if ($this->request->is('post')) {
            $license = $this->Licenses->patchEntity($license, $this->request->getData());
            if ($this->Licenses->save($license)) {
                $this->Flash->success(__('The license has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The license could not be saved. Please, try again.'));
        }
        $clients = $this->Licenses->Clients->find('list', ['keyField' => 'id',
    'valueField' => 'full_name','limit' => 200]);
        
        $this->set(compact('license', 'clients'));
        $this->set('_serialize', ['license']);
    }
    

    
    public function purchase()
    {
        date_default_timezone_set('UTC');
        $currDateStr = date("Y-m-d");
        
        $planIds = [
          "Yearly"=>'ry42',
          "Monthly"=>'3jrb',  
          "Academic"=>'7kbb'
        ];
            
        
            $salt = "sdfsdokSIOJ83joioCVBNMoihgfgnlllkjjtsaqwerpkjhedc34567ygv34edc6tg";  
            $reqsalt= $this->request->getQuery('salt');  
            if( md5($salt.date("j:n:Y")) != $reqsalt ) return;
          
            $gateway = new \Braintree\Gateway([
                'environment' => 'sandbox',
                'merchantId' => 'ythdbgtqpynpv2pd',
                'publicKey' => 'jz7j3jczgnjsj7px',
                'privateKey' => 'c5d4910ba1456b75a90555a6442f6c29'
            ]);
        
        

                
            //check if license exists or not
            $uuid = $this->request->getQuery('uuid');
            
            //serial can be empty
            $serial = $this->request->getQuery('serial');
            
            //client data
            $email = $this->request->getQuery('email');
            $firstname = $this->request->getQuery('firstname');
            $secondname = $this->request->getQuery('secondname');
            $company = $this->request->getQuery('company');
            
            $client=null;
            $license=null;
            
            if($uuid)
            {
            $license = $this->Licenses->findByUuid($uuid)->first();
        
            //save lic id
            if($license)
                 $client = $this->Licenses->Clients->findById($license['client_id'])->first();
            }
            
            //check client
            if(!$client)
                //find client by email
                $client = $this->Licenses->Clients->findByEmail($email)->first();
            

            //client not found, create record in CLients and Braintree
            if(!$client)
            {
                    $client = $this->Licenses->Clients->newEntity();
                 
  
                    $client['firstname'] = $firstname;
                    $client['secondname'] = $secondname;
                    $client['company'] = $company;
                    $client['email'] = $email;
                      
            
                        $result = $gateway->customer()->create([
                            'firstName' => $client['firstname'],
                            'lastName' => $client['secondname'],
                            'company' => $client['company'],
                            'email' => $client['email']
                        ]);
                
                    $client['customer_id'] = $result->customer->id;   
                    $this->Licenses->Clients->save($client);
            }
            
            if($license)
            $this->set('license',$license);
            
            $token = $gateway->clientToken()->generate();
            $this->set(compact('token'));
            
            $this->set('client',$client);
            $this->set('salt',$salt);
            $this->set('uuid',$uuid);
            $this->set('serial',$serial);
 
 
    }
    
    public function checkout()
    {
        date_default_timezone_set('UTC');
        $currDateStr = date("Y-m-d");
        
        $planIds = [
          "Yearly"=>'ry42',
          "Monthly"=>'3jrb',  
          "Academic"=>'7kbb'
        ];
        $planCosts = [
          "Yearly"=>'285 CHF',
          "Monthly"=>'25 CHF',
          "Academic"=>'0 CHF'  
        ];
            
        //purchase action 
        if ($this->request->is('post') || $this->request->is('put')) {
             $requestData = $this->request->getData();

               
            //find lic by uuid
            $license = $this->Licenses->findByUuid($requestData['uuid'])->first();
            
            if(!$license)
                $license = $this->Licenses->newEntity();
            
           
            
            $license = $this->Licenses->patchEntity($license, $requestData);
            
            
            $nonce = $license["payment_method_nonce"];
            
            $gateway = new \Braintree\Gateway([
                'environment' => 'production',
                'merchantId' => 'm6synqg682wb6q86',
                'publicKey' => '9p8nq9233qy4gptg',
                'privateKey' => '2768f73a2c4d382c69e819026c1b9b0d'
            ]);
              
              /*  
                $gateway = new \Braintree\Gateway([
                    'environment' => 'sandbox',
                    'merchantId' => 'ythdbgtqpynpv2pd',
                    'publicKey' => 'jz7j3jczgnjsj7px',
                    'privateKey' => 'c5d4910ba1456b75a90555a6442f6c29'
                ]);
                */
                  
            $client = $this->Licenses->Clients->findById($license['client_id'])->first();      
            //serial
            //
            if(!$license['serial'])
            {
            $lic=md5(md5($currDateStr.$client['email'].$client['company']).$requestData['salt']);
            
            $lic=strtoupper($lic);
            $license['serial']=substr($lic,8,5)."-".substr($lic,13,5)."-".substr($lic,18,6);	
            }
            
            
            
            //show serial to client
            
            //update client with payment method
            
            
            $result = $gateway->customer()->update($client['customer_id'],
                [
                'paymentMethodNonce' => $license["payment_method_nonce"]
                ]);
            
            if($result->success) 
            {
            $paymentToken = $result->customer->paymentMethods;
            $paymentToken = end($paymentToken)->token; 
                
            //create subscription
            $result = $gateway->subscription()->create([
              'paymentMethodToken' => $paymentToken,
              'planId' => $planIds[$license['type']]
            ]);
          
                if($result->success) 
                {
                    //save subscription id to license
                    $license['subscription_id'] = $result->subscription->id;
                    if($license['type']=="Academic")
                         $license['is_active']=false;
                        else
                         $license['is_active']=true;
                    
                    
                    $saveResult = $this->Licenses->save($license);  
                    
                    
                    if($license['type']=="Academic")
                    {
                         $message = "Your Academic subscription succesfully created, please check your mailbox for activation instructions and serial number";
                         
                         $email = new Email('default');
                         $email->viewVars(['client' => $client]);
                         $email->viewVars(['license' => $license]);
                         $email->viewVars(['todayDate' => date("m, d, Y")]);

                            
                         $email->from(['orders@divisual.net' => 'DiVisual Academic License'])
                             ->template('academic')
                             ->emailFormat('both')
                             ->to($client['email'])
                             ->subject('DiVisual® Mapping System Academic License')
                             ->send(); 
                     }
                     else
                     {
                     
                     $message = "Your subscription succesfully created, please use this serial number to activate extension: ".$license['serial'];
                     
                    $email = new Email('default');
                    $email->viewVars(['client' => $client]);
                    $email->viewVars(['license' => $license]);
                    $email->viewVars(['todayDate' => date("m, d, Y")]);
                    $email->viewVars(['cost' => $planCosts[$license['type']]]);

                            
                    $email->from(['orders@divisual.net' => 'DiVisual Order'])
                        ->template('default')
                        ->emailFormat('both')
                        ->to($client['email'])
                        ->subject('DiVisual® Mapping System License')
                        ->send(); 
                    }
                }
                else
                    $message = "Subscription was not created, please contact us";  
            }
            else
                $message = "Payment method not accepted";  
   
            
            $this->set('license',$license);
            $this->set('message',$message);
        }
       
   
 
    }
    
    
    //used to test serial from extension
    public function check()
    {
        
     
        date_default_timezone_set('UTC');
        $currDateStr = date("Y-m-d");
        //var dateString = currDate.getUTCDate()+":"+(1+currDate.getUTCMonth())+":"+currDate.getUTCFullYear();
 
         $this->viewBuilder()->setLayout(false);
         
         $response = [
             'msg'=>"Please purchase license and activate with serial number",
            'key'=>"0000",
            'state'=>"No license exists"
        ];
         $this->set($response); 
         
        if ($this->request->is('post')) {
            
            
            $requestData = $this->request->getData();
             $this->set($requestData);
            
            //test salt
            $salt = "sdfsdokSIOJ83joioCVBNMoihgfgnlllkjjtsaqwerpkjhedc34567ygv34edc6tg";    
     
            
            if( md5($salt.date("j:n:Y")) != $requestData['salt'] ) return;
            
            //find lic by uuid, check client 
            $license = $this->Licenses->findByUuid($requestData['uuid'])->first();
            
            if($license)
            {
                $client = $this->Licenses->Clients->findById($license['client_id'])->first(); 
                
                if($requestData['serial']!="" && $license['serial']==$requestData['serial'])
                {
             
                     
                        $gateway = new \Braintree\Gateway([
                            'environment' => 'sandbox',
                            'merchantId' => 'ythdbgtqpynpv2pd',
                            'publicKey' => 'jz7j3jczgnjsj7px',
                            'privateKey' => 'c5d4910ba1456b75a90555a6442f6c29'
                        ]);
                      
                          
                    $result = $gateway->subscription()->find($license['subscription_id']);
                    
                    $paidThroughDate = $result->paidThroughDate;
                    
                    if($paidThroughDate && $result->status == "Active")
                    {
                        $response['msg']="Subscription is active until ".$paidThroughDate->format('Y-m-d');
                    }
                    if(!$paidThroughDate && $result->status == "Active")
                    {
                        $paidThroughDate = $result->nextBillingDate;
                        $response['msg']="Trial is active until ".$paidThroughDate->format('Y-m-d');
                        
                    }
                    //allow, send license response with license expiration date
                    
                    
                    
                    
                    if($result->status == "Active")
                    {
                        if($license['type']=="Academic")
                        {
                           if(!$license['is_active'])
                           {
                              $response['state']="Academic license not activated";
                              $response['msg']="Academic license not activated";
                          }
                           else
                               {
                                   $response['state']="License valid";
                                   $response['key']=$this->encrypt("5618-9870-".$paidThroughDate->format('Y-m-d')."1252", $license['uuid'].$license['serial'].$client['email']);
                               }  
                        }
                        else
                        {
                        $response['state']="License valid";
                        $response['key']=$this->encrypt("5618-9870-".$paidThroughDate->format('Y-m-d')."1252", $license['uuid'].$license['serial'].$client['email']);
                        }
                    }
                    else
                        $response['state']="License expired";
                     
                }
                else
                {
                    if($requestData['serial']!="")
                        {
                            $response = [
                                'msg'=>"Serial number and subscription data don't match, please contact us",
                               'key'=>"0000",
                               'state'=>"Serial mismatch"
                           ];
                           
                       
                        }
                }
            }
           
        }
        
       $this->set($response);
      
 
    }


    /**
     * Edit method
     *
     * @param string|null $id License id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $license = $this->Licenses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $license = $this->Licenses->patchEntity($license, $this->request->getData());
            if ($this->Licenses->save($license)) {
                $this->Flash->success(__('The license has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The license could not be saved. Please, try again.'));
        }
        $clients = $this->Licenses->Clients->find('list', ['keyField' => 'id',
    'valueField' => 'full_name','limit' => 200]);
        $this->set(compact('license', 'clients'));
        $this->set('_serialize', ['license']);
    }

    /**
     * Delete method
     *
     * @param string|null $id License id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $license = $this->Licenses->get($id);
        if ($this->Licenses->delete($license)) {
            $this->Flash->success(__('The license has been deleted.'));
        } else {
            $this->Flash->error(__('The license could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    function encrypt($data, $passphrase, $salt = null) {
            $salt = $salt ?: openssl_random_pseudo_bytes(8);
            list($key, $iv) = $this->evpkdf($passphrase, $salt);

            $ct = openssl_encrypt($data, 'aes-256-cbc', $key, true, $iv);

            return $this->encode($ct, $salt);
        }
    
        function evpkdf($passphrase, $salt) {
                $salted = '';
                $dx = '';
                while (strlen($salted) < 48) {
                    $dx = md5($dx . $passphrase . $salt, true);
                    $salted .= $dx;
                }
                $key = substr($salted, 0, 32);
                $iv = substr($salted, 32, 16);

                return [$key, $iv];
            }

            function encode($ct, $salt) {
                return base64_encode("Salted__" . $salt . $ct);
            }
}

<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Contacts Controller
 *
 * @property \App\Model\Table\ContactsTable $Contacts
 *
 * @method \App\Model\Entity\Contact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContactsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function index()
    {
        $this->paginate = [
            'contain' => ['Companies'],
        ];
        $contacts = $this->Contacts->find()->select(['id',' first_name', 'last_name', 'phone_number'])->all();
        // $this->set([
        //             'contacts' => $contacts,
        //             '_serialize' => ['contacts']
        //         ]);
        echo json_encode($contacts);die;
        
    }

     public function indexExt()
    {
        
        $contacts = $this->Contacts->find()->select(['id',' first_name', 'last_name', 'phone_number','company_id','companies.id','companies.company_name','companies.address'])->contain(['Companies'])->all();
        echo json_encode($contacts);die;
        
    }
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contact = $this->Contacts->newEntity();
        if ($this->request->is('post')) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->getData());
            if ($this->Contacts->save($contact)) {
                $this->Flash->success(__('The contact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contact could not be saved. Please, try again.'));
        }
        $companies = $this->Contacts->Companies->find()->combine('id', 'company_name');
        $this->set(compact('contact', 'companies'));
    }

}

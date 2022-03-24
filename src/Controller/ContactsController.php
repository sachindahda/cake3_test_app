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
        
        $contacts = $this->Contacts->find()->select(['id',' first_name', 'last_name', 'phone_number'])->all();
        $this->set([
                    'contacts' => $contacts,
                    '_serialize' => ['contacts']
                ]);
        
    }

     public function indexExt()
    {
        
        $contacts = $this->Contacts->find()->select(['id',' first_name', 'last_name', 'phone_number','company_id','companies.id','companies.company_name','companies.address'])->contain(['Companies'])->all();
        $this->set([
                    'contacts' => $contacts,
                    '_serialize' => ['contacts']
                ]);
        
    }
    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $result=[];
        $contact = $this->Contacts->newEntity();

        if ($this->request->is('post')) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->getData());
            if ($this->Contacts->save($contact)) {
                $result['success']=true;
                $result['msg']='Contact Saved Successfully.';

            }
            else{
                $result['success']=false;
                $result['msg']='An Error Occured While Saving Contact,Please Fill the all required Fields: (first_name,last_name,phone_number,address,notes,add_notes,internal_notes,comments and company_id)';
            }
        }
        $this->set([
                    'contact' => $contact,
                    'result'=>$result,
                    '_serialize' => ['contact','result']
                ]);
    }

}

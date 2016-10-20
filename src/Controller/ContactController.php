<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\ContactForm;
use Cake\Event\Event;

class ContactController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        // public actions
        $this->Auth->allow(['contact']);
    }

    public function contact()
    {
        $contact = new ContactForm();
        if ($this->request->is('post')) {
            var_dump($this->request->data["email"]);
            if ($contact->execute($this->request->data)) {
                $this->Flash->success(__('We will get back to you soon.'));
            } else {
                $this->Flash->error(__('There was a problem submitting your message'));
                foreach ($contact->errors() as $error) {
                    $this->Flash->error(__('{0}', reset($error)));
                }
                // return $this->redirect(['controller' => 'Contact', 'action' => 'contact']);
            }
        }

        if ($this->request->is('get')) {
            //Values from the User Model e.g.
            // $this->request->data['name'] = 'John Doe';
            // $this->request->data['email'] = 'john.doe@example.com';
        }

        $this->set('contact', $contact);
    }


}

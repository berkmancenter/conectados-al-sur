<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Mailer\Email;

class ContactForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema
            ->addField('name', 'string')
            ->addField('email', ['type' => 'string'])
            ->addField('body', ['type' => 'text']);
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator->add('name', 'length', [
                'rule' => ['minLength', 5],
                'message' => __('A name is required')
            ])->add('email', 'format', [
                'rule' => 'email',
                'message' => __('A valid email address is required'),
            ]);
    }

    protected function _execute(array $data)
    {

        $message = "Name: " . $data["name"] . "\n" 
                . "Email: " . $data["email"] . "\n"
                . "---" . "\n"
                . $data["body"];

        $email = new Email('default');
        $email->from(['contacto@app.dvine.cl' => 'Contact Dvine Web App'])
            ->sender($data["email"], $data["name"]) // original sender
            ->to('lionelbrossi@gmail.com')          // admin
            ->subject('Contact message from app.dvine.cl')
            ->send($message);

        return true;
    }
}

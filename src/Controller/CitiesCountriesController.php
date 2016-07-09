<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CitiesCountries Controller
 *
 * @property \App\Model\Table\CitiesCountriesTable $CitiesCountries
 */
class CitiesCountriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Countries', 'Cities']
        ];
        $citiesCountries = $this->paginate($this->CitiesCountries);

        $this->set(compact('citiesCountries'));
        $this->set('_serialize', ['citiesCountries']);
    }

    /**
     * View method
     *
     * @param string|null $id Cities Country id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $citiesCountry = $this->CitiesCountries->get($id, [
            'contain' => ['Countries', 'Cities']
        ]);

        $this->set('citiesCountry', $citiesCountry);
        $this->set('_serialize', ['citiesCountry']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $citiesCountry = $this->CitiesCountries->newEntity();
        if ($this->request->is('post')) {
            $citiesCountry = $this->CitiesCountries->patchEntity($citiesCountry, $this->request->data);
            if ($this->CitiesCountries->save($citiesCountry)) {
                $this->Flash->success(__('The cities country has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cities country could not be saved. Please, try again.'));
            }
        }
        $countries = $this->CitiesCountries->Countries->find('list', ['limit' => 200]);
        $cities = $this->CitiesCountries->Cities->find('list', ['limit' => 200]);
        $this->set(compact('citiesCountry', 'countries', 'cities'));
        $this->set('_serialize', ['citiesCountry']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cities Country id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $citiesCountry = $this->CitiesCountries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $citiesCountry = $this->CitiesCountries->patchEntity($citiesCountry, $this->request->data);
            if ($this->CitiesCountries->save($citiesCountry)) {
                $this->Flash->success(__('The cities country has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cities country could not be saved. Please, try again.'));
            }
        }
        $countries = $this->CitiesCountries->Countries->find('list', ['limit' => 200]);
        $cities = $this->CitiesCountries->Cities->find('list', ['limit' => 200]);
        $this->set(compact('citiesCountry', 'countries', 'cities'));
        $this->set('_serialize', ['citiesCountry']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cities Country id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $citiesCountry = $this->CitiesCountries->get($id);
        if ($this->CitiesCountries->delete($citiesCountry)) {
            $this->Flash->success(__('The cities country has been deleted.'));
        } else {
            $this->Flash->error(__('The cities country could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}

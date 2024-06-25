<?php

namespace App\Controller;

use Cake\Controller\Controller;

class ArticlesController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        // Ajoutez ici d'autres composants nécessaires
    }
    public function index()
    {
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
    }

    public function view($slug = null)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $this->set(compact('article'));
    }

    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            // dd($article);
            if ($this->Articles->save($article)) {
                $this->Flash->success('Your article has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to had article.');

        }
        $this->set(compact('article'));
    }

    public function edit($slug)
    {
        // dd($slug);
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success('Your article has been updated.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to update your article.');
        }
        $this->set(compact('article'));
    }

    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article))
        {
            $this->Flash->success(__('The "{0}" article has been deleted', $article->title));
            return $this->redirect(['action' => 'index']);


        }

    }

}
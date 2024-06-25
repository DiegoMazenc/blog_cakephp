<?php

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Event\EventInterface;
use Cake\Validation\Validator;

class ArticlesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function beforeSave(EventInterface $event, $entity, $options)
    {
        if ($entity->isNew() && !$entity->slug)
        {
            $sluggedTitle = Text::slug($entity->title);
            $entity->slug = substr($sluggedTitle, 0, 191);
        }
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('title', 'Ce champ ne peut être vide.')
            ->minLength('title', 10, '10 caractères minimum.')
            ->maxLength('title', 255, 'Le texte est trop long.')
            ->notEmptyString('body', 'Ce champ de doit pas être vide.')
            ->minLength('body', 10, '10 caractères minimum.');
        
        return $validator;
    }
}
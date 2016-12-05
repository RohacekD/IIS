<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.12.2016
 * Time: 9:16
 */

namespace App\ISModule\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Forms\FormFactory;
use App\ISModule\Model;

class ProductionFormFactory
{
    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;

    /**
     * @param FormFactory $factory
     * @param User $user
     */
    public function __construct(FormFactory $factory, User $user)
    {
        $this->factory = $factory;
    }


    /**
     * @param callable $onSuccess
     *
     * @return Form
     */
    public function create(callable $onSuccess)
    {
        $form = $this->factory->create();
        $form->elementPrototype->addAttributes(array('class' => 'form-user'));


        $form->addSelect("role", null, //todo
            [
                'director' => 'hra',
                'actor' => 'hra 2',
                'organizer' => 'hra 3'
            ])
            ->setRequired('forms.user.roleHint')
            ->setAttribute('class', 'form-control');
        $form->addMultiSelect('options', 'Možnosti:', [
            'director' => 'herec 1',
            'actor' => 'herec  2',
            'organizer' => 'herec 3'
        ])
            ->setRequired('forms.user.roleHint')
            ->setAttribute('class', 'form-control selectpicker')
            ->setAttribute('placeholder', 'forms.rehearsal.production');

        $form->addText('date')
            ->setAttribute("type", "date")
            ->setRequired('forms.rehearsal.hintProduction')
            ->setAttribute('class', 'form-control')
            ->setAttribute('placeholder', 'forms.rehearsal.date');
        $form->addText('time')
            ->setAttribute("type", "time")
            ->setRequired('forms.rehearsal.hintProduction')
            ->setAttribute('class', 'form-control')
            ->setAttribute('placeholder', 'forms.rehearsal.date');


        $form->addSubmit('send', 'forms.user.create')
            ->setAttribute('class', 'btn btn-lg btn-primary btn-block');


        $form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
            if ($values->password != $values->passwordAgain) {
                $form->addError('forms.user.errorPassword');
            }
            $onSuccess($form, $values);
        };

        return $form;
    }


}
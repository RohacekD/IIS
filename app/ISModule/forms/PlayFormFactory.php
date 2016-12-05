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

class PlayFormFactory
{
    use Nette\SmartObject;

    /** @var Model\UserManager @inject */
    public $userManager;
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
     * @param Model\Play $play
     *
     * @return Form
     */
	public function create( callable $onSuccess, $play )
    {
        $form = $this->factory->create();
        $form->elementPrototype->addAttributes(array('class' => 'form-play'));


        $form->addText('name')
             ->setRequired('Uveďte prosím název hry')
             ->setAttribute('class', 'form-control')
             ->setAttribute( 'placeholder', 'Název hry' )
             ->setDefaultValue( $play->getName() );

        $form->addText('author')
             ->setRequired('Uveďte prosím autora hry')
             ->setAttribute('class', 'form-control')
             ->setAttribute( 'placeholder', 'Autor' )
             ->setDefaultValue( $play->getAuthor() );
        $form->addText('time', "Časová náročnost")
             ->setAttribute("type", "time")
             ->setRequired('forms.rehearsal.hintProduction')
             ->setAttribute('class', 'form-control')
             ->setAttribute( 'placeholder', 'časová náročnost' )
             ->setDefaultValue( $play->getTimeNeeded()->format( 'H:i' ) );
        $form->addTextArea('desription', null, null, 5)
             ->setRequired('Uveďte prosím popis hry')
             ->setAttribute('class', 'form-control')
             ->setAttribute( 'placeholder', 'Popis' )
             ->setDefaultValue( $play->getDescription() );


        $form->addSubmit('send', 'Vytvořit')
            ->setAttribute('class', 'btn btn-lg btn-primary btn-block');


        $form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
            $onSuccess($form, $values);
        };

        return $form;
    }


}
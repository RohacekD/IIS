<?php

namespace App\ISModule\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Forms\FormFactory;
use Tracy\Debugger;

class SignInFormFactory
{
	use Nette\SmartObject;

	/** @var FormFactory */
	private $factory;

	/** @var User */
	private $user;


	/**
	 * @param FormFactory $factory
	 * @param User $user
	 */
	public function __construct(FormFactory $factory, User $user)
	{
		$this->factory = $factory;
		$this->user = $user;
	}


	/**
	 * @param callable $onSuccess
	 * @return Form
	 */
	public function create(callable $onSuccess)
	{
		$form = $this->factory->create();
        $form->elementPrototype->addAttributes(array('class' => 'form-signin'));
        $form->addText('username')
            ->setRequired('forms.login.usernameHint')
            ->setAttribute('class', 'form-control')
            ->setAttribute('placeholder', 'forms.login.username');

        $form->addPassword('password')
            ->setRequired('forms.login.passwordHint')
            ->setAttribute('class', 'form-control')
            ->setAttribute('placeholder', 'forms.login.password');

		$form->addCheckbox('remember', 'forms.login.keepLogIn');

        $form->addSubmit('send', 'forms.login.signIn')
            ->setAttribute('class', 'btn btn-lg btn-primary btn-block');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			try {
				$this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
				$this->user->login($values->username, $values->password);
			} catch (Nette\Security\AuthenticationException $e) {
				$form->addError('forms.login.error');
				return;
			}
			$onSuccess();
		};
		return $form;
	}

}

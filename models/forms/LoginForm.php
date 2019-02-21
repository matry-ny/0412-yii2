<?php

namespace app\models\forms;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package app\models\forms
 */
class LoginForm extends Model
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $rememberMe = true;

    /**
     * @var bool|User
     */
    private $user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @return bool
     */
    public function validatePassword(): bool
    {
        if ($this->hasErrors()) {
            return false;
        }

        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->password)) {

            $this->addError('username');
            $this->addError('password', 'Incorrect username or password.');
            return false;
        }

        return true;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login(
                $this->getUser(),
                $this->rememberMe ? 3600*24*30 : 0
            );
        }
        return false;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->user === false) {
            $this->user = User::findByUsername($this->username);
        }

        return $this->user;
    }
}

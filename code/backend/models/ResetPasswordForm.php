<?php

namespace backend\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use backend\models\AdminMaster;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model {

    public $password;
    public $confirm_password;

    /**
     * @var \backend\models\AdminMaster
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = AdminMaster::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * password validation
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['password', 'confirm_password'], 'required'],
            ['password', 'string', 'min' => 6, 'max' => 16],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "password don't match"],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword() {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }

}

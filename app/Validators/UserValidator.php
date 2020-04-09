<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

/**
 * Class UserValidator.
 *
 * @package namespace App\Validators;
 */
class UserValidator extends LaravelValidator
{

    /**
     * UserValidator constructor.
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        /**
         *
         * Validator rules
         *
         */
        $this->rules = [
            BaseValidatorInterface::RULE_CREATE => [
            ],
            BaseValidatorInterface::RULE_UPDATE => [
            ],
            BaseValidatorInterface::RULE_USER_REGISTER => [
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|string|between:8,255|confirmed',
                'password_confirmation' => 'required',
                'first_name'            => 'required|string|max:45',
                'last_name'             => 'required|string|max:45',
            ],
            BaseValidatorInterface::RULE_USER_LOGIN => [

            ],
        ];

        /**
         *
         * Validator attributes
         *
         */
        $this->attributes = [
        ];

        /**
         *
         * Validator messages
         *
         */
        $this->messages = [];
    }

}

<?php

namespace App\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;

interface BaseValidatorInterface extends ValidatorInterface
{

    const RULE_USER_REGISTER    = 'user_register';

    const RULE_USER_LOGIN       = 'user_login';

}
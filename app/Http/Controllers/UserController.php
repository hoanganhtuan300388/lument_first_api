<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

use App\Repositories\UserRepository;
use App\Validators\BaseValidatorInterface;
use App\Validators\UserValidator;

class UserController extends Controller
{

    protected $userRepository;
    protected $userValidator;


    public function __construct(
        UserRepository $userRepository,
        UserValidator $userValidator
    )
    {
        $this->userRepository   = $userRepository;
        $this->userValidator    = $userValidator;
    }


    /**
     * User register api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->userValidator->with($request->all())->passesOrFail(BaseValidatorInterface::RULE_USER_REGISTER);

            $user = $this->userRepository->create([
                'email'         => $request->get('email'),
                'password'      => Hash::make($request->get('password')),
                'first_name'    => $request->get('first_name'),
                'last_name'     => $request->get('last_name'),
            ]);

            $token  = JWTAuth::fromUser($user);

            $output = ['token' => $token, 'user' => $user];

            DB::commit();
            return $this->jsonResponse(STATUS_CREATED, __('User registered successfully'), $output);
        } catch (ValidatorException $exception) {
            DB::rollback();
            throw $exception;
        }
    }


    /**
     * User login api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws JWTException
     */
    public function signIn(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                throw new UnauthorizedHttpException(__('Invalid credentials'));
            }
        } catch (JWTException $exception) {
            throw $exception;
        }

        return $this->jsonResponse(STATUS_CREATED, __('User logged in successfully'), ['token' => $token]);
    }


    /**
     * User logout api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return $this->jsonResponse(STATUS_CREATED, __('User logged out successfully'));
    }

}

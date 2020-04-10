<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;
use JWTAuth;

use App\Repositories\PostRepository;
use App\Validators\BaseValidatorInterface;
use App\Validators\PostValidator;

class PostController extends Controller
{

    protected $postRepository;
    protected $postValidator;


    public function __construct(
        PostRepository $postRepository,
        PostValidator $postValidator
    )
    {
        $this->postRepository   = $postRepository;
        $this->postValidator    = $postValidator;
    }


    /**
     * Get list post api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $search = [];

        if ($request->has('title')) {
            $search[] = ['title', 'like', "%{$request->query('title')}%"];
        }

        if ($request->has('content')) {
            $search[] = ['content', 'like', "%{$request->query('content')}%"];
        }

        $list = $this->postRepository->scopeQuery(function ($query) use ($search) {
            return $query
                ->select('id', 'user_id', 'title', 'content')
                ->where($search);
        });

        $search['limit']    = $request->query('limit') ? $request->query('limit') : DEFAULT_LIMIT;
        $posts              = $list->paginate($search['limit'])->toArray();

        return $this->jsonResponse(STATUS_OK, __('Posts list'), $posts);
    }


    /**
     * Create post api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->postValidator->with($request->all())->passesOrFail(BaseValidatorInterface::RULE_CREATE);

            $user = JWTAuth::parseToken()->authenticate();

            $post = $this->postRepository->create([
                'user_id'   => $user->id,
                'title'     => $request->get('title'),
                'content'   => $request->get('content'),
            ]);

            DB::commit();
            return $this->jsonResponse(STATUS_CREATED, __('Post created successfully'), $post);
        } catch (ValidatorException $exception) {
            DB::rollback();
            throw $exception;
        }
    }


    /**
     * Post show detail api
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = $this->postRepository->find($id, ['id', 'user_id', 'title', 'content']);

        return $this->jsonResponse(STATUS_OK, __('Posts detail id ' . $id), $post);
    }


    /**
     * Update post api
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->postValidator->setId($id);
            $this->postValidator->with($request->all())->passesOrFail(BaseValidatorInterface::RULE_UPDATE);

            $user = JWTAuth::parseToken()->authenticate();

            $post = $this->postRepository->update([
                'user_id'   => $user->id,
                'title'     => $request->get('title'),
                'content'   => $request->get('content'),
            ], $id);

            DB::commit();
            return $this->jsonResponse(STATUS_CREATED, __('Post updated successfully'), $post);
        } catch (ValidatorException $exception) {
            DB::rollback();
            throw $exception;
        }
    }


    /**
     * Delete post api
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $post = $this->postRepository->find($id);

        $post->delete($id);

        return $this->jsonResponse(STATUS_CREATED, __('Post deleted successfully'));
    }

}

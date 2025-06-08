<?php

namespace App\Http\Controllers\Admin\User;

use App\Base\BaseController;
use App\DTO\User\UserFilterDTO;
use App\DTO\User\UserOrderByDTO;
use App\Http\Requests\Admin\User\UserStoreRequest;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Http\Resources\UsersCollection;
use App\Http\Resources\UsersResource;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;

/**
 * @group Users
 *
 * APIs for managing users
 */
class UserController extends BaseController
{
    public UserService $userService;

    public function __construct(Request $req,
    UserService $userService)
    {
        $this->userService = $userService;
        parent::__construct($req);
    }

    /**
     * List - Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params     = $request->except('_token');

        $entities   = $this->userService
                    ->addFilter(new UserFilterDTO($params))
                    ->setOrderBy(new UserOrderByDTO($params))
            ->paginate($this->per_page);
        return $this->sendSuccess((new UsersCollection($entities))->toArray($request), 'Entities retrieved successfully.');
    }

    /**
     * POST - Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $_data   = $request->validated(); 
        $user  = $this->userService->store($_data)->getResource();
        if($user->id){
            return $this->sendSuccess((new UsersResource($user))->toArray($request), 'Entity created successfully.', \Illuminate\Http\Response::HTTP_CREATED);
        }
        return $this->sendError([], 'Failed to create entity');
        
    }

    /**
     * GET - Display the specified resource.
     *
     * @param  \App\Models\User  $entity
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, User $user)
    {
        return $this->sendSuccess((new UsersResource($user))->toArray($request), 'Entity retrieved successfully.');
    }

    /**
     * PUT - Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user = $this->userService->setResource($user)
                ->update(attributes: $request->validated())
                ->getResource();

        return $this->sendSuccess((new UsersResource($user))->toArray($request), 'Entity updated successfully.');
    }

    /**
     * DELETE - Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
         try {
            $user = $this->userService->setResource($user)->delete();

            return $this->sendSuccess([],  __('Entity removed successfully.'), \Illuminate\Http\Response::HTTP_NO_CONTENT);
        } catch (\Exception $ex) {
            return $this->sendError(__[], 'Failed to remove entity');;
        }
    }

}

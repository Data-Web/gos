<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Services\UserService;
use App\Http\Requests\Backend\Users\StoreRequest;
use App\Http\Requests\Backend\Users\UpdateRequest;
use App\Http\Requests\Backend\Users\ChangePasswordRequest;
use App\Model\Position;
use App\Model\Room;
use App\Model\Permission;
use App\Model\Role;
use Illuminate\Support\Str;

class UsersController extends ApiController
{
    protected $dataSelect = ['id', 'code', 'fullname', 'username', 'email', 'phone'];

    protected $roleSelect = ['id', 'name'];

    protected $roomSelect = ['id', 'name'];

    protected $positionSelect = ['id', 'name'];

    protected $permissionSelect = ['id', 'name'];

    public function __construct(UserRepository $user)
    {
        parent::__construct($user);
    }

    public function getData(Request $request)
    {
        return \Datatables::of($this->repository->datatables($this->dataSelect, ['rooms', 'position']))
        ->addColumn('rooms', function ($item) {
            return $item->rooms->map(function ($room) {
                return '<span class="label label-primary">' . $room->name . '</span>';
            })->implode(' ');
        })
        ->addColumn('position', function ($item) {
            return ($item->position) ? $item->position->name : null;
        })
        ->filter(function ($instance) use ($request) {
            if ($request->has('code')) {
                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    return Str::contains($row['code'], $request->code) ? true : false;
                });
            }

            if ($request->has('fullname')) {
                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    return Str::contains($row['fullname'], $request->fullname) ? true : false;
                });
            }

            if ($request->has('email')) {
                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    return Str::contains($row['email'], $request->email) ? true : false;
                });
            }

            if ($request->has('phone')) {
                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    return Str::contains($row['phone'], $request->phone) ? true : false;
                });
            }

            if ($request->has('username')) {
                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    return Str::contains($row['username'], $request->username) ? true : false;
                });
            }

            if ($request->has('position_id')) {
                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    return $row->position_id === $request->position_id;
                });
            }

            if ($request->has('room_id')) {
                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    return isset($row->rooms->keyBy('id')[$request->room_id]) ? true : false ;
                });
            }

        })
        ->addColumn('actions', function ($item) {
            $actions = [];
                if ($this->before('edit',$item, false)) {
                    $actions['edit'] = true;
                }
                if ($this->before('delete',$item, false)) {
                    $actions['delete'] = true;
                }

            return $actions;
        })->make(true);
    }

    public function index()
    {
        parent::index();
        try {
            $this->compacts['roles'] = app(Role::class)->get($this->roleSelect);
            $this->compacts['positions'] = app(Position::class)->get($this->positionSelect);
            $this->compacts['rooms'] = app(Room::class)->get($this->roomSelect);
            $this->compacts['permissions'] = app(Permission::class)->get($this->permissionSelect);
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $this->compacts['errors'] = $e->getMessage();
        }

        return $this->jsonRender();
    }

    public function store(StoreRequest $request, UserService $service)
    {
        $data = $request->all();

        return $this->storeData($data, $service);
    }

    public function edit($id)
    {
        parent::edit($id);
        $this->compacts['item']->load('permissions', 'roles', 'rooms');

        return $this->jsonRender(200);
    }

    public function update(UpdateRequest $request, UserService $service, $id)
    {
        $data = $request->all();
        $entity = $this->repository->findOrFail($id);

        return $this->updateData($data, $service, $entity);
    }

    public function destroy($id, UserService $service)
    {
        $entity = $this->repository->findOrFail($id);

        return $this->deleteData($service, $entity);
    }

    public function profile()
    {
        $this->compacts['item'] = \Auth::user();

        return $this->jsonRender(200);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->only(
            'old_password',
            'password',
            'password_confirmation'
        );
    }
}

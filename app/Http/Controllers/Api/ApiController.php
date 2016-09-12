<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AbstractController;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Services\AbstractService;

abstract class ApiController extends AbstractController
{
    protected $guard = 'backend';

    protected $prefix = 'api.v1';

    public function jsonRender($code = 200)
    {
    	$this->compacts['code'] = $code;
        if ($code === 200){
    		$this->compacts['message'] = $this->trans('successfully');
    		return response()->json($this->compacts);
    	} else {
    		$this->compacts['message'] = $this->trans('unsuccessfully');
    		return response()->json($this->compacts);
    	}
    }

    public function index()
    {
        
    }

    public function edit($id)
    {
        $this->compacts['item'] = $this->repository->findOrFail($id);
    }

    public function storeData(array $data, AbstractService $service, callable $callback = null)
    {
        try {
            $item = $service->store($data);
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $this->compacts['errors'] = $e->getMessage();
        }

        if (is_callable($callback)) {
            call_user_func_array($callback, [$item]);
        }

        return $this->jsonRender($code);
    }

    public function updateData(array $data, AbstractService $service, Model $entity, callable $callback = null)
    {
        try {
            $newEntity = $service->update($entity, $data);
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $this->compacts['errors'] = $e->getMessage();
        }

        if (is_callable($callback)) {
            call_user_func_array($callback, [$newEntity]);
        }

        return $this->jsonRender($code);
    }

    public function deleteData(AbstractService $service, Model $entity)
    {
        try {
            $service->delete($entity);
            $code = 200;
        } catch (\Exception $e) {
            $code = 500;
            $this->compacts['errors'] = $e->getMessage();
        }

        return $this->jsonRender($code);
    }
}

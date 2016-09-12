<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Rooms\StoreRequest;
use App\Http\Requests\Backend\Rooms\UpdateRequest;
use App\Model\Room;
use App\Model\Branch;
use Illuminate\Support\Str;

class RoomsController extends ApiController
{
    protected $dataSelect = ['id', 'code', 'name', 'manager', 'member', 'founding'];

    public function __construct(Room $rooms)
    {
        parent::__construct($rooms);
    }

    public function index(Request $request)
    {
       
        
        return \Datatables::of(app(Room::class)->all($this->dataSelect))
            ->filter(function ($instance) use ($request) {
                if ($request->has('code')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['code'], $request->code) ? true : false;
                    });
                }

                if ($request->has('name')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['name'], $request->name) ? true : false;
                    });
                }

                if ($request->has('description')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['description'], $request->description) ? true : false;
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

    public function store(StoreRequest $request)
    {
        $params = $request->all();
        $room = Room::create($params);
        
        return response()->json([
            'code' => 200,
            'message' => 'Thêm thành công!',
            'room' => $room,
        ]);
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return response()->json([
            'code' => 200,
            'message' => 'Thành công!',
            'room' => $room,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $room = Room::findOrFail($id);
            $room->update($request->all());

            return response()->json([
                'code' => 200,
                'message' => 'Sửa thành công!',
                'room' => $room,
            ]);
        }
        
        catch(Exception $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->getMessage(),
            ], 300);
        }
    }

    public function destroy($id)
    {
        Room::findOrFail($id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Xóa thành công!',
        ]);
    }
}

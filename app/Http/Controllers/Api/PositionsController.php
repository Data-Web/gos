<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Positions\StoreRequest;
use App\Http\Requests\Backend\Positions\UpdateRequest;
use App\Model\Position;

class PositionsController extends Controller
{
    public function index()
    {
        return response()->json([
            'code' => 200,
            'message' => 'Load thành công',
            'positions' => Position::select(['id', 'code', 'name', 'created_at'])->orderBy('id', 'desc')->get()
        ]);
    }

    public function store(StoreRequest $request)
    {
        $position = Position::create($request->all());
        
        return response()->json([
            'code' => 200,
            'message' => 'Thêm thành công!',
            'position' => $position,
        ]);
    }

    public function edit($id)
    {
        return response()->json([
            'code' => 200,
            'message' => 'Đã lấy được thông tin!',
            'position' => Position::findOrFail($id),
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $position = Position::findOrFail($id);
        $position->update($request->all());

        return response()->json([
            'code' => 200,
            'message' => 'Sửa thành công!',
            'position' => $position,
        ]);
    }

    public function destroy($id)
    {
        Position::findOrFail($id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Xóa thành công!',
        ]);
    }
}
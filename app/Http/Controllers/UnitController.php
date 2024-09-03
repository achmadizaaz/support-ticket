<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    protected $model;
    public function __construct(Unit $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $units = $this->model->latest()->paginate(10);
        return view('unit.index', compact('units'));
    }

    public function store(UnitRequest $request)
    {
        $this->model->create(['name' => $request->name]);   
        return to_route('unit')->with('success', 'Unit berhasil ditambahkan!');
    }

    public function show($id)
    {
        return response()->json($this->model->find($id));
    }

    public function update(UnitRequest $request, $id)
    {
        $this->model->where('id', $id)->update(['name'=> $request->name]);
        return back()->with('success', 'Unit berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->model->find($id)->delete();
        return back()->with('success', 'Unit berhasil diperbarui!');
    }
}

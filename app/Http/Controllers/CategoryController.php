<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnArgument;

class CategoryController extends Controller
{
    protected $model;
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $categories = $this->model->latest()->paginate(10);
        return view('category.index', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $this->model->create(['name' => $request->name]);   
        return to_route('category')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show($id)
    {
        return response()->json($this->model->find($id));
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->model->where('id', $id)->update(['name'=> $request->name]);
        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->model->find($id)->delete();
        return back()->with('success', 'Kategori berhasil diperbarui!');
    }
}

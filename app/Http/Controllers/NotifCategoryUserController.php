<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotifCategoryUserRequest;
use App\Models\Category;
use App\Models\NotifCategoryUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifCategoryUserController extends Controller
{
    protected $model, $user, $category;

    public function __construct(NotifCategoryUser $model, User $user, Category $category)
    {
        $this->model = $model;
        $this->user = $user;
        $this->category = $category;
    }

    public function index()
    {

        $notifications = $this->user->with(['notif.category'])->whereHas('notif')->paginate(10);
        
        if(Auth::user()->can('Super Administrator')){
            // Mendapatkan user admin
            $users = $this->user->whereHas('roles', function ($query) {
                $query->where('is_admin', 1);
            })->get();
        }else{
            $users = Auth::user();
        }
       

        $categories = $this->category->all();

        return view('notif-category.index', compact('notifications', 'users', 'categories'));
    }

    public function store(NotifCategoryUserRequest $request)
    {
        // Hapus data notif category user
        $user = $this->model->where('user_id', $request->user)->get();

        if(count($user))
        {
            return back()->with('failed', 'Notif user sudah ada, silakan hapus preferensi user terlebih dahulu');
        }

        if(count($request->category)){
            // Tampung data baru notif category
            $data = []; 
            foreach($request->category as $category){
                $data[] = [
                    'user_id' => $request->user,
                    'category_id' => $category
                ];
            }
            $this->model->insert($data);
        }

        return back()->with('success', 'Notif category user berhasil di update');
    }

    public function destroy(Request $request, $user_id)
    {
        if($request->confirm !== 'confirm'){
            return back()->with('failed', 'Konfirmasi penghapusan notifikasi salah');
        }
        $this->model->where('user_id', $user_id)->delete();

        return back()->with('success', 'Notif category user telah berhasil dihapus');
    }

}

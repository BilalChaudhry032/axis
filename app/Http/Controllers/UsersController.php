<?php

namespace App\Http\Controllers;

use App\Models\Button;
use App\Models\ButtonUser;
use App\Models\Page;
use App\Models\PageUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    public function index() {
        $users = User::select('user_id' ,'username', 'name')->get();
        $pages = Page::orderBy('position')->get();
        $buttons = Button::orderBy('position')->get();
        return view('users.index', [
            'users' => $users,
            'pages' => $pages,
            'buttons' => $buttons
        ]);
    }
    public function getUsers(Request $request) {
        if($request->ajax()) {
            $users = User::select('user_id' ,'username', 'name');
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                $actionBtn = '<div class="dropdown-button">
                        <a href="#" class="d-flex align-items-center justify-content-end" data-toggle="dropdown">
                            <div class="menu-icon mr-0">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="user_edit_modal_btn" id="edit_'.$row->user_id.'">Edit</a>
                            <a href="#" class="user_delete_modal_btn" id="delete_'.$row->user_id.'">Delete</a>
                        </div>
                    </div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function store(Request $request) {
        // dd($request);
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->back()->with('message', 'User created successfully!');
    }

    public function getUser() {
        $user_id = $_GET['user_id'];
        $user = User::where('user_id', '=', $user_id)->select('user_id' ,'username', 'name')->first();
        return response()->json(['response'=> $user], 200);
    }

    public function edit(Request $request, $user_id) {
        User::where('user_id', '=', $user_id)->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);

        if(isset($request->password) && strlen($request->password) > 0) {
            User::where('user_id', '=', $user_id)->update([
                'password' => Hash::make($request->password)
            ]);
        }
        return redirect()->back()->with('message', 'User updated successfully!');
    }

    public function destroy($user_id) {
        User::where('user_id', '=', $user_id)->delete();

        return redirect()->back()->with('message', 'User deleted successfully!');
    }

    public function getPageUser() {
        $user_id = $_GET['user_id'];
        $isPage = PageUser::join('page', 'page.page_id', '=', 'page_user.page_id')
        ->where('page_user.user_id', '=', $user_id)
        ->select('page_user.page_id', 'page.name')->get();
        // dd($isPageList);
        $pages = Page::orderBy('position')->get();
        return response()->json(['isPage'=> $isPage, 'pages' => $pages], 200);
    }

    public function updateUserRights() {
        $page_id = $_POST['page_id'];
        $user_id = $_POST['user_id'];
        $isAllowed = $_POST['isAllowed'];

        if($isAllowed) {
            PageUser::create([
                'page_id' => $page_id,
                'user_id' => $user_id
            ]);
        } else {
            PageUser::where([
                ['page_id', '=', $page_id],
                ['user_id', '=', $user_id]
            ])->delete();
        }
        return response()->json(200);
    }

    public function getButtoneUser() {
        $user_id = $_GET['user_id'];
        $isButton = ButtonUser::join('button_page', 'button_page.button_page_id', '=', 'button_user.button_page_id')
        ->where('button_user.user_id', '=', $user_id)
        ->select('button_page.button_id')->get();
        // dd($isButton);
        $buttons = Button::orderBy('position')->get();
        return response()->json(['isButton'=> $isButton, 'buttons' => $buttons], 200);
    }

    public function updateButtonUser() {
        $button_id = $_POST['button_id'];
        $user_id = $_POST['user_id'];
        $isAllowed = $_POST['isAllowed'];
        
        if($isAllowed) {
            ButtonUser::create([
                'button_page_id' => $button_id,
                'user_id' => $user_id
            ]);
        } else {
            ButtonUser::where([
                ['button_page_id', '=', $button_id],
                ['user_id', '=', $user_id]
            ])->delete();
        }
        return response()->json(200);
    }
}

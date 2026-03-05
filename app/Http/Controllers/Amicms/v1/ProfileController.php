<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Helper\UploadFile;
use App\Http\Controllers\AmicmsController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends AmicmsController {
    use UploadFile;

    private $layout = [];
    private $phone;

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Мій профіль';

    }

    public function index() {
        $profile = User::find(\request()->user()->id);
        return view('amicms.profile.index', ['layout' => $this->layout, 'profile' => $profile]);

    }

    public function edit() {
        $profile = User::find(\request()->user()->id);
        return view('amicms.profile.edit', ['layout' => $this->layout, 'profile' => $profile]);

    }

    public function update(Request $request) {
        $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
        $request->merge([
            'phone' => $this->phone,
        ]);

        if(!empty($request->password)) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(\request()->user()->id)],
                'password' => ['required_with:password_confirmation', 'string', 'min:6', 'confirmed'],
                'password_confirmation' => ['required', 'same:password', 'string', 'min:6'],

            ]);

        } else {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(\request()->user()->id)],
            ]);


        }
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }

        $user = User::find(\request()->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone ? $this->phone : null;
        $user->email = $request->email;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        if($file = $request->file('photo')) {
            $_photo = json_encode($this->uploadPhoto($file, 'users', 300, 300), true);
            $photo = json_decode($_photo, true);
            $user->photo = $photo['original'];
        }


        $user->save();

        return redirect()->route('amicms::profile.index')->with('success', 'Дані успішно збережені');


    }


    public function removeFile($client_id) {
        $user = User::find($client_id);
        $srcPath = public_path('storage/users/' . $user->photo);
        if(file_exists($srcPath) && !empty($user->photo)) {
            if($user) {
                $user->photo = null;
                $user->save();
            }
            unlink($srcPath);

            return redirect()->back()->with('success', 'Зображення успішно видалено');

        }

    }

}

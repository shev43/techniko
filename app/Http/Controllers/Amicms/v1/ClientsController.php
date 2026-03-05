<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Helper\UploadFile;
use App\Http\Controllers\AmicmsController;
use App\Models\BusinessContacts;
use App\Models\User;
use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientsController extends AmicmsController {
    private $layout = [];
    private $phone;

    use UploadFile;

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Клієнти';

    }

    public function index() {
        $query = str_replace([' ', '-', '+', '(', ')'], '', \request()->get('q'));

        $clients_array = User::where('account_type', 2)->withTrashed();

        if(!empty($query)) {
            $clients_array->where('profile_number', 'like', '%' . $query . '%')
                ->orWhere('phone', 'like', '%' . $query . '%')
                ->orWhere('first_name', 'like', '%' . $query . '%')
                ->orWhere('last_name', 'like', '%' . $query . '%');
        }

        $clients_array = $clients_array->paginate(env('AMICMS_PER_PAGE'));

        return view('amicms.clients.index', ['layout' => $this->layout, 'clients_array' => $clients_array]);

    }

    public function create() {
        return view('amicms.clients.create', ['layout' => $this->layout]);

    }

    public function store(Request $request) {
        $this->phone = str_replace([' ', '-', '+'], '', $request->get('phone'));
        $request->merge([
            'phone' => $this->phone,
        ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => ['required', Rule::unique('users')],
            'address' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }

        $latestEntry = User::get();

        $client = new User();
        $client->account_type = 2;
        $client->profile_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->phone = $request->phone;
        $client->address = $request->address;

        if($file = $request->file('photo')) {
            $_photo = json_encode($this->uploadPhoto($file, 'users', 300, 300), true);
            $photo = json_decode($_photo, true);
            $client->photo = $photo['original'];
        }

        $client->save();

        return redirect()->route('amicms::clients.index')->with('success', 'Дані успішно збережені');

    }

    public function edit($client_id) {
        $client = User::find($client_id);
        return view('amicms.clients.edit', ['layout' => $this->layout, 'client' => $client]);

    }

    public function update(Request $request, $client_id) {
        $this->phone = str_replace([' ', '-', '+'], '', $request->get('phone'));
        $request->merge([
            'phone' => $this->phone,
        ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => ['required', Rule::unique('users')->ignore($client_id)],
            'address' => 'required',

        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }


        $client = User::find($client_id);
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->phone = $request->phone;
        $client->address = $request->address;
        if($file = $request->file('photo')) {
            $_photo = json_encode($this->uploadPhoto($file, 'users', 300, 300), true);
            $photo = json_decode($_photo, true);
            $client->photo = $photo['original'];
        }
        $client->save();


        return redirect()->route('amicms::clients.index')->with('success', 'Дані успішно збережені');

    }

    public function destroy($client_id) {
        User::find($client_id)->delete();
        return redirect()->route('amicms::clients.index')->with('success', 'Дані успішно видалені');

    }

    public function destroyWithTrash($client_id) {
        User::onlyTrashed()->find($client_id)->forceDelete();
        return redirect()->route('amicms::clients.index')->with('success', 'Дані успішно видалені');

    }

    public function restore($client_id) {
        User::onlyTrashed()->find($client_id)->restore();
        return redirect()->route('amicms::clients.index')->with('success', 'Дані успішно відновлено');

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

<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Helper\UploadFile;
use App\Http\Controllers\AmicmsController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends AmicmsController {
    private $layout = [];
    private $phone;

        use UploadFile;

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Адміністратори';

    }

    public function index() {
        $users_array = User::whereIn('account_type', [0,1])->withTrashed()->paginate(env('AMICMS_PER_PAGE'));
        return view('amicms.users.index', ['layout' => $this->layout, 'users_array' => $users_array]);

    }

    public function create() {
        return view('amicms.users.create', ['layout' => $this->layout]);

    }

    public function store(Request $request) {

//        dd($request->all());

        $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
        $request->merge([
            'phone' => $this->phone,
        ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required_with:password_confirmation', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'same:password', 'string', 'min:6'],

        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');
        }

        $latestEntry = User::get();

        $user = new User();
        $user->account_type = $request->account_type ?? 1;
        $user->profile_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $this->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if($file = $request->file('photo')) {
            $_photo = json_encode($this->uploadPhoto($file, 'users', 300, 300), true);
            $photo = json_decode($_photo, true);
            $user->photo = $photo['original'];
        }
        $user->save();

        $access_array = [
            [
                'user_id' => $user->id,
                'module' =>  'business.index',
                'access' => ($request->business_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.create',
                'access' => ($request->business_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.destroy',
                'access' => ($request->business_switch_delete) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.import',
                'access' => ($request->business_import_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.company.edit',
                'access' => ($request->business_company_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.profile.index',
                'access' => ($request->business_profile_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.profile.edit',
                'access' => ($request->business_profile_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.contacts.index',
                'access' => ($request->business_contacts_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.contacts.create',
                'access' => ($request->business_contacts_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.contacts.edit',
                'access' => ($request->business_contacts_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.contacts.destroy',
                'access' => ($request->business_contacts_switch_delete) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.subscription.index',
                'access' => ($request->business_subscription_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'orders.index',
                'access' => ($request->orders_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'orders.edit',
                'access' => ($request->orders_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'subscription.index',
                'access' => ($request->subscription_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'reports.index',
                'access' => ($request->reports_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'clients.index',
                'access' => ($request->clients_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'clients.create',
                'access' => ($request->clients_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'clients.edit',
                'access' => ($request->clients_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'clients.destroy',
                'access' => ($request->clients_switch_delete) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'users.index',
                'access' => ($request->users_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'users.create',
                'access' => ($request->users_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'users.edit',
                'access' => ($request->users_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'users.destroy',
                'access' => ($request->users_switch_delete) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'mailing.index',
                'access' => ($request->mailing_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machines.create',
                'access' => ($request->settings_technics_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machines.edit',
                'access' => ($request->settings_technics_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machines.destroy',
                'access' => ($request->settings_technics_switch_delete) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machine-categories.index',
                'access' => ($request->settings_technics_category_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machine-categories.create',
                'access' => ($request->settings_technics_category_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machine-categories.edit',
                'access' => ($request->settings_technics_category_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machine-categories.destroy',
                'access' => ($request->settings_technics_category_switch_delete) ?? 0,
            ]
        ];


        Role::insert($access_array);

        return redirect()->route('amicms::users.index')->with('success', 'Дані успішно збережені');

    }

    public function edit($user_id) {
        $user = User::with('currentRoles')->where('id', $user_id)->first();
        $currentRoles = [];
        foreach($user->roles() as $key => $modules) {
            $arr = [$modules->module=>$modules->access];
            $currentRoles = array_merge($currentRoles, $arr);

        }

        return view('amicms.users.edit', ['layout' => $this->layout, 'user' => $user, 'current_role' => $currentRoles]);

    }

    public function update(Request $request, $user_id) {
        $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
        $request->merge([
            'phone' => $this->phone,
        ]);

        if(!empty($request->password)) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user_id)],
                'password' => ['required_with:password_confirmation', 'string', 'min:6', 'confirmed'],
                'password_confirmation' => ['required', 'same:password', 'string', 'min:6'],

            ]);

        } else {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user_id)],
            ]);


        }
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }

        $user = User::find($user_id);
        $user->account_type = $request->account_type ?? 1;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $this->phone;
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

        $access_array = [
            [
                'user_id' => $user->id,
                'module' =>  'business.index',
                'access' => ($request->business_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.create',
                'access' => ($request->business_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.destroy',
                'access' => ($request->business_switch_delete) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.import',
                'access' => ($request->business_import_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.company.edit',
                'access' => ($request->business_company_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.profile.index',
                'access' => ($request->business_profile_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.profile.edit',
                'access' => ($request->business_profile_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.contacts.index',
                'access' => ($request->business_contacts_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.contacts.create',
                'access' => ($request->business_contacts_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.contacts.edit',
                'access' => ($request->business_contacts_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.contacts.destroy',
                'access' => ($request->business_contacts_switch_delete) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'business.subscription.index',
                'access' => ($request->business_subscription_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'orders.index',
                'access' => ($request->orders_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'orders.edit',
                'access' => ($request->orders_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'subscription.index',
                'access' => ($request->subscription_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'reports.index',
                'access' => ($request->reports_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'clients.index',
                'access' => ($request->clients_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'clients.create',
                'access' => ($request->clients_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'clients.edit',
                'access' => ($request->clients_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'clients.destroy',
                'access' => ($request->clients_switch_delete) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'users.index',
                'access' => ($request->users_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'users.create',
                'access' => ($request->users_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'users.edit',
                'access' => ($request->users_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'users.destroy',
                'access' => ($request->users_switch_delete) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'mailing.index',
                'access' => ($request->mailing_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machines.create',
                'access' => ($request->settings_technics_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machines.edit',
                'access' => ($request->settings_technics_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machines.destroy',
                'access' => ($request->settings_technics_switch_delete) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machine-categories.index',
                'access' => ($request->settings_technics_category_switch_view) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machine-categories.create',
                'access' => ($request->settings_technics_category_switch_add) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machine-categories.edit',
                'access' => ($request->settings_technics_category_switch_edit) ?? 0,
            ],[
                'user_id' => $user->id,
                'module' =>  'settings.machine-categories.destroy',
                'access' => ($request->settings_technics_category_switch_delete) ?? 0,
            ]
        ];

        Role::where('user_id', $user_id)->delete();
        Role::insert($access_array);

        return redirect()->route('amicms::users.index')->with('success', 'Дані успішно збережені');

    }

    public function destroy($user_id) {
        User::find($user_id)->forceDelete();
        return redirect()->route('amicms::users.index')->with('success', 'Дані успішно видалені');

    }

    public function destroyWithTrash($user_id) {
        User::onlyTrashed()->find($user_id)->forceDelete();
        return redirect()->route('amicms::users.index')->with('success', 'Дані успішно видалені');

    }

    public function restore($user_id) {
        User::onlyTrashed()->find($user_id)->restore();
        return redirect()->route('amicms::users.index')->with('success', 'Дані успішно відновлено');

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

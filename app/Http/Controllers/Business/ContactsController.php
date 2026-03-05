<?php

    namespace App\Http\Controllers\Business;

    use App\Helper\UploadFile;
    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\BusinessContacts;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class ContactsController extends Controller {
        use UploadFile;

        protected $phone;

        public function index() {
            $business = Business::where('user_id', \request()->user()->id)->first();
            $contacts = BusinessContacts::where('business_id', $business->id)->paginate(env('PER_PAGE', 20));
            if(empty($contacts)) {
                return $this->create();
            }

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Контактні особи' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.settings.contacts.index', [
                'metaTags' => $metaTags,
                'contacts' => $contacts
            ]);

        }

        public function create() {
            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Створити контактну особу' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.settings.contacts.create', ['metaTags' => $metaTags]);

        }

        public function store(Request $request) {
            $business = Business::where('user_id', \request()->user()->id)->first();
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255', 'position' => 'required|max:255', 'phone' => 'required',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні виникла помилка, деталі дивіться нижче');

            }
            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $contact = new BusinessContacts;
            $contact->business_id = $business->id;
            $contact->name = $request->name;
            $contact->photo = ($request->photo ?? null);
            $contact->position = $request->position;
            $contact->phone = $this->phone;
            $contact->save();

            return redirect()->route('business::settings.contacts.index', ['lang' => app()->getLocale()])->with('success', 'Success');

        }

        public function edit($lang, $contact_id) {
            $contact = BusinessContacts::find($contact_id);

            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Редагування контактної особи' : 'Home',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('frontend.business.settings.contacts.edit', [
                'metaTags' => $metaTags,
                'contact' => $contact
            ]);

        }

        public function update(Request $request, $lang, $contact_id) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255', 'position' => 'required|max:255', 'phone' => 'required',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні виникла помилка, деталі дивіться нижче');

            }
//            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $contact = BusinessContacts::find($contact_id);
            $contact->name = $request->name;
            $contact->photo = ($request->photo ?? null);
            $contact->position = $request->position;
            $contact->phoneFormatted = $request->get('phone');
            $contact->save();

            return redirect()->route('business::settings.contacts.index', ['lang' => $lang])->with('success', 'Success');

        }

        public function destroy($lang, $contact_id) {
            $contact = BusinessContacts::find($contact_id);

            $contact->delete();
            return redirect()->route('business::settings.contacts.index', ['lang' => $lang])->with('success', 'Success');

        }

        public function uploadFile(Request $request) {
            if($file = $request->file('photo')) {
                $photo = $this->uploadPhoto($file, 'users', 300, 300);
                return $photo;

            }
        }

        public function removeFile(Request $request) {
            $srcPath = public_path('storage/users/' . $request->filename);
            if(file_exists($srcPath) && !empty($request->filename)) {
                $user = BusinessContacts::where('photo', $request->filename)->first();
                if($user) {
                    $user->photo = null;
                    $user->save();
                }
                unlink($srcPath);
                return true;
            }

        }

    }

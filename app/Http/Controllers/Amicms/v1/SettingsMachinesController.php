<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SettingsMachinesController extends AmicmsController
{

    private $layout = [];
    protected $phone;

    public function __construct()
    {
        $this->is_profile_auth();
        $this->layout['title'] = 'Види техніки';

    }

    public function index()
    {
        $machines = Machine::orderBy('title_uk', 'asc')->paginate(env('AMICMS_PER_PAGE'));
        return view('amicms.settings.machines.index', ['layout' => $this->layout, 'machines' => $machines]);

    }

    public function create()
    {
        return view('amicms.settings.machines.create', ['layout' => $this->layout]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_uk' => 'required|max:255',
            'title_ru' => 'required|max:255',
            'file' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }


        $file = $request->file('file');

        $ext = $file->getClientOriginalExtension();
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        if ($ext === 'svg' || $ext === 'SVG' || $ext === 'txt' || $ext === '') {
            $ext = 'svg';
        }

        $path = public_path('img/technic/' . $fileName);
        if ($ext === 'svg' || $ext === 'SVG' || $ext === 'txt' || $ext === '') {
            File::put($path, $file->get());
        } else {
            $image = Image::make($file);

            $image->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $srcPath = 'img/technic/' . $fileName;
            $image->save(public_path($srcPath));

        }


        $machine = new Machine;
        $machine->title_uk = $request->title_uk;
        $machine->title_ru = $request->title_ru;
        $machine->slug = Str::slug($request->title_uk);
        $machine->file = $fileName;
        $machine->save();


        return redirect()->route('amicms::settings.machines.index')->with('success', 'Дані успішно збережені');

    }


    public function edit($machine_id)
    {
        $machine = Machine::find($machine_id);
        return view('amicms.settings.machines.edit', ['layout' => $this->layout, 'machine' => $machine]);

    }

    public function update(Request $request, $machine_id) {

        if($request->hasFile('file')) {
            $validator = Validator::make($request->all(), [
                'title_uk' => 'required|max:255',
                'title_ru' => 'required|max:255',
                'file' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title_uk' => 'required|max:255',
                'title_ru' => 'required|max:255',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }

        if($request->hasFile('file')) {
            $file = $request->file('file');

            $ext = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            if ($ext === 'svg' || $ext === 'SVG' || $ext === 'txt' || $ext === '') {
                $ext = 'svg';
            }

            $path = public_path('img/technic/' . $fileName);
            if ($ext === 'svg' || $ext === 'SVG' || $ext === 'txt' || $ext === '') {
                File::put($path, $file->get());
            } else {
                $image = Image::make($file);

                $image->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $srcPath = 'img/technic/' . $fileName;
                $image->save(public_path($srcPath));

            }
        }

        $machine = Machine::find($machine_id);
        $machine->title_uk = $request->title_uk;
        $machine->title_ru = $request->title_ru;
        $machine->slug = Str::slug($request->title_uk);
        if($request->hasFile('file')) {
            $machine->file = $fileName;
        }

        $machine->save();


        return redirect()->route('amicms::settings.machines.index')->with('success', 'Дані успішно збережені');

    }

    public function visible($machine_id) {
        $machine = Machine::find($machine_id);
        $machine->visible = !$machine->visible;
        $machine->save();

    }



    public function restore($machine_id)
    {
        Machine::onlyTrashed()->find($machine_id)->restore();
        return redirect()->route('amicms::settings.machines.index')->with('success', 'Дані успішно відновлено');

    }

    public function destroy($machine_id)
    {
        $contact = Machine::find($machine_id);
        $contact->delete();
        return redirect()->route('amicms::settings.machines.index')->with('success', 'Дані успішно видалені');

    }

    public function destroyWithTrash($machine_id)
    {
        Machine::onlyTrashed()->find($machine_id)->forceDelete();
        return redirect()->route('amicms::settings.machines.index')->with('success', 'Дані успішно видалені');

    }


    public function removeFile($machine_id)
    {
        $user = Machine::find($machine_id);
        $srcPath = public_path('img/technic/' . $user->file);
        if (file_exists($srcPath)) {
            unlink($srcPath);
        }

        if ($user) {
            $user->file = null;
            $user->save();
        }

        return redirect()->route('amicms::settings.machines.edit', ['machine_id' => $machine_id]);

    }


}

<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\Machine;
use App\Models\MachineCategory;
use App\Models\MachineCategoryMachine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SettingsMachineCategoriesController extends AmicmsController {
    private $layout = [];
    protected $phone;

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Види техніки';

    }

    public function index() {
        $machineCategories = MachineCategory::orderBy('created_at', 'asc')->paginate(env('AMICMS_PER_PAGE'));
        return view('amicms.settings.machine-categories.index', ['layout' => $this->layout, 'machineCategories' => $machineCategories]);

    }

    public function create() {
        $machines = Machine::orderBy('title_uk', 'asc')->get();
        return view('amicms.settings.machine-categories.create', ['layout' => $this->layout, 'machines'=>$machines]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title_uk' => 'required|max:255',
            'title_ru' => 'required|max:255',
            'has_sections' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }

        $machine = new MachineCategory;
        $machine->title_uk = $request->title_uk;
        $machine->title_ru = $request->title_ru;
        $machine->slug = Str::slug($request->title_uk);
        $machine->has_sections = $request->has_sections;
        $machine->save();



        if($request->has_sections == 1) {
            if(!empty($request->basic_technique)) {
                foreach($request->basic_technique as $basic_technique) {
                    $technique = new MachineCategoryMachine;
                    $technique->machine_id = $basic_technique;
                    $technique->category_id = $machine->id;
                    $technique->is_main = 1;
                    $technique->save();

                }

            }

            if(!empty($request->additional_technique)) {
                foreach($request->additional_technique as $additional_technique) {
                    $technique = new MachineCategoryMachine;
                    $technique->machine_id = $additional_technique;
                    $technique->category_id = $machine->id;
                    $technique->is_main = 0;
                    $technique->save();

                }

            }
        }

        return redirect()->route('amicms::settings.machine-categories.index')->with('success', 'Дані успішно збережені');

    }


    public function edit($machine_categories_id) {
        $machines = Machine::orderBy('title_uk', 'asc')->get();
        $machineCategory = MachineCategory::find($machine_categories_id);

        $arrayMainMachines = MachineCategoryMachine::where('category_id', $machine_categories_id)->where('is_main', 1)->get();
        $arrayOtherMachines = MachineCategoryMachine::where('category_id', $machine_categories_id)->where('is_main', 0)->get();

        $mainMachines = [];
        foreach($arrayMainMachines as $mainMachine) {
            $mainMachines[] = $mainMachine->machine_id;
        }

        $otherMachines = [];
        foreach($arrayOtherMachines as $otherMachine) {
            $otherMachines[] = $otherMachine->machine_id;
        }

        return view('amicms.settings.machine-categories.edit', ['layout' => $this->layout, 'machines'=>$machines, 'machineCategory'=>$machineCategory, 'main' => $mainMachines, 'other' => $otherMachines]);

    }

    public function update(Request $request, $machine_categories_id) {
        $validator = Validator::make($request->all(), [
            'title_uk' => 'required|max:255',
            'title_ru' => 'required|max:255',
            'has_sections' => 'required'

        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }

        $machine = MachineCategory::find($machine_categories_id);
        $machine->title_uk = $request->title_uk;
        $machine->title_ru = $request->title_ru;
        $machine->slug = Str::slug($request->title_uk);
        $machine->has_sections = $request->has_sections;
        $machine->save();

        if($request->has_sections == 1) {
            MachineCategoryMachine::where('category_id', $machine_categories_id)->delete();

            if(!empty($request->basic_technique)) {
                foreach($request->basic_technique as $basic_technique) {
                    $technique = new MachineCategoryMachine;
                    $technique->machine_id = $basic_technique;
                    $technique->category_id = $machine->id;
                    $technique->is_main = 1;
                    $technique->save();

                }

            }

            if(!empty($request->additional_technique)) {
                foreach($request->additional_technique as $additional_technique) {
                    $technique = new MachineCategoryMachine;
                    $technique->machine_id = $additional_technique;
                    $technique->category_id = $machine->id;
                    $technique->is_main = 0;
                    $technique->save();

                }

            }
        }


        return redirect()->route('amicms::settings.machine-categories.index')->with('success', 'Дані успішно збережені');

    }


    public function restore($machine_categories_id) {
        MachineCategory::onlyTrashed()->find($machine_categories_id)->restore();
        return redirect()->route('amicms::settings.machine-categories.index')->with('success', 'Дані успішно відновлено');

    }

    public function destroy($machine_categories_id) {
        $contact = MachineCategory::find($machine_categories_id);
        $contact->delete();
        return redirect()->route('amicms::settings.machine-categories.index')->with('success', 'Дані успішно видалені');

    }

    public function destroyWithTrash($machine_categories_id) {
        MachineCategory::onlyTrashed()->find($machine_categories_id)->forceDelete();
        return redirect()->route('amicms::settings.machine-categories.index')->with('success', 'Дані успішно видалені');

    }


}

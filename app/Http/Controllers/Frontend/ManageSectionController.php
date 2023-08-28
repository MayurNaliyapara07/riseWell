<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ManageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ManageSectionController extends Controller
{
    protected $_model;

    public function __construct()
    {
        $this->_model = new ManageSection();
    }

    public function index()
    {
        $manageSection = $this->loadConfig();
        return view('frontend.manage-section.index')->with(compact('manageSection'));
    }
    public function loadConfig(){
        $configArray =  Config::get('manage-section-configuration');
        $configSaved = $this->_model->getData(['name', 'value'])->toArray();
        foreach ($configArray as &$configItems) {
            foreach ($configItems['fields'] as $key => &$configItem) {
                $ckey = array_search($key, array_column($configSaved, 'name'));
                if (!empty($configSaved[$ckey]['value'])) {
                    $configItem['value'] = !empty($configSaved[$ckey]['value']) ? $configSaved[$ckey]['value'] : '';
                }
            }
        }

        return $configArray;
    }


    public function getManageSection()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $configArray = $request->except('_token');
        $configArrayToSave = array_map(function ($key, $value) {
            return ["name" => $key, "value" => $value];
        }, array_keys($configArray), $configArray);
        return $this->_model->saveRecord($configArrayToSave);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\BaseController;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;

class NotificationTemplateController extends BaseController
{

    protected $_model;
    public function __construct()
    {
        $this->_model = new NotificationTemplate();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('master.notificationTemplate.index')->with('AJAX_PATH', 'get-notification-template');
    }

    public function getNotificationTemplate(){
        return $this->_model->getNotificationTemplate();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('master.notificationTemplate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->_model->createRecord($request);

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
        $notificationTemplate= $this->_model->loadModel($id);
        return view('master.notificationTemplate.create')->with(compact('notificationTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge(['notification_template_id' => $id]);
        return $this->_model->createRecord($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus($id){

        $notificationStatus = $this->_model->loadModel($id);
        if (!empty($notificationStatus->status) && $notificationStatus->status == 1) {
            $notificationStatus->update(['status' => '0']);
            return $this->webResponse('Notification Template has been in-active successfully.');
        } else {
            $notificationStatus->update(['status' => '1']);
            return $this->webResponse('Notification Template has been active successfully.');
        }
    }
}

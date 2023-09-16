<?php

namespace App\Models;
use App\Helpers\NotificationTemplate\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\DataTables;

class NotificationTemplate extends BaseModel
{
    use HasFactory;

    protected $table="notification_template";

    protected $primaryKey="notification_template_id";

    protected $fillable = [ 'name', 'subj', 'labs_subj','email_body', 'sms_body', 'shortcodes', 'status'];

    protected $entity = 'notification_template';

    protected $casts = [
        'shortcodes' => 'object'
    ];

    public $filter;

    protected $_helper;

    const STATUS_ACTIVE = '1';

    const STATUS_INACTIVE = '0';

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function getNotificationTemplate(){

        $this->setSelect();
        $this->selectColomns([$this->table . '.status',$this->table . '.subj', $this->table . '.name', $this->table . '.notification_template_id']);
        $model = $this->getQueryBuilder();
        $columnsOrderData = $this->getOrderByFieldAndValue(request()->get("order"), request()->get("columns"), $this->primaryKey, 'DESC');
        $query = DataTables::of($model)->order(function ($query) use ($columnsOrderData) {
            $query->orderBy($columnsOrderData['columnsOrderField'], $columnsOrderData['columnsOrderType']);
        });
        $query = $query->addColumn('action', function ($row) {
            $action = '<a href="' . route('notification-template.edit', $row->notification_template_id) . '" class="ml-3 btn btn-sm btn-warning btn-clean btn-icon" title="Edit"><i class="la la-edit"></i> </a>';
            return $action;
        })->editColumn('status', function ($row) {
            if ($row->status == $this::STATUS_ACTIVE) {
                return '<span class="switch switch-sm switch-icon"><label><input type="checkbox" checked="checked" onclick="updateStatus(\'update-status\',' . $row->notification_template_id . ')" name="select"/><span></span></label></span>';
            } else {
                return '<span class="switch switch-sm switch-icon"><label><input onclick="updateStatus(\'update-status\',' . $row->notification_template_id . ')"  type="checkbox"  /><span></span></label></span>';
            }
        })->addIndexColumn()
            ->rawColumns(['subj', 'name','status','action'])
            ->filter(function ($query) {
                $search_value = request()['search']['value'];
                $column = request()['columns'];
                if (!empty($search_value)) {
                    foreach ($column as $value) {
                        if ($value['searchable'] == 'true') {
                            $query->orWhere('name', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('subj', "LIKE", '%' . trim($search_value) . '%');
                        }
                    }
                }
            });
        return $this->dataTableResponse($query->make(true));
    }

    public function createRecord($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['subj'] = $request['subj'];
        $data['labs_subj'] = $request['labs_subj'];
        $data['email_body'] = $request['email_body'];
        $data['status'] = 1;
        $data['sms_body'] = $request['sms_body'];
        $data['notification_template_id'] = !empty($request['notification_template_id'])?$request['notification_template_id']:'';
        $response = $this->saveRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['event_id'] = $response['event_id'];
            $result['redirectUrl'] = '/notification-template';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;

    }

    public function saveRecord($data)
    {
        if (!empty($data['notification_template_id'])) {
            $rules['subj'] = 'required';
            $rules['email_body'] = 'required';
            $rules['sms_body'] = 'required';
        } else {
            $rules['subj'] = 'required';
            $rules['email_body'] = 'required';
            $rules['sms_body'] = 'required';
        }

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithRules($rules, $data);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }
        $this->beforeSave($data);
        if (isset($data['notification_template_id']) && $data['notification_template_id'] != '') {
            $notificationTemplate = self::findOrFail($data['notification_template_id']);
            $notificationTemplate->update($data);
            $notificationTemplateId = $notificationTemplate->notification_template_id;
            $this->afterSave($data, $notificationTemplate);
        } else {
            $notificationTemplate = self::create($data);
            $this->afterSave($data, $notificationTemplate);
            $notificationTemplateId = $notificationTemplate->notification_template_id;
        }

        $response['success'] = true;
        $response['message'] = !empty($notificationTemplateId) ? $this->successfullyMsg(self::UPDATE_FOR_MSG) : $this->successfullyMsg(self::SAVE_FOR_MSG);
        $response['event_id'] = $notificationTemplateId;
        return $response;
    }
}

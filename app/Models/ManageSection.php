<?php

namespace App\Models;

use App\Helpers\ManageSection\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManageSection extends BaseModel
{
    use HasFactory;

    protected $table = "manage_section";

    protected $primaryKey = "manage_section_id";

    protected $guarded;

    protected $entity = 'manage_section';

    public $filter;

    protected $_helper;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function getData($select = ["*"])
    {
        $this->setSelect();
        $this->selectColomns($select);
        $return = $this->get();
        return $return;
    }

    public function saveRecord($configs)
    {
        collect($configs)->each(function (array $config) {
            self::updateOrCreate(
                ['name' => $config['name']],
                ['value' => !empty($config['value']) ? $config['value'] : '']
            );
        });

        $response['success'] = true;
        $response['message'] = $this->successfullyMsg(self::SAVE_FOR_MSG);
        $response['redirectUrl'] = '/manage-section';
        return $response;
    }
}

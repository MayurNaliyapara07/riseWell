<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends BaseModel
{
    use HasFactory;

    protected $table = "educations";
    protected $primaryKey = "educations_id";
    protected $fillable = ['school_id', 'degree', 'year'];

    protected $entity = 'education';
    public $filter;
    protected $_helper;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
    }

    public function saveDegreeDetails($data)
    {
        $education = self::create([
            'school_id' => $data['school_id'],
            'degree' => $data['degree'],
            'year' => $data['year'],
        ]);

        $response['success'] = true;
        $response['educations_id'] = $education['educations_id'];
        return $response;

    }

}

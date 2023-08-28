<?php

namespace App\Models;

use App\Helpers\User\Helper;
use App\Rules\MatchOldPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Settings extends BaseModel
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper;

    }

    public function userUpdate($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        if ($request->hasFile('image')) {
            $logo = $request->file('image');
            $dir = $this->getFilesDirectory();
            $fileName = uniqid() . '.' . $logo->extension();
            $storagePath = $this->putFileToStorage($dir, $logo, $fileName, 'binary');
            if ($storagePath) {
                $data['avatar'] = $fileName;
            }
        }
        $data['email'] = $request['email'];
        $data['first_name'] = $request['first_name'];
        $data['last_name'] = $request['last_name'];
        $data['country_code'] = $request['country_code'];
        $data['phone_no'] = $request['phone_no'];
        $data['id'] = $request['id'];
        $response = $this->saveRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['id'] = $response['id'];
            $result['redirectUrl'] = '/setting';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function saveRecord($data){

        $rules['first_name'] = 'required';
        $rules['last_name'] = 'required';
        $rules['phone_no'] = 'required|numeric';
        $rules['country_code'] = 'required|numeric';
        $rules['email'] = 'required|email|unique:users,email,'.$data['id'];

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
        $userObj = new User();
        $user = $userObj->findOrFail($data['id']);
        $user->update($data);
        $user_id = $user->id;
        $this->afterSave($data, $user);
        $response['success'] = true;
        $response['message'] = 'User Profile has been updated successfully.';
        $response['id'] = $user_id;
        return $response;
    }

    public function updatePassword($request){

        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['current_password']=$request['current_password'];
        $data['new_password']=$request['new_password'];
        $data['confirm_password']=$request['confirm_password'];
        $response = $this->updateRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['redirectUrl'] = '/setting';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function updateRecord($data){

        $rules['current_password'] = ['required',new MatchOldPassword];
        $rules['new_password'] = 'required';
        $rules['confirm_password'] = ['same:new_password'];

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

        User::find(auth()->user()->id)->update(['password'=> Hash::make($data['new_password'])]);

        $response['success'] = true;
        $response['message'] = 'User Password has been changed successfully.';
        return $response;
    }

}

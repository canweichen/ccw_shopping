<?php
namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Shop\Http\Services\AdminUserService;

class AdminUserController extends BaseController{
    protected $adminUserService;

    public function __construct(AdminUserService $adminUserService){
        $this->adminUserService = $adminUserService;
    }

    public function showAdminUserList(Request $request): array
    {
        $username = $request->input('username','');
        $mobile = $request->input('mobile','');
        $email = $request->input('email','');
        $limit = $request->input('limit',10);
        $data = $this->adminUserService->getAdminUserList($username,$mobile,$email,$limit);
        return $this->success($data);
    }

    public function showAdminUserDetail($adminUserId): array
    {
        if($adminUserId <= 0){
            return $this->errors('管理员不存在');
        }
        $info = $this->adminUserService->getAdminUserDetail($adminUserId);
        if(empty($info)){
            return $this->errors('管理员不存在');
        }
        return $this->success($info);
    }

    public function createAdminUser(Request $request): array
    {
        $rules = $this->getValidationRuleAndMessage();
        $validator = Validator::make($request->all(),$rules['rules'],$rules['message']);
        if($validator->fails()){
            return $this->errors($validator->getMessageBag()->first());
        }
        if(!checkMobile($request->input('admin_user_mobile',''))){
            return $this->errors($rules['message']['admin_user_mobile.min']);
        }
        $result = $this->adminUserService->createAdminUser($request->all());
        if($result['code'] == 500){
            return $this->errors($result['message']);
        }
        return $this->success();
    }

    private function getValidationRuleAndMessage():array{
        return [
            'rules' => [
                'admin_user_name' => 'required|min:2|max:8',
                'admin_user_username' => 'required|min:2|max:8',
                'admin_user_mobile' => 'required|min:11',
                'admin_user_email' => 'required|email',
                'admin_user_password' => 'required|min:6|max:16',
                ],
            'message' => [
                'admin_user_name.required' => '姓名必填',
                'admin_user_name.min' => '姓名允许长度范围是2-8个字符',
                'admin_user_name.max' => '姓名允许长度范围是2-8个字符',
                'admin_user_username.required' => '昵称必填',
                'admin_user_username.min' => '昵称允许的长度是2-8个字符',
                'admin_user_username.max' => '昵称允许的长度是2-8个字符',
                'admin_user_mobile.required' => '手机号必填',
                'admin_user_mobile.min' => '请输入合法的手机号',
                'admin_user_email.required' => '邮箱地址必填',
                'admin_user_email.email' => '请输入合法的邮箱地址',
                'admin_user_password.required' => '密码必填',
                'admin_user_password.min' => '密码允许的长度是6-16个字符',
                'admin_user_password.max' => '密码允许的长度是6-16个字符',
            ]
        ];
    }

    public function editAdminUser(Request $request,$adminUserId): array
    {
        return $this->success($request->all());
    }

    public function deleteAdminUser($adminUserId): array
    {
        $result = $this->adminUserService->deleteAdminUser($adminUserId);
        if(!$result){
            return $this->errors('管理员删除失败');
        }
        return $this->success();
    }

    public function restoreAdminUser($adminUserId): array
    {
        $result = $this->adminUserService->restoreAdminUser($adminUserId);
        if(!$result){
            return $this->errors('管理员复职失败');
        }
        return $this->success();
    }

}

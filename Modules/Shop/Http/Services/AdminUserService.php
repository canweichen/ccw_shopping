<?php
namespace Modules\Shop\Http\Services;

use App\Models\ShopAdminUser;
use Modules\Shop\Http\Repositories\AdminUserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminUserService{
    protected $adminUserRepository;
    public function __construct(AdminUserRepository $adminUserRepository){
        $this->adminUserRepository = $adminUserRepository;
    }

    public function getAdminUserList($username,$mobile,$email,$limit):array
    {
        return $this->adminUserRepository->getAdminUserList($username,$mobile,$email,$limit);
    }

    public function getAdminUserDetail($adminUserId):array
    {
        return $this->adminUserRepository->getAdminUserDetail($adminUserId);
    }

    public function createAdminUser($adminUser):array{
        //check if mobile is in use
        $mobileHasBeenUsed = $this->adminUserRepository->getAdminUserByMobile($adminUser['admin_user_mobile']);
        if(!empty($mobileHasBeenUsed)){
            return simpleResponse(500,'手机号已被使用');
        }
        //check if email is in use
        $emailHasBeenUsed = $this->adminUserRepository->getAdminUserByEmail($adminUser['admin_user_email']);
        if(!empty($emailHasBeenUsed)){
            return simpleResponse(500,'邮箱地址已被使用');
        }
        //save data
        $adminUser['admin_user_salt'] = getPasswordSalt();
        $adminUser['password'] = encodePassword($adminUser['password'],$adminUser['admin_user_salt']);
        $result = $this->adminUserRepository->saveAdminUser($adminUser);
        if(!$result){
            return simpleResponse(500,'管理员创建失败');
        }
        return simpleResponse();
    }

    public function updateAdminUser($adminUserId,$adminUser):array{
        $adminUserInfo = $this->adminUserRepository->getAdminUserDetail($adminUserId);
        if(empty($adminUserInfo)){
            return simpleResponse(500,'管理员未找到');
        }
        if($adminUserInfo['admin_user_mobile'] != $adminUser['admin_user_mobile']){
            //check if mobile is in use
            $mobileHasBeenUsed = $this->adminUserRepository->getAdminUserByMobile($adminUser['admin_user_mobile']);
            if(!empty($mobileHasBeenUsed)){
                return simpleResponse(500,'手机号已被使用');
            }
        }
        if($adminUserInfo['admin_user_email'] != $adminUser['admin_user_email']){
            //check if email is in use
            $emailHasBeenUsed = $this->adminUserRepository->getAdminUserByEmail($adminUser['admin_user_email']);
            if(!empty($emailHasBeenUsed)){
                return simpleResponse(500,'邮箱地址已被使用');
            }
        }
        if(!empty($adminUser['password'])){
            $adminUser['admin_user_salt'] = getPasswordSalt();
            $adminUser['password'] = encodePassword($adminUser['password'],$adminUser['admin_user_salt']);
        }
        //update data
        $result = $this->adminUserRepository->updateAdminUser($adminUserId,$adminUser);
        if(!$result){
            return simpleResponse(500,'管理员更新失败');
        }
        return simpleResponse();
    }

    public function deleteAdminUser($adminUserId):bool
    {
        $info = $this->adminUserRepository->getAdminUserDetail($adminUserId);
        if(empty($info)){
            return true;
        }
        return !empty($this->adminUserRepository->deleteAdminUser($adminUserId));
    }

    public function restoreAdminUser($adminUserId):bool
    {
        return !empty($this->adminUserRepository->restoreAdminUser($adminUserId));
    }

    public function login($mobile,$password):array{
        if(empty($mobile) || empty($password)){
            return simpleResponse(500,'账号和密码必填');
        }
        $adminUser = $this->adminUserRepository->getAdminUserByMobile($mobile);
        if(empty($adminUser)){
            return simpleResponse(500,'账号不存在');
        }
        if($adminUser['password'] != encodePassword($password,$adminUser['admin_user_salt'])){
            return simpleResponse(500,'账号或者密码错误');
        }
        //create token
        $user = ShopAdminUser::find($adminUser['admin_user_id']);
        $token = JWTAuth::claims(['admin_user_id' => $adminUser['admin_user_id']])->fromUser($user);
        if(!$token){
            return simpleResponse(500,'登录失败');
        }
        return simpleResponse(200,'',['admin_user_id' => $adminUser['admin_user_id'],'username' => $adminUser['admin_user_username'],'token' => $token]);
    }
}

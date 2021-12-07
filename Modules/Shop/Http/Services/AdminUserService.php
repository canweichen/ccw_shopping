<?php
namespace Modules\Shop\Http\Services;

use Modules\Shop\Http\Repositories\AdminUserRepository;

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
        $info = $this->adminUserRepository->saveAdminUser($adminUser);
        return simpleResponse();
    }

    public function updateAdminUser($adminUser):array{
        $adminUserInfo = $this->adminUserRepository->getAdminUserDetail($adminUser['admin_user_id']);
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
        if(!empty($adminUser['admin_user_password'])){
            $adminUser['admin_user_salt'] = getPasswordSalt();
        }
        //update data
        $info = $this->adminUserRepository->updateAdminUser($adminUser);
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
}

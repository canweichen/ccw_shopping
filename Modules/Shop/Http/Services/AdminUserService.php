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

    public function deleteAdminUser($adminUserId):bool
    {
        $info = $this->adminUserRepository->getAdminUserDetail($adminUserId);
        if(empty($info)){
            return false;
        }
        return !empty($this->adminUserRepository->deleteAdminUser($adminUserId));
    }

    public function restoreAdminUser($adminUserId):bool
    {
        return !empty($this->adminUserRepository->restoreAdminUser($adminUserId));
    }
}

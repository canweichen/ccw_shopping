<?php
namespace Modules\Shop\Http\Repositories;

use App\Models\AdminUserModel;

class AdminUserRepository{

    public function getAdminUserList($username,$mobile,$email,$limit):array{
        $collect = AdminUserModel::when(!empty($username),function($query) use($username){
                return $query->where('admin_user_username','like',"%{$username}%");
            })
            ->when(!empty($mobile),function($query) use($username){
                return $query->where('admin_user_mobile',$username);
            })
            ->when(!empty($email),function($query) use($email){
                return $query->where('admin_user_email',$email);
            })
            ->orderBy('admin_user_id','desc')
            ->simplePaginate($limit);
        return objectToArray($collect);
    }

    /**
     * @param $mobile
     * @return array
     */
    public function getAdminUserByMobile($mobile): array
    {
        $collect = AdminUserModel::where('admin_user_mobile',$mobile)
            ->where('admin_user_status','>',-1)
            ->first();
        return objectToArray($collect);
    }

    /**
     * @param $email
     * @return array
     */
    public function getAdminUserByEmail($email): array
    {
        $collect = AdminUserModel::where('admin_user_email',$email)
            ->where('admin_user_status','>',-1)
            ->first();
        return objectToArray($collect);
    }

    public function getAdminUserDetail($adminUserId): array
    {
        if($adminUserId <= 0){
            return [];
        }
        return objectToArray(AdminUserModel::find($adminUserId));
    }

    public function deleteAdminUser($adminUserId): bool
    {
        if($adminUserId <= 0){
            return false;
        }
        return AdminUserModel::where('admin_user_id',$adminUserId)->delete();
    }

    public function restoreAdminUser($adminUserId): bool
    {
        if($adminUserId <= 0){
            return false;
        }
        return AdminUserModel::where('admin_user_id',$adminUserId)->restore();
    }

    public function saveAdminUser($adminUser): int
    {
        if(empty($adminUser['admin_user_mobile']) || empty($adminUser['admin_user_email'])){
            return 0;
        }
        return AdminUserModel::insertGetId([
            'admin_user_name' => $adminUser['admin_user_name'] ?? '',
            'admin_user_username' => $adminUser['admin_user_username'] ?? '',
            'admin_user_mobile' => $adminUser['admin_user_mobile'],
            'admin_user_email' => $adminUser['admin_user_email'],
            'admin_user_password' => $adminUser['admin_user_password'],
            'admin_user_salt' => $adminUser['admin_user_salt'],
            'admin_user_avatar' => $adminUser['admin_user_avatar'] ?? '',
            'admin_user_is_admin' => $adminUser['admin_user_is_admin'] ?? 0,
            'admin_user_sex' => $adminUser['admin_user_sex'] ?? 0,
            'admin_user_status' => $adminUser['admin_user_status'] ?? 0
        ]);
    }

    public function updateAdminUser($adminUserId,$adminUser): int
    {
        if($adminUserId <= 0 || empty($adminUser['admin_user_mobile']) || empty($adminUser['admin_user_email'])){
            return 0;
        }
        $data = [
            'admin_user_name' => $adminUser['admin_user_name'] ?? '',
            'admin_user_username' => $adminUser['admin_user_username'] ?? '',
            'admin_user_mobile' => $adminUser['admin_user_mobile'],
            'admin_user_email' => $adminUser['admin_user_email'],
            'admin_user_avatar' => $adminUser['admin_user_avatar'] ?? '',
            'admin_user_is_admin' => $adminUser['admin_user_is_admin'] ?? 0,
            'admin_user_sex' => $adminUser['admin_user_sex'] ?? 0,
            'admin_user_status' => $adminUser['admin_user_status'] ?? 0
        ];
        if(!empty($adminUser['admin_user_password'])){
            $data['admin_user_password'] = $adminUser['admin_user_password'];
            $data['admin_user_salt'] = $adminUser['admin_user_salt'];
        }
        return AdminUserModel::where('admin_user_id',$adminUserId)->update($data);
    }
}

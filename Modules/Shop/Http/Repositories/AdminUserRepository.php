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

    public function getAdminUserDetail($adminUserId): array
    {
        return objectToArray(AdminUserModel::find($adminUserId));
    }

    public function deleteAdminUser($adminUserId): bool
    {
        return AdminUserModel::where('admin_user_id',$adminUserId)->delete();
    }

    public function restoreAdminUser($adminUserId): bool
    {
        return AdminUserModel::where('admin_user_id',$adminUserId)->restore();
    }
}

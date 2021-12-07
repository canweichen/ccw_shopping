<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUserModel extends Model{
    use softDeletes;
    protected $primaryKey = 'admin_user_id';
    protected $table = 'shop_admin_user';
    protected $created_at;
    protected $updated_at;
    protected $deleted_at;
    /**
     * @var string
     */
    private $admin_user_name;
    /**
     * @var string
     */
    private $admin_user_username;
    /**
     * @var string
     */
    private $admin_user_mobile;
    /**
     * @var string
     */
    private $admin_user_email;
    /**
     * @var string
     */
    private $admin_user_password;
    /**
     * @var string
     */
    private $admin_user_salt;
    /**
     * @var int
     */
    private $admin_user_is_admin = 0;
    /**
     * @var int
     */
    private $admin_user_status = 0;
    /**
     * @var string
     */
    private $admin_user_avatar = '';
    /**
     * @var int
     */
    private $admin_user_sex = 0;
    /**
     * @var int
     */
    private $admin_user_count_login = 0;

    /**
     * @return int
     */
    public function getAdminUserSex(): int
    {
        return $this->admin_user_sex;
    }

    /**
     * @param int $admin_user_sex
     */
    public function setAdminUserSex(int $admin_user_sex): void
    {
        $this->admin_user_sex = $admin_user_sex;
    }

    /**
     * @return int
     */
    public function getAdminUserCountLogin(): int
    {
        return $this->admin_user_count_login;
    }

    /**
     * @param int $admin_user_count_login
     */
    public function setAdminUserCountLogin(int $admin_user_count_login): void
    {
        $this->admin_user_count_login = $admin_user_count_login;
    }

    /**
     * @return string
     */
    public function getAdminUserLastLoginDate(): string
    {
        return $this->admin_user_last_login_date;
    }

    /**
     * @param string $admin_user_last_login_date
     */
    public function setAdminUserLastLoginDate(string $admin_user_last_login_date): void
    {
        $this->admin_user_last_login_date = $admin_user_last_login_date;
    }
    /**
     * @var string
     */
    private $admin_user_last_login_date = '';

    /**
     * @return string
     */
    public function getAdminUserMobile(): string
    {
        return $this->admin_user_mobile;
    }

    /**
     * @param string $admin_user_mobile
     */
    public function setAdminUserMobile(string $admin_user_mobile): void
    {
        $this->admin_user_mobile = $admin_user_mobile;
    }

    /**
     * @return string
     */
    public function getAdminUserEmail(): string
    {
        return $this->admin_user_email;
    }

    /**
     * @param string $admin_user_email
     */
    public function setAdminUserEmail(string $admin_user_email): void
    {
        $this->admin_user_email = $admin_user_email;
    }

    /**
     * @return string
     */
    public function getAdminUserPassword(): string
    {
        return $this->admin_user_password;
    }

    /**
     * @param string $admin_user_password
     */
    public function setAdminUserPassword(string $admin_user_password): void
    {
        $this->admin_user_password = $admin_user_password;
    }

    /**
     * @return string
     */
    public function getAdminUserSalt(): string
    {
        return $this->admin_user_salt;
    }

    /**
     * @param string $admin_user_salt
     */
    public function setAdminUserSalt(string $admin_user_salt): void
    {
        $this->admin_user_salt = $admin_user_salt;
    }

    /**
     * @return int
     */
    public function getAdminUserIsAdmin(): int
    {
        return $this->admin_user_is_admin;
    }

    /**
     * @param int $admin_user_is_admin
     */
    public function setAdminUserIsAdmin(int $admin_user_is_admin): void
    {
        $this->admin_user_is_admin = $admin_user_is_admin;
    }

    /**
     * @return int
     */
    public function getAdminUserStatus(): int
    {
        return $this->admin_user_status;
    }

    /**
     * @param int $admin_user_status
     */
    public function setAdminUserStatus(int $admin_user_status): void
    {
        $this->admin_user_status = $admin_user_status;
    }

    /**
     * @return string
     */
    public function getAdminUserAvatar(): string
    {
        return $this->admin_user_avatar;
    }

    /**
     * @param string $admin_user_avatar
     */
    public function setAdminUserAvatar(string $admin_user_avatar): void
    {
        $this->admin_user_avatar = $admin_user_avatar;
    }

    /**
     * @return string
     */
    public function getAdminUserUsername(): string
    {
        return $this->admin_user_username;
    }

    /**
     * @param string $admin_user_username
     */
    public function setAdminUserUsername(string $admin_user_username): void
    {
        $this->admin_user_username = $admin_user_username;
    }

    /**
     * @return string
     */
    public function getAdminUserName(): string
    {
        return $this->admin_user_name;
    }

    /**
     * @param string $admin_user_name
     */
    public function setAdminUserName(string $admin_user_name): void
    {
        $this->admin_user_name = $admin_user_name;
    }
}

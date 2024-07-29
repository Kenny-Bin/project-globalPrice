<?php
namespace App\Models;

class LoginModel extends BaseModel
{
    protected string $childrenTable = 'USER_INFO';
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 로그인 정보 조회
     */
    public function getUserLoginInfo($userId): ?array
    {
        $builder = $this->motionGDB->table($this->childrenTable);
        $builder->select('idx, user_idx, user_id, pw_error_count, cert_error_count, is_login_block, last_login_dt, last_login_ip, frst_reg_dt');
        $builder->where('BINARY(user_id)', $userId);
        return $builder->get()->getRowArray(0);
    }

    public function setCertNoLog($data)
    {
        $builder = $this->motionGDB->table('AUTH_MSG_HIST');
        $builder->insert($data);
    }

    /*
     * 로그인 정보 저장
     */
    public function setLoginInfo($data)
    {
        $userLoginRow = $this->getUserLoginInfo($data['user_id']);

        $builder = $this->motionGDB->table($this->childrenTable);

        if ($userLoginRow) {
            $builder->update($data, ['user_id' => $data['user_id']]);
        } else {
            $builder->insert($data);
        }
    }
}

?>
<?php
namespace App\Models;

class UserModel extends BaseModel
{
    protected string $childrenTable = 'USER_INFO';

    public function __construct()
    {
        parent::__construct();
    }

    public function loginUserChk($loginID, $loginPWD = ''): ?array
    {
        $builder = $this->intergrationDB->table($this->childrenTable . ' AS us');
        $builder->select('us.idx, us.USER_GUBUN, us.user_id, us.user_nm, us.user_pw, us.is_use, us.is_del, us.is_auth_skip, us.mobile_no');
        $builder->where('BINARY(us.user_id)', $loginID);
        $builder->where('us.is_use', 'Y');

        if ($loginPWD) {
            $loginPWD = $this->intergrationDB->escapeString($loginPWD);
            $builder->where("user_pw = SHA2('$loginPWD', 256)", null, false);
        }

        return $builder->get()->getRowArray(0);
    }
}

?>
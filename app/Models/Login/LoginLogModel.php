<?php
namespace App\Models;

use CodeIgniter\Model;

class LoginLogModel extends BaseModel
{
    protected string $childrenTable = 'LOGIN_LOG';
    private \CodeIgniter\Database\BaseConnection $motionGDB;

    public function __construct()
    {
        parent::__construct();
    }

    public function setLoginLog($insertData)
    {
        $builder = $this->motionGDB->table($this->childrenTable);

        return $builder->insert($insertData);
    }
}

?>
<?php

namespace App\Models\GlobalPrice;
use CodeIgniter\Model;

class GlobalPriceMModel extends Model
{

    public function registerCategoryProc($data)
    {
        $builder = $this->db->table('tbl_globalBrandCategory');
        $result = $builder->insert($data);

        return $result;
    }

    public function registerTreatmentProc($data)
    {
        $builder = $this->db->table('tbl_globalBrandTreatment');
        $result = $builder->insert($data);

        return $result;
    }

    public function registerPriceProc($data)
    {
        $builder = $this->db->table('tbl_globalBrandPrice');
        $result = $builder->insert($data);

        return $result;
    }

    public function modifyCategoryProc($data, $where)
    {
        $builder = $this->db->table('tbl_globalBrandCategory');

        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $builder->where($key, $val);
            }
        }

        $result = $builder->update($data);

        return $result;
    }

    public function modifyTreatmentProc($data, $where)
    {
        $builder = $this->db->table('tbl_globalBrandTreatment');

        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $builder->where($key, $val);
            }
        }

        $result = $builder->update($data);

        return $result;
    }

    public function modifyPriceProc($data, $where)
    {
        $builder = $this->db->table('tbl_globalBrandPrice');
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $builder->where($key, $val);
            }
        }

        $result = $builder->update($data);

        return $result;
    }

    public function deleteCategoryProc($data, $where)
    {
        $builder = $this->db->table('tbl_globalBrandCategory');
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $builder->where($key, $val);
            }
        }

        $result = $builder->update($data);

        return $result;
    }

    public function deleteTreatmentProc($data, $where)
    {
        $builder = $this->db->table('tbl_globalBrandTreatment');
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $builder->where($key, $val);
            }
        }

        $result = $builder->update($data);

        return $result;
    }

    public function deletePriceProc($data, $where)
    {
        $builder = $this->db->table('tbl_globalBrandPrice');
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $builder->where($key, $val);
            }
        }

        $result = $builder->update($data);

        return $result;
    }

    public function registerApplyCorpProc($data)
    {
        $builder = $this->db->table('tbl_globalBrandBranch');
        $result = $builder->insert($data);

        return $result;
    }

    public function modifyApplyCorpProc($data, $where)
    {
        $builder = $this->db->table('tbl_globalBrandBranch');
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $builder->where($key, $val);
            }
        }

        $result = $builder->update($data);

        return $result;
    }

    public function categorySortProc($data, $where)
    {
        $builder = $this->db->table('tbl_globalBrandCategory');
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $builder->where($key, $val);
            }
        }

        $result = $builder->update($data);

        return $result;
    }

    public function treatmentSortProc($data, $where)
    {
        $builder = $this->db->table('tbl_globalBrandTreatment');
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $builder->where($key, $val);
            }
        }

        $result = $builder->update($data);

        return $result;
    }

    public function deleteApplyCorpProc($data, $where)
    {
        $builder = $this->db->table('tbl_globalBrandBranch');
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $builder->where($key, $val);
            }
        }

        $result = $builder->update($data);

        return $result;
    }
}
<?php

namespace App\Models\GlobalPrice;


class GlobalPriceModel extends BaseModel
{
    public function getGlobalPriceBrandList()
    {
        $builder = $this->db->table('CORP_BRAND');
        $builder->select('brandCode, brandName');
        $builder->whereIn('brandCode', ['T', 'B']);

        $data = $builder->get()->getResultArray();

        return $data;
    }

    public function getGlobalPriceBranchList($brandCode, $corpCode)
    {
        $builder = $this->db->table('GLOBAL_BRAND_BRANCH AS gb');
        $builder->select('gb.idx, gb.brandCode, gb.corpCode, gb.applyCorp, cp.corpName, gb.isUse');
        $builder->join('tbl_corp AS cp', 'gb.applyCorp = cp.corpCode');
        $builder->where('gb.brandCode', $brandCode);
        $builder->where('gb.corpCode', $corpCode);
        $builder->where('gb.isUse', 'Y');
        $builder->orderBy('gb.sort', 'ASC');

        $data = $builder->get()->getResultArray();

        return $data;
    }

    public function getApplyCorpList($brandCode, $corpCode)
    {
        $builder = $this->db->table('GLOBAL_BRAND_BRANCH AS gb');
        $builder->select('gb.idx, gb.brandCode, gb.corpCode,gb.applyCorp,  cp.corpName, gb.isUse');
        $builder->join('tbl_corp AS cp', 'gb.applyCorp = cp.corpCode');
        $builder->where('gb.brandCode', $brandCode);
        $builder->where('gb.corpCode', $corpCode);
        $builder->orderBy('gb.sort', 'ASC');

        $data = $builder->get()->getResultArray();

        return $data;
    }

    public function getCategoryCodeList($data)
    {
        $builder = $this->db->table('GLOBAL_BRAND_CATEGORY');
        $builder->select('corpCode, pubCode,  pPubCode, codeName, codeLevel, isView, isDel');
        $builder->where('corpCode', $data['corpCode']);
        $builder->where('codeLevel', $data['lvl']);
        $builder->where('isDel', 'N');

        if ($data['pIdx'] != "") {
            $builder->where('pPubCode', $data['pIdx']);
        }

        $builder->orderBy('sort', 'ASC');

        $data = $builder->get()->getResultArray();

        return $data;
    }

    public function getTreamentCodeList($data)
    {
        $builder = $this->db->table('GLOBAL_BRAND_TREATMENT AS gt');
        $builder->select('gt.treatmentCode, gt.cate1, gt.cate2, gt.treatmentName, gt.treatmentMemo, gt.isView, gt.isDel');

        if (!empty($data['schBranch'])) {
            $builder->join('tbl_globalBrandPrice AS gp', 'gt.treatmentCode = gp.treatmentIdx');
            $builder->where('gp.applyCorp', $data['schBranch']);
        }

        $builder->where('gt.isDel', 'N');

        if ($data['pIdx'] != "") {
            $builder->where('gt.cate2', $data['pIdx']);
        }

        if ($data['isSearch'] == 'Y') {
            $schWordArr = explode(',', $data['schWord']);

            $builder->groupStart();
            foreach ($schWordArr as $row) {

                if ($data['schCategory'] == 'category') {
                    if ($schWordArr[0] == $row) {
                        $builder->Like('gt.treatmentName', $row);
                    } else {
                        $builder->orLike('gt.treatmentName', $row);
                    }
                }

                if ($data['schCategory'] == 'memo') {
                    if ($schWordArr[0] == $row) {
                        $builder->Like('gt.treatmentMemo', $row);
                    } else {
                        $builder->orLike('gt.treatmentMemo', $row);
                    }
                }
            }
            $builder->groupEnd();
        }

        $builder->orderBy('gt.sort', 'ASC');

        $data = $builder->get()->getResultArray();

        return $data;
    }

    public function getTreamentPriceList($data)
    {
        $builder = $this->db->table('GLOBAL_BRAND_PRICE AS gp');
        $builder->select('gp.idx, gp.applyCorp, cp.corpName, gp.treatmentIdx, gp.price, gp.memo, gp.isView, gp.isDel');
        $builder->join('tbl_corp AS cp', 'gp.applyCorp = cp.corpCode');
        $builder->where('gp.isDel', 'N');

        if ($data['pIdx'] != "") {
            $builder->where('gp.treatmentIdx', $data['pIdx']);
        }

        if ($data['isSearch'] == 'Y') {
            $builder->where('gp.applyCorp', $data['schBranch']);
        }
        $data = $builder->get()->getResultArray();

        return $data;
    }

    public function getParentCategoryInfo($idx)
    {
        $builder = $this->db->table('GLOBAL_BRAND_CATEGORY');
        $builder->select('corpCode, pubCode, pPubCode, codeName, codeLevel, isView, isDel');
        $builder->where('pubCode', $idx);

        $data = $builder->get()->getRowArray(0);

        return $data;
    }

    public function getChildCategoryInfo($idx)
    {
        $builder = $this->db->table('GLOBAL_BRAND_CATEGORY');
        $builder->select('corpCode, pubCode, pPubCode, codeName, codeLevel, isView, isDel');
        $builder->where('pPubCode', $idx);

        $data = $builder->get()->getResultArray();

        return $data;
    }

    public function getChildTreatmentInfo($idx)
    {
        $builder = $this->db->table('GLOBAL_BRAND_TREATMENT');
        $builder->select('brandCode, applyCorp, treatmentCode, cate1, cate2, treatmentName, treatmentMemo, isView, isDel');
        $builder->where('cate2', $idx);

        $data = $builder->get()->getResultArray();

        return $data;
    }



    public function getChildPriceInfo($idx)
    {
        $builder = $this->db->table('GLOBAL_BRAND_PRICE');
        $builder->select('idx, applyCorp, treatmentIdx, price, memo, isView, isDel');
        $builder->where('treatmentIdx', $idx);

        $data = $builder->get()->getResultArray();

        return $data;
    }

    public function getTreatmentInfo($idx)
    {
        $builder = $this->db->table('GLOBAL_BRAND_TREATMENT');
        $builder->select('brandCode, applyCorp, treatmentCode, cate1, cate2, treatmentName, treatmentMemo, isView, isDel');
        $builder->where('treatmentCode', $idx);

        $data = $builder->get()->getRowArray(0);

        return $data;
    }



    public function getPriceInfo($idx)
    {
        $builder = $this->db->table('GLOBAL_BRAND_PRICE AS gp');
        $builder->select('gp.idx, gp.applyCorp, cp.corpName, gp.treatmentIdx, gp.price, gp.memo, gp.isView, gp.isDel');
        $builder->join('tbl_corp AS cp', 'gp.applyCorp = cp.corpCode');
        $builder->where('gp.idx', $idx);

        $data = $builder->get()->getRowArray(0);

        return $data;
    }

    public function getCategorySortCount($brandCode, $corpCode, $lvl, $pIdx)
    {
        $builder = $this->db->table('GLOBAL_BRAND_CATEGORY');
        $builder->select('IFNULL(MAX(sort), 0) AS cnt');
        $builder->where('brandCode', $brandCode);
        $builder->where('corpCode', $corpCode);
        $builder->where('codeLevel', $lvl);
        $builder->where('isDel', 'N');

        if ($pIdx != 0) {
            $builder->where('pPubCode', $pIdx);
        }

        $data = $builder->get()->getRowArray(0);

        return $data;
    }

    public function getTreatmentSortCount($brandCode, $corpCode, $pIdx)
    {
        $builder = $this->db->table('GLOBAL_BRAND_TREATMENT');
        $builder->select('IFNULL(MAX(sort), 0) AS cnt');
        $builder->where('brandCode', $brandCode);
        $builder->where('applyCorp', $corpCode);
        $builder->where('cate2', $pIdx);
        $builder->where('isDel', 'N');

        $data = $builder->get()->getRowArray(0);

        return $data;
    }

    public function registerCategoryProc($data)
    {
        $builder = $this->db->table('GLOBAL_BRAND_CATEGORY');
        $result = $builder->insert($data);

        return $result;
    }

    public function registerTreatmentProc($data)
    {
        $builder = $this->db->table('GLOBAL_BRAND_TREATMENT');
        $result = $builder->insert($data);

        return $result;
    }

    public function registerPriceProc($data)
    {
        $builder = $this->db->table('GLOBAL_BRAND_PRICE');
        $result = $builder->insert($data);

        return $result;
    }

    public function modifyCategoryProc($data, $where)
    {
        $builder = $this->db->table('GLOBAL_BRAND_CATEGORY');

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
        $builder = $this->db->table('GLOBAL_BRAND_TREATMENT');

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
        $builder = $this->db->table('GLOBAL_BRAND_PRICE');
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
        $builder = $this->db->table('GLOBAL_BRAND_CATEGORY');
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
        $builder = $this->db->table('GLOBAL_BRAND_TREATMENT');
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
        $builder = $this->db->table('GLOBAL_BRAND_PRICE');
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
        $builder = $this->db->table('GLOBAL_BRAND_BRANCH');
        $result = $builder->insert($data);

        return $result;
    }

    public function modifyApplyCorpProc($data, $where)
    {
        $builder = $this->db->table('GLOBAL_BRAND_BRANCH');
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
        $builder = $this->db->table('GLOBAL_BRAND_CATEGORY');
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
        $builder = $this->db->table('GLOBAL_BRAND_TREATMENT');
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
        $builder = $this->db->table('GLOBAL_BRAND_BRANCH');
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $builder->where($key, $val);
            }
        }

        $result = $builder->update($data);

        return $result;
    }
}
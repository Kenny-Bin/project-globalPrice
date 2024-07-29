<?php
namespace App\Services;

use App\Models\GlobalPrice\GlobalPriceModel;
use App\Models\GlobalPrice\GlobalPriceModel;
use PhpOffice\PhpSpreadsheet\Exception;

class GlobalPriceService
{
    private static $globalPriceService = null;

    public static function factory()
    {
        if (self::$globalPriceService === null) {
            self::$globalPriceService = new GlobalPriceService();
        }
        return self::$globalPriceService;
    }

    public function getGlobalPriceBrandList()
    {
        $globalPriceSM = new GlobalPriceModel();

        return $globalPriceSM->getGlobalPriceBrandList();
    }

    public function getGlobalPriceBranchList($brandCode, $corpCode)
    {
        $globalPriceSM = new GlobalPriceModel();

        return $globalPriceSM->getGlobalPriceBranchList($brandCode, $corpCode);
    }

    public function getApplyCorpList($brandCode, $corpCode)
    {
        $globalPriceSM = new GlobalPriceModel();

        return $globalPriceSM->getApplyCorpList($brandCode, $corpCode);
    }

    public function getCategoryCodeList($param)
    {
        $globalPriceSM = new GlobalPriceModel();

        return $globalPriceSM->getCategoryCodeList($param);
    }

    public function getTreamentCodeList($param)
    {
        $globalPriceSM = new GlobalPriceModel();

        return $globalPriceSM->getTreamentCodeList($param);
    }

    public function getTreamentPriceList($param)
    {
        $globalPriceSM = new GlobalPriceModel();

        return $globalPriceSM->getTreamentPriceList($param);
    }

    public function getParentCategoryInfo($idx)
    {
        $globalPriceSM = new GlobalPriceModel();

        return $globalPriceSM->getParentCategoryInfo($idx);
    }

    public function getTreatmentInfo($idx)
    {
        $globalPriceSM = new GlobalPriceModel();

        return $globalPriceSM->getTreatmentInfo($idx);
    }

    public function getPriceInfo($idx)
    {
        $globalPriceSM = new GlobalPriceModel();

        return $globalPriceSM->getPriceInfo($idx);
    }

    public function getCategorySortCount($brandCode, $corpCode, $lvl, $pIdx)
    {
        $globalPriceSM = new GlobalPriceModel();

        return $globalPriceSM->getCategorySortCount($brandCode, $corpCode, $lvl, $pIdx);
    }

    public function getTreatmentSortCount($brandCode, $corpCode, $pIdx)
    {
        $globalPriceSM = new GlobalPriceModel();

        return $globalPriceSM->getTreatmentSortCount($brandCode, $corpCode, $pIdx);
    }

    public function modifyCategoryProc($data, $where)
    {
        $globalPriceMM = new GlobalPriceModel();

        return $globalPriceMM->modifyCategoryProc($data, $where);
    }

    public function modifyTreatmentProc($data, $where)
    {
        $globalPriceMM = new GlobalPriceModel();

        return $globalPriceMM->modifyTreatmentProc($data, $where);
    }

    public function modifyPriceProc($data, $where)
    {
        $globalPriceMM = new GlobalPriceModel();

        return $globalPriceMM->modifyPriceProc($data, $where);
    }

    public function registerCategoryProc($param)
    {
        $globalPriceMM = new GlobalPriceModel();

        return $globalPriceMM->registerCategoryProc($param);
    }

    public function registerTreatmentProc($param)
    {
        $globalPriceMM = new GlobalPriceModel();

        return $globalPriceMM->registerTreatmentProc($param);
    }

    public function registerPriceProc($param)
    {
        $globalPriceMM = new GlobalPriceModel();

        return $globalPriceMM->registerPriceProc($param);
    }

    public function deleteProc($info, $data, $where)
    {

        $globalPriceSM = new GlobalPriceModel();
        $globalPriceMM = new GlobalPriceModel();

        $result = [
            'result' => false,
            'msg' => '알 수 없는 에러가 발생하였습니다.'
        ];

        $globalPriceMM->db->transBegin();

        $lvl = $info['lvl'];
        try {
            if ($lvl == '1') {      // 1차 카테고리 삭제
                $where['1']['pubCode'] = $info['idx'];
                $success = $globalPriceMM->deleteCategoryProc($data, $where['1']);
                if (!$success) {
                    throw new \Exception('1차 카테고리 삭제 중 에러가 발생하였습니다.');
                }

                $categoryInfo = $globalPriceSM->getChildCategoryInfo($info['idx']);     // 2차 카테고리 가져오기

                if (count($categoryInfo) > 0) {     // 2차 카테고리 존재
                    $where['2']['pPubCode'] = $info['idx'];
                    $success = $globalPriceMM->deleteCategoryProc($data, $where['2']);
                    if (!$success) {
                        throw new \Exception('2차 카테고리 삭제 중 에러가 발생하였습니다.');
                    }

                    foreach ($categoryInfo as $row) {
                        $treatmentInfo = $globalPriceSM->getChildTreatmentInfo($row['pubCode']);     // 3차 카테고리(시술 정보) 가져오기

                        if (count($treatmentInfo) > 0) {    // 3차 카테고리(시술) 존재
                            $where['3']['applyCorp'] = $info['corpCode'];
                            $where['3']['cate2'] = $row['pubCode'];
                            $success = $globalPriceMM->deleteTreatmentProc($data, $where['3']);
                            if (!$success) {
                                throw new \Exception('시술 정보 삭제 중 에러가 발생하였습니다.');
                            }
                            $priceInfo = $globalPriceSM->getPriceInfo($treatmentInfo[0]['treatmentCode']);      // 4차 카테고리(가격 정보) 가져오기

                            if ($priceInfo) {    // 4차 카테고리(가격정보) 존재
                                $where['4']['treatmentIdx'] = $treatmentInfo[0]['treatmentCode'];
                                $success = $globalPriceMM->deletePriceProc($data, $where['4']);
                                if (!$success) {
                                    throw new \Exception('가격 정보 삭제 중 에러가 발생하였습니다.');
                                }
                            }
                        }
                    }
                }
            } else if ($lvl == '2') {
                $where['2']['pubCode'] = $info['idx'];
                $success = $globalPriceMM->deleteCategoryProc($data, $where['2']);
                if (!$success) {
                    throw new \Exception('2차 카테고리 삭제 중 에러가 발생하였습니다.');
                }

                $treatmentInfo = $globalPriceSM->getChildTreatmentInfo($info['idx']);     // 3차 카테고리(시술 정보) 가져오기

                if (count($treatmentInfo) > 0) {    // 3차 카테고리(시술) 존재
                    $where['3']['applyCorp'] = $info['corpCode'];
                    $where['3']['cate2'] = $info['idx'];
                    $success = $globalPriceMM->deleteTreatmentProc($data, $where['3']);
                    if (!$success) {
                        throw new \Exception('시술 정보 삭제 중 에러가 발생하였습니다.');
                    }

                    foreach ($treatmentInfo as $row) {
                        $priceInfo = $globalPriceSM->getChildPriceInfo($row['treatmentCode']);      // 4차 카테고리(가격 정보) 가져오기

                        if (count($priceInfo) > 0) {    // 4차 카테고리(가격정보) 존재
                            $where['4']['treatmentIdx'] = $row['treatmentCode'];
                            $success = $globalPriceMM->deletePriceProc($data, $where['4']);
                            if (!$success) {
                                throw new \Exception('가격 정보 삭제 중 에러가 발생하였습니다.');
                            }
                        }
                    }
                }
            } else if ($lvl == '3') {
                $where['3']['applyCorp'] = $info['corpCode'];
                $where['3']['treatmentCode'] = $info['idx'];
                $success = $globalPriceMM->deleteTreatmentProc($data, $where['3']);
                if (!$success) {
                    throw new \Exception('시술 정보 삭제 중 에러가 발생하였습니다.');
                }
                $priceInfo = $globalPriceSM->getChildPriceInfo($info['idx']);      // 4차 카테고리(가격 정보) 가져오기

                if (count($priceInfo) > 0) {    // 4차 카테고리(가격정보) 존재
                    $where['4']['treatmentIdx'] = $info['idx'];
                    $success = $globalPriceMM->deletePriceProc($data, $where['4']);
                    if (!$success) {
                        throw new \Exception('가격 정보 삭제 중 에러가 발생하였습니다.');
                    }
                }
            } else if ($lvl == '4') {
                $where['4']['idx'] = $info['idx'];
                $success = $globalPriceMM->deletePriceProc($data, $where['4']);
                if (!$success) {
                    throw new \Exception('가격 정보 삭제 중 에러가 발생하였습니다.');
                }
            }

            $globalPriceMM->db->transCommit();
            $result = [
                'result' => true,
                'msg' => '삭제 되었습니다.',
            ];

        } catch ( \Throwable $e ){
            $globalPriceMM->db->transRollback();
            $result['msg'] = $e->getMessage();
        }

        return $result;
    }

    public function categorySortProc($data)
    {
        $globalPriceMM = new GlobalPriceModel();

        $result = [
            'result' => false,
            'msg' => '알 수 없는 에러가 발생하였습니다.'
        ];
        $globalPriceMM->db->transBegin();
        try {
            $categoryLvl1 = $data['categoryLvl1'];
            $categoryLvl2 = $data['categoryLvl2'];
            $categoryLvl3 = $data['categoryLvl3'];

            if (count($categoryLvl1) > 0) {
                for ( $i = 0; $i < count($categoryLvl1); $i++ ) {
                    $whereData = [
                        'brandCode' => $data['brandCode'],
                        'corpCode' => $data['corpCode'],
                        'pubCode' => $categoryLvl1[$i],
                    ];

                    $modifyData = [
                        'sort' => $i + 1,
                        'modifyId' => $data['userID']
                    ];

                    $success = $globalPriceMM->categorySortProc($modifyData, $whereData);
                    if (!$success) throw new \Exception('1차 카테고리 순서 저장 중 에러가 발생하였습니다.');
                }
            }

            if (count($categoryLvl2) > 0) {
                for ( $i = 0; $i < count($categoryLvl2); $i++ ) {
                    $whereData = [
                        'brandCode' => $data['brandCode'],
                        'corpCode' => $data['corpCode'],
                        'pubCode' => $categoryLvl2[$i],
                    ];
                    $modifyData = [
                        'sort' => $i + 1,
                        'modifyId' => $data['userID']
                    ];

                    $success = $globalPriceMM->categorySortProc($modifyData, $whereData);
                    if (!$success) throw new \Exception('2차 카테고리 순서 저장 중 에러가 발생하였습니다.');
                }
            }

            if (count($categoryLvl3) > 0) {
                for ( $i = 0; $i < count($categoryLvl3); $i++ ) {
                    $whereData = [
                        'brandCode' => $data['brandCode'],
                        'applyCorp' => $data['corpCode'],
                        'treatmentCode' => $categoryLvl3[$i],
                    ];
                    $modifyData = [
                        'sort' => $i + 1,
                        'modifyId' => $data['userID']
                    ];

                    $success = $globalPriceMM->treatmentSortProc($modifyData, $whereData);
                    if (!$success) throw new \Exception('3차 카테고리 순서 저장 중 에러가 발생하였습니다.');
                }
            }

            $globalPriceMM->db->transCommit();
            $result = [
                'result' => true,
                'msg' => '저장 되었습니다.',
            ];

        } catch (\Exception $e) {
            $globalPriceMM->db->transRollback();
            $result['msg'] = $e->getMessage();
        }

        return $result;
    }

    public function branchSortProc($sqlData, $data)
    {
        $globalPriceSM = new GlobalPriceModel();
        $globalPriceMM = new GlobalPriceModel();

        $result = [
            'result' => false,
            'msg' => '알 수 없는 에러가 발생하였습니다.'
        ];

        $globalPriceMM->db->transBegin();

        try {
            $applyCorpList = $data['applyCorpList'];    // 현재 적용 지점 리스트
            $applyCorpPackage = $data['applyCorpPackage'];  // 수정 적용 지점 리스트

            // 삭제
            foreach ($applyCorpList as $row) {
                if (in_array($row['applyCorp'], $applyCorpPackage)) continue;   // 수정 리스트에 존재

                $sqlData['whereData']['applyCorp'] = $row['applyCorp'];
                $success = $globalPriceMM->deleteApplyCorpProc($sqlData['deleteData'], $sqlData['whereData']);

                if (!$success) throw new \Exception($row['corpName'] . ' 삭제 중 에러가 발생하였습니다.');
            }

            // 저장 및 수정
            $applyCorpKey = array_column($applyCorpList, 'applyCorp');
            $i = 1;
            foreach ($applyCorpPackage as $key => $val) {

                if (in_array($val, $applyCorpKey)) {
                    $sqlData['modifyData']['sort'] = $i;
                    $sqlData['whereData']['applyCorp'] = $val;
                    $success = $globalPriceMM->modifyApplyCorpProc($sqlData['modifyData'], $sqlData['whereData']);
                } else {
                    $sqlData['insertData']['sort'] = $i;
                    $sqlData['insertData']['applyCorp'] = $val;
                    $success = $globalPriceMM->registerApplyCorpProc($sqlData['insertData']);
                }

                if (!$success) throw new \Exception('저장 or 수정 중 에러가 발생하였습니다.');
                $i ++;
            }

            $globalPriceMM->db->transCommit();
            $result = [
                'result' => true,
                'msg' => '저장 되었습니다.',
            ];

        } catch (\Exception $e) {
            $globalPriceMM->db->transRollback();
            $result['msg'] = $e->getMessage();
        }

        return $result;
    }

    public function chgState($lvl, $modifyData, $data)
    {
        $globalPriceMM = new GlobalPriceModel();

        $result = [
            'result' => false,
            'msg' => '알 수 없는 에러가 발생하였습니다.'
        ];

        $globalPriceMM->db->transBegin();

        try {
            if ($lvl == '1' || $lvl == '2') {
                $whereData = [
                    'brandCode' => $data['brandCode'],
                    'corpCode' => $data['corpCode'],
                    'pubCode' => $data['idx'],
                ];

                $result = $globalPriceMM->modifyCategoryProc($modifyData, $whereData);
            } else if ($lvl == '3') {
                $whereData = [
                    'brandCode' => $data['brandCode'],
                    'applyCorp' => $data['corpCode'],
                    'treatmentCode' => $data['idx'],
                ];

                $result = $globalPriceMM->modifyTreatmentProc($modifyData, $whereData);
            } else if ($lvl == '4') {
                $whereData = [
                    'idx' => $data['idx'],
                ];

                $result = $globalPriceMM->modifyPriceProc($modifyData, $whereData);
            }

            if (!$result) {
                throw new \Exception('상태값 수정 중 에러가 발생하였습니다.');
            }

            $globalPriceMM->db->transCommit();

            $result = [
                'result' => true,
                'msg' => '저장 되었습니다.',
            ];

        } catch (\Exception $e) {
            $globalPriceMM->db->transRollback();
            $result['msg'] = $e->getMessage();
        }

        return $result;

    }

}


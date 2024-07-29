<?php

namespace App\Controllers;

use App\Services\CorpService;
use App\Services\GlobalPriceService;

class GlobalPrice extends BaseController
{
    public function index()
    {
        $globalPriceService = GlobalPriceService::factory();

        $corpCode = $this->request->getPostGet('corpCode');
        if ($corpCode == "") $corpCode = 'CODE';    // 지점 기본값
        $brandCode = $this->request->getPostGet('brandCode');
        if ($brandCode == "") $brandCode = substr($corpCode, 0, 1);
        $schBranch = $this->request->getPostGet('schBranch');

        // 브랜드 리스트
        $brandList = $globalPriceService->getGlobalPriceBrandList();

        // 노출 지점 리스트
        $branchList = $globalPriceService->getGlobalPriceBranchList($brandCode, $corpCode);

        $data = [
            'brandCode' => $brandCode,
            'corpCode' => $corpCode,
            'schBranch' => $schBranch,
            'brandList' => $brandList,
            'branchList' => $branchList,
            'common' => $this->common,
            'userConfig'=> $this->userConfig
        ];

        echo view('globalPriceMng/index', $data);
    }

    public function postIndex()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'brandCode' => 'required',
            'corpCode' => 'required',
            'lvl' => 'required',
        ];

        if ( $this->request->getMethod() == 'post' && $this->validate($rules) ) {
            $globalPriceService = GlobalPriceService::factory();

            $corpCode = $this->request->getPostGet('corpCode');
            $brandCode = $this->request->getPostGet('brandCode');
            if ($brandCode == "") $brandCode = substr($corpCode, 0, 1);
            $schBranch = $this->request->getPostGet('schBranch');
            $schCategory = $this->request->getPostGet('schCategory');
            $schWord = $this->request->getPostGet('schWord');
            $pIdx = getValidValue($_POST, 'pIdx', 0);
            $isSearch = $this->request->getPostGet('isSearch');
            $isSel = $this->request->getPostGet('isSel');
            $lvl = $this->request->getPostGet('lvl');

            $categoryList = [];

            $param = [
                'brandCode' => $brandCode,
                'corpCode' => $corpCode,
                'schBranch' => $schBranch,
                'schCategory' => $schCategory,
                'schWord' => $schWord,
                'isSel' => $isSel,
                'isSearch' => $isSearch,
                'pIdx' => $pIdx,
                'lvl' => $lvl,
            ];

            if ($isSel == 'Y') {
                if ( $lvl == '1' || $lvl == '2') {  // 1차, 2차 카테고리
                    $categoryList = $globalPriceService->getCategoryCodeList($param);
                } else if ($lvl == '3') {   // 3차 카테고리
                    $categoryList = $globalPriceService->getTreamentCodeList($param);
                } else if ($lvl == '4') {
                    $categoryList = $globalPriceService->getTreamentPriceList($param);
                }
            }

            $data = [
                'categoryList' => $categoryList,
                'common' => $this->common,
                'userConfig'=> $this->userConfig
            ];

            $data = array_merge($data, $param);

            echo view('globalPriceMng/_index', $data);

        } else {
            $errors = $validation->getErrors();
            $errorMsg = "";
            foreach ($errors as $field => $message) {
                $errorMsg .= "유효성 검사 실패 : ".$field."\\n";
            }
            echo $errorMsg;
        }
    }

    public function register()
    {
        $globalPriceService = GlobalPriceService::factory();

        $brandCode = $this->request->getPostGet('brandCode');
        $corpCode = $this->request->getPostGet('corpCode');

        $data = [
            'brandCode' => $brandCode,
            'corpCode' => $corpCode,
        ];

        echo view('globalPriceMng/register', $data);
    }

    public function postRegister()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'corpCode' => 'required',
            'brandCode' => 'required',
            'lvl' => 'required',
        ];

        if ( $this->request->getMethod() == 'post' && $this->validate($rules) ) {
            $globalPriceService = GlobalPriceService::factory();

            $corpCode = $this->request->getPostGet('corpCode');
            $brandCode = $this->request->getPostGet('brandCode');
            $isSearch = $this->request->getPostGet('isSearch');
            $pIdx = $this->request->getPostGet('pIdx');
            $isSel = $this->request->getPostGet('isSel');
            $lvl = $this->request->getPostGet('lvl');

            // 노출 지점 리스트
            $branchList = $globalPriceService->getGlobalPriceBranchList($brandCode, $corpCode);

            $categoryList = [];

            $param = [
                'brandCode' => $brandCode,
                'corpCode' => $corpCode,
                'isSearch' => $isSearch,
                'isSel' => $isSel,
                'pIdx' => $pIdx,
                'lvl' => $lvl,
            ];

            if ($isSel == 'Y') {
                if ( $lvl == '1' || $lvl == '2') {  // 1차, 2차 카테고리
                    $categoryList = $globalPriceService->getCategoryCodeList($param);
                } else if ($lvl == '3') {   // 3차 카테고리
                    $categoryList = $globalPriceService->getTreamentCodeList($param);
                } else if ($lvl == '4') {
                    $categoryList = $globalPriceService->getTreamentPriceList($param);
                }
            }

            $data = [
                'branchList' => $branchList,
                'categoryList' => $categoryList,
                'common' => $this->common,
                'userConfig'=> $this->userConfig
            ];

            $data = array_merge($data, $param);

            echo view('globalPriceMng/_register', $data);
        } else {
            $errors = $validation->getErrors();
            $errorMsg = "";
            foreach ($errors as $field => $message) {
                $errorMsg .= "유효성 검사 실패 : ".$field."\\n";
            }
            echo $errorMsg;
        }
    }

    public function registerProc()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'corpCode' => 'required',
            'brandCode' => 'required',
            'lvl' => 'required',
        ];

        if ( $this->request->getMethod() == 'post' && $this->validate($rules) ) {
            $globalPriceService = GlobalPriceService::factory();

            $user = $this->userConfig;
            $brandCode = $this->request->getPostGet('brandCode');
            $corpCode = $this->request->getPostGet('corpCode');
            $lvl = $this->request->getPostGet('lvl');
            $pIdx = getValidValue($_POST, 'pIdx', 0);
            $isView = getValidValue($_POST, 'isView', 'N');

            $categoryName = $this->request->getPostGet('categoryName');
            $categoryMemo = $this->request->getPostGet('categoryMemo');
            $selectCorp = $this->request->getPostGet('selectCorp');
            $treatmentPrice = $this->request->getPostGet('treatmentPrice');
            $treatmentMemo = $this->request->getPostGet('treatmentMemo');

            $param = [
                'brandCode' => $brandCode,
                'corpCode' => $corpCode,
                'selectCorp' => $selectCorp,
                'lvl' => $lvl,
                'pIdx' => $pIdx,
                'categoryName' => $categoryName,
                'categoryMemo' => $categoryMemo,
                'treatmentPrice' => $treatmentPrice,
                'treatmentMemo' => $treatmentMemo,
                'isView' => $isView,
                'userID' => $user['userID'],
            ];

            $insertDataArr = $this->insertData($param);     // insert 데이터 가공

            if ($lvl == '1' || $lvl == '2') {
                $result = $globalPriceService->registerCategoryProc($insertDataArr);
            } else if ($lvl == '3') {
                $result = $globalPriceService->registerTreatmentProc($insertDataArr);
            } else if ($lvl == '4') {
                $result = $globalPriceService->registerPriceProc($insertDataArr);
            }

            if ($result) {
                $response['result'] = true;
                $response['msg'] = '등록되었습니다.';
            }

            return json_encode($response);
        } else {
            $errors = $validation->getErrors();
            $errorMsg = "";
            foreach ($errors as $field => $message) {
                $errorMsg .= "유효성 검사 실패 : ".$field."\n";
            }
            $response['msg'] = $errorMsg;

            return json_encode($response);
        }

    }

    public function modifyProc()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'corpCode' => 'required',
            'brandCode' => 'required',
            'idx' => 'required',
            'lvl' => 'required',
        ];

        if ( $this->request->getMethod() == 'post' && $this->validate($rules) ) {
            $globalPriceService = GlobalPriceService::factory();

            $user = $this->userConfig;
            $brandCode = $this->request->getPostGet('brandCode');
            $corpCode = $this->request->getPostGet('corpCode');
            $lvl = $this->request->getPostGet('lvl');
            $idx = $this->request->getPostGet('idx');
            $pIdx = getValidValue($_POST, 'pIdx', 0);
            $isView = getValidValue($_POST, 'isView', 'N');

            $categoryName = $this->request->getPostGet('categoryName');
            $categoryMemo = $this->request->getPostGet('categoryMemo');
            $selectCorp = $this->request->getPostGet('selectCorp');
            $treatmentPrice = $this->request->getPostGet('treatmentPrice');
            $treatmentMemo = $this->request->getPostGet('treatmentMemo');

            $param = [
                'brandCode' => $brandCode,
                'corpCode' => $corpCode,
                'selectCorp' => $selectCorp,
                'lvl' => $lvl,
                'idx' => $idx,
                'pIdx' => $pIdx,
                'categoryName' => $categoryName,
                'categoryMemo' => $categoryMemo,
                'treatmentPrice' => $treatmentPrice,
                'treatmentMemo' => $treatmentMemo,
                'isView' => $isView,
                'userID' => $user['userID'],
            ];

            list($modifyData, $whereData) = $this->modifyData($param);

            if ($lvl == '1' || $lvl == '2' ) {
                $msgTxt = '카테고리';
                $result = $globalPriceService->modifyCategoryProc($modifyData, $whereData);
            } else if ($lvl == '3') {
                $msgTxt = '시술';
                $result = $globalPriceService->modifyTreatmentProc($modifyData, $whereData);
            } else if ($lvl == '4') {
                $msgTxt = '가격';
                $result = $globalPriceService->modifyPriceProc($modifyData, $whereData);
            }

            if ($result) {
                $response['result'] = true;
                $response['msg'] = $msgTxt . ' 정보가 수정되었습니다.';
            }

            return json_encode($response);
        } else {
            $errors = $validation->getErrors();
            $errorMsg = "";
            foreach ($errors as $field => $message) {
                $errorMsg .= "유효성 검사 실패 : ".$field."\n";
            }
            $response['msg'] = $errorMsg;

            return json_encode($response);
        }
    }

    public function deleteProc()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'brandCode' => 'required',
            'corpCode' => 'required',
            'lvl' => 'required',
            'idx' => 'required',
        ];

        if ( $this->request->getMethod() == 'post' && $this->validate($rules) ) {
            $globalPriceService = GlobalPriceService::factory();

            $user = $this->userConfig;
            $brandCode = $this->request->getPostGet('brandCode');
            $corpCode = $this->request->getPostGet('corpCode');
            $selectCorp = $this->request->getPostGet('selectCorp');
            $lvl = $this->request->getPostGet('lvl');
            $idx = $this->request->getPostGet('idx');
            $pIdx = getValidValue($_POST, 'pIdx', 0);

            $param = [
                'brandCode' => $brandCode,
                'corpCode' => $corpCode,
                'selectCorp' => $selectCorp,
                'lvl' => $lvl,
                'idx' => $idx,
                'pIdx' => $pIdx,
                'userID' => $user['userID'],
            ];

            $info = [
                'brandCode' => $brandCode,
                'corpCode' => $corpCode,
                'lvl' => $lvl,
                'idx' => $idx,
            ];

            list($deleteData, $whereData) = $this->deleteData($param);

            $result = $globalPriceService->deleteProc($info, $deleteData, $whereData);

            return json_encode($result);
        } else {
            $errors = $validation->getErrors();
            $errorMsg = "";
            foreach ($errors as $field => $message) {
                $errorMsg .= "유효성 검사 실패 : ".$field."\n";
            }
            $response['msg'] = $errorMsg;

            return json_encode($response);
        }
    }

    public function categorySortProc()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'brandCode' => 'required',
            'corpCode' => 'required',
        ];

        if ( $this->request->getMethod() == 'post' && $this->validate($rules) ) {
            $globalPriceService = GlobalPriceService::factory();

            $user = $this->userConfig;
            $brandCode = $this->request->getPostGet('brandCode');
            $corpCode = $this->request->getPostGet('corpCode');
            $categoryLvl1 = $this->request->getPostGet('categoryLvl1');     // 1차 카테고리
            if ($categoryLvl1 == "") $categoryLvl1 = [];
            $categoryLvl2 = $this->request->getPostGet('categoryLvl2');     // 2차 카테고리
            if ($categoryLvl2 == "") $categoryLvl2 = [];
            $categoryLvl3 = $this->request->getPostGet('categoryLvl3');     // 3차 카테고리(시술 정보)
            if ($categoryLvl3 == "") $categoryLvl3 = [];

            $param = [
                'brandCode' => $brandCode,
                'corpCode' => $corpCode,
                'categoryLvl1' => $categoryLvl1,
                'categoryLvl2' => $categoryLvl2,
                'categoryLvl3' => $categoryLvl3,
                'userID' => $user['userID'],
            ];

            $result = $globalPriceService->categorySortProc($param);

            return json_encode($result);
        } else {
            $errors = $validation->getErrors();
            $errorMsg = "";
            foreach ($errors as $field => $message) {
                $errorMsg .= "유효성 검사 실패 : ".$field."\n";
            }
            $response['msg'] = $errorMsg;

            return json_encode($response);
        }
    }

    /*
     * 지점 변경
     */
    public function getBranch()
    {
        $corpService = CorpService::factory();

        $brandCode = allTags($this->request->getPostGet('brandCode'));
        $corpCode = allTags($this->request->getPostGet('corpCode'));

        // 지점 리스트
        $corpList = $corpService->getBrandCorpList($this->common, $brandCode);

        $data = [
            'corpCode' => $corpCode,
            'corpList' => $corpList,
        ];

        echo view('globalPriceMng/_getBranch', $data);
    }

    /*
     * 적용 지점 설정 페이지
     */
    public function branchProc()
    {
        $globalPriceService = GlobalPriceService::factory();
        $corpService = CorpService::factory();

        $brandCode = $this->request->getPostGet('brandCode');
        $corpCode = $this->request->getPostGet('corpCode');

        // 브랜드 리스트
        $brandList = $globalPriceService->getGlobalPriceBrandList();
        // 지점 리스트
        $corpList = $corpService->getBrandCorpList($this->common, $brandCode);
        // 적용 지점 리스트
        $applyCorpList = $globalPriceService->getGlobalPriceBranchList($brandCode, $corpCode);

        $data = [
            'brandCode' => $brandCode,
            'corpCode' => $corpCode,
            'brandList' => $brandList,
            'corpList' => $corpList,
            'applyCorpList' => $applyCorpList,
            'common' => $this->common,
            'userConfig'=> $this->userConfig
        ];

        echo view('globalPriceMng/branchProc', $data);
    }

    public function applyCorpProc()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'brandCode' => 'required',
            'corpCode' => 'required',
            'applyCorpPackage' => 'required',
        ];

        if ( $this->request->getMethod() == 'post' && $this->validate($rules) ) {
            $globalPriceService = GlobalPriceService::factory();

            $brandCode = $this->request->getPostGet('brandCode');
            $corpCode = $this->request->getPostGet('corpCode');
            $applyCorpPackage = $this->request->getPostGet('applyCorpPackage');
            if ($applyCorpPackage != "") $applyCorpPackage = explode(',', $applyCorpPackage);

            // 현재 적용 지점 리스트
            $applyCorpList = $globalPriceService->getApplyCorpList($brandCode, $corpCode);
            $isUseCorpList = array_filter($applyCorpList, function ($subArray) {
               if ($subArray['isUse'] == 'Y') return $subArray;
            });

            $applyCorpListKey = array_column($isUseCorpList, 'applyCorp');

            if ($applyCorpPackage == $applyCorpListKey) {
                $result['msg'] = '변경 사항이 없습니다.';
                return json_encode($result);
            }

            $param = [
                'brandCode' => $brandCode,
                'corpCode' => $corpCode,
                'applyCorpList' => $applyCorpList,
                'applyCorpPackage' => $applyCorpPackage,
            ];

            $sqlData = $this->applyCorpData($param);

            $result = $globalPriceService->branchSortProc($sqlData, $param);

            return json_encode($result);
        } else {
            $errors = $validation->getErrors();
            $errorMsg = "";
            foreach ($errors as $field => $message) {
                $errorMsg .= "유효성 검사 실패 : ".$field."\n";
            }
            $response['msg'] = $errorMsg;

            return json_encode($response);
        }
    }

    public function chgState()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'brandCode' => 'required',
            'corpCode' => 'required',
            'lvl' => 'required',
            'idx' => 'required',
            'isView' => 'required',
        ];

        if ($this->request->getMethod() == 'post' && $this->validate($rules)) {
            $globalPriceService = GlobalPriceService::factory();

            $user = $this->userConfig;
            $brandCode = $this->request->getPostGet('brandCode');
            $corpCode = $this->request->getPostGet('corpCode');
            $lvl = $this->request->getPostGet('lvl');
            $idx = $this->request->getPostGet('idx');
            $isView = $this->request->getPostGet('isView');

            $branchList = $globalPriceService->getGlobalPriceBranchList($brandCode, $corpCode);

            $modifyData = [
                'isView' => $isView,
                'modifyId' => $user['userID']
            ];

            $param = [
                'brandCode' => $brandCode,
                'corpCode' => $corpCode,
                'idx' => $idx,
            ];

            $result = $globalPriceService->chgState($lvl, $modifyData, $param);

            if ($result) {
                if ($lvl == '1' || $lvl == '2') {
                    $info = $globalPriceService->getParentCategoryInfo($idx);
                } else if ($lvl == '3') {
                    $info = $globalPriceService->getTreatmentInfo($idx);
                } else if ($lvl == '4') {
                    $info = $globalPriceService->getPriceInfo($idx);
                }

                $data = [
                    'brandCode' => $brandCode,
                    'corpCode' => $corpCode,
                    'branchList' => $branchList,
                    'lvl' => $lvl,
                    'resultView' => $isView,
                ];
                $data = array_merge($data, $info);

                $response['result'] = true;
                $response['msg'] = '노출여부가 수정되었습니다.';
                $response['view'] = view('globalPriceMng/_indexItem', $data);
            }

            return json_encode($response);

        } else {
            $errors = $validation->getErrors();
            $errorMsg = "";
            foreach ($errors as $field => $message) {
                $errorMsg .= "유효성 검사 실패 : ".$field."\n";
            }
            $response['msg'] = $errorMsg;

            return json_encode($response);
        }
    }

    private function insertData($data)
    {
        $globalPriceService = GlobalPriceService::factory();

        $insertData = [];
        $lvl = $data['lvl'];

        if ($lvl == '1' || $lvl == '2') {   // 1차,2차 카테고리 입력 데이터
            $sortCnt = $globalPriceService->getCategorySortCount($data['brandCode'], $data['corpCode'], $lvl, $data['pIdx']);

            $insertData = [
                'brandCode' => $data['brandCode'],
                'corpCode' => $data['corpCode'],
                'codeName' => $data['categoryName'],
                'pPubCode' => $data['pIdx'],
                'codeLevel' => $lvl,
                'sort' => $sortCnt['cnt'] + 1,
                'isView' => $data['isView'],
                'regId' => $data['userID'],
            ];
        } else if ($lvl == '3') {   // 3차 카테고리(시술) 입력 데이터
            $categoryInfo = $globalPriceService->getParentCategoryInfo($data['pIdx']);    // 1차 카테고리 idx 가져오기
            $sortCnt = $globalPriceService->getTreatmentSortCount($data['brandCode'], $data['corpCode'], $data['pIdx']);

            $insertData = [
                'brandCode' => $data['brandCode'],
                'applyCorp' => $data['corpCode'],
                'cate1' => $categoryInfo['pPubCode'],
                'cate2' => $data['pIdx'],
                'treatmentName' => $data['categoryName'],
                'treatmentMemo' => $data['categoryMemo'],
                'sort' => $sortCnt['cnt'] + 1,
                'isView' => $data['isView'],
                'regId' => $data['userID'],
            ];
        } else if ($lvl == '4') {   // 4차 카테고리(가격정보) 입력 데이터
            $insertData = [
                'applyCorp' => $data['selectCorp'],
                'treatmentIdx' => $data['pIdx'],
                'price' => str_replace(',', '', $data['treatmentPrice']),
                'memo' => $data['treatmentMemo'],
                'isView' => $data['isView'],
                'regId' => $data['userID'],
            ];
        }

        return $insertData;
    }

    private function modifyData($data)
    {
        $whereData = [];
        $modifyData = [];
        $lvl = $data['lvl'];

        if ($lvl == '1' || $lvl == '2') {   // 1차,2차 카테고리 수정 데이터
            $whereData = [
                'brandCode' => $data['brandCode'],
                'corpCode' => $data['corpCode'],
                'pubCode' => $data['idx']
            ];

            $modifyData = [
                'codeName' => $data['categoryName'],
                'isView' => $data['isView'],
                'modifyId' => $data['userID'],
            ];
        } else if ($lvl == '3') {   // 3차 카테고리(시술) 수정 데이터
            $whereData = [
                'brandCode' => $data['brandCode'],
                'applyCorp' => $data['corpCode'],
                'treatmentCode' => $data['idx']
            ];

            $modifyData = [
                'treatmentName' => $data['categoryName'],
                'treatmentMemo' => $data['categoryMemo'],
                'isView' => $data['isView'],
                'modifyId' => $data['userID'],
            ];
        } else if ($lvl == '4') {   // 4차 카테고리(가격정보) 수정 데이터
            $whereData = [
                'idx' => $data['idx']
            ];

            $modifyData = [
                'applyCorp' => $data['selectCorp'],
                'price' => str_replace(',', '', $data['treatmentPrice']),
                'memo' => $data['treatmentMemo'],
                'isView' => $data['isView'],
                'modifyId' => $data['userID'],
            ];
        }

        return [$modifyData, $whereData];
    }

    private function deleteData($data)
    {
        $deleteData = [
            'isDel' => 'Y',
            'delId' => $data['userID'],
            'delDate' => date('Y-m-d H:i:s'),
        ];

        $whereData = [];

        $whereData['1'] = [
            'brandCode' => $data['brandCode'],
            'corpCode' => $data['corpCode'],
        ];
        $whereData['2'] = [
            'brandCode' => $data['brandCode'],
            'corpCode' => $data['corpCode'],
        ];
        $whereData['3'] = [
            'brandCode' => $data['brandCode'],
            'applyCorp' => '',
        ];
        $whereData['4'] = [];

        return [ $deleteData, $whereData ];
    }

    private function applyCorpData($data)
    {
        $result = [];

        $result['whereData'] = [
            'brandCode' => $data['brandCode'],
            'corpCode' => $data['corpCode'],
            'applyCorp' => ''
        ];

        $result['insertData'] = [
            'brandCode' => $data['brandCode'],
            'corpCode' => $data['corpCode'],
            'applyCorp' => '',
            'sort' => '',
            'regDate' => date('Y-m-d H:i:s')
        ];

        $result['modifyData'] = [
            'isUse' => 'Y',
            'sort' => '',
        ];

        $result['deleteData'] = [
            'isUse' => 'N',
            'sort' => ''
        ];

        return $result;
    }

}
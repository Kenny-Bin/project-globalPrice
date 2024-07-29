<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\LoginModel;
use App\Models\LoginLogModel;

class Login extends BaseController
{
    public function __construct()
    {
        $this->LoginModel = new LoginModel();
        $this->LoginLogModel = new LoginLogModel();
        $this->UserModel = new UserModel();
    }

    /**
     * 관리자 로그인 화면
     */
    public function index()
    {

        $data = [
            'common' => $this->common,
        ];

        echo view('login', $data);
    }

    /**
     * 로그인 처리
     */
    public function loginProc()
    {
        $result = [
            'result' => 'FAIL',
            'msg' => '필수 데이터 누락',
        ];

        // 필수 데이터 체크
        if ($this->request->getPost() && $this->validate([
                'loginID' => 'required',
                'loginPWD' => 'required',
            ])) {

            $loginID = $this->request->getPost('loginID');
            $loginPWD = $this->request->getPost('loginPWD');

            $isBlock = 'N';     // 제한 조치 여부
            $pwErrorCnt = 0;    // 비밀번호 오류 횟수 default
            $date = date('Y-md-d');

            $userIDInfo = $this->UserModel->loginUserChk($loginID);  // 아이디 조회

            // 아이디 오류
            if (!$userIDInfo) {
                $result['result'] = 'IDERROR';
                $result['msg'] = '존재하지 않는 계정입니다. \n 입력하신 정보를 다시 확인해 주세요.';

                return json_encode($result);
            }

            // 비밀번호 오류
            $userPWDInfo = $this->UserModel->loginUserChk($loginID, $loginPWD);  // 아이디 & 비밀번호 조회
            $userLoginInfo = $this->LoginModel->getUserLoginInfo($loginID); // 로그인 정보 조회
            if ($userLoginInfo) $pwErrorCnt = $userLoginInfo['pw_error_count'];     // 기존 로그인 이력에 비밀번호 오류 횟수

            if (!$userPWDInfo) {
                if ($pwErrorCnt < MAX_PASSWORD_LIMIT) $pwErrorCnt++;    // 패스워드 에러 카운트 증가

                if ($pwErrorCnt == MAX_PASSWORD_LIMIT) {    // 패스워드 오류 5회 로그인 제한
                    $isBlock = 'Y';     // 로그인 제한으로 상태값 변경

                    $result['result'] = 'PWRESTRICT';
                    $result['msg'] = '비밀번호가 5회 잘못입력되었습니다. \n 관리자에게 문의해 주세요.';

                    $loginLogMsg = "비밀번호 오류[" . $pwErrorCnt . "/" . MAX_PASSWORD_LIMIT . "]";
                    $this->setLoginLog($userIDInfo, $loginLogMsg, 'PWERROR');

                    $loginLogMsg = "로그인 차단 (일시 : " . $date . ")";
                    $this->setLoginLog($userIDInfo, $loginLogMsg, 'PWRESTRICT');

                } else {    // 패스워드 오류 리턴
                    $result['result'] = 'PWERROR';
                    $result['msg'] = '비밀번호가 잘못입력되었습니다. \n 입력하신 정보를 다시 확인해 주세요. \n ( ' . $pwErrorCnt . ' / ' . MAX_PASSWORD_LIMIT . ' )';

                    $loginLogMsg = "비밀번호 오류[" . $pwErrorCnt . "/" . MAX_PASSWORD_LIMIT . "]";
                    $this->setLoginLog($userIDInfo, $loginLogMsg, 'PWERROR');
                }

                $this->setLoginInfo($userIDInfo, $pwErrorCnt, $isBlock, 'PASSWORD');

                return json_encode($result);
            }

            // 비활성화 계정
            if ($userIDInfo['IS_DEL'] == 'Y') {
                $result['result'] = 'DISABLED';
                $result['msg'] = '비활성화된 계정입니다. \n 관리자에게 문의해 주세요.';

                return json_encode($result);
            }

            // 로그인 제한조치 여부 확인
            $userLoginInfo = $this->LoginModel->getUserLoginInfo($loginID); // 로그인 정보 조회
            if ($userLoginInfo) {
                $isBlock = $userLoginInfo['IS_LOGIN_BLOCK'];

                if ($pwErrorCnt == MAX_PASSWORD_LIMIT && $isBlock == 'Y') {
                    $result['result'] = 'PWRESTRICT';
                    $result['msg'] = '비밀번호가 5회 잘못입력되었습니다. \n 관리자에게 문의해 주세요.';
                    return json_encode($result);
                } else if ($pwErrorCnt != MAX_PASSWORD_LIMIT && $isBlock == 'Y') {
                    $result['result'] = 'RESTRICT';
                    $result['msg'] = '로그인 제한 조치된 계정입니다 \n 관리자에게 문의해 주세요.';
                    return json_encode($result);
                }
            }

            $loginLogMsg = '로그인 성공';
            $this->setLoginLog($userIDInfo, $loginLogMsg, 'SUCCESS');

            $pwErrorCnt = 0;    // 유효성 체크 완료. 비밀번호 틀린 횟수 초기화
            $this->setLoginInfo($userIDInfo, $pwErrorCnt, $isBlock, 'PASSWORD');

            return redirect()->to('./');
        }

        return json_encode($result);
    }

    /*
     * 로그인 이력 저장
     */
    private function setLoginLog($user, $msg, $status)
    {
        $insertData = [
            'user_idx' => $user['IDX'],
            'user_id' => $user['USER_ID'],
            'detail' => $msg,
            'is_success' => 'N',
            'log_login_block' => 'N',
            'login_attempt_dt' => date('Y-m-d H:i:s'),
            'login_attempt_ip' => getRealClientIp(),
        ];

        if ($status == 'PWRESTRICT' || $status == 'RESTRICT') {
            $insertData['log_login_block'] = 'Y';
        } else if ($status == 'SUCCESS') {
            $insertData['is_success'] = 'Y';
        }

        $this->LoginLogModel->setLoginLog($insertData);
    }

    /*
     * 로그인 정보 저장
     */
    private function setLoginInfo($user, $cnt, $state, $category)
    {
        $insertData = [
            'user_id' => $user['user_id'],
            'user_idx' => $user['idx'],
            'is_login_block' => $state,
            'last_login_dt' => date('Y-m-d H:i:s'),
            'last_login_ip' => getRealClientIp(),
        ];

        if ($category == 'PASSWORD') {
            $insertData['pw_error_count'] = $cnt;
        } else if ($category == 'CERTNO') {
            $insertData['cert_error_count'] = $cnt;
        }

        if ($state == 'Y') {
            $insertData['block_dt'] = date('Y-m-d H:i:s');
        }

        $this->LoginModel->setLoginInfo($insertData);
    }

    /**
     * 로그아웃
     */
    public function logout()
    {
        // 세션 삭제
        session()->destroy();

        return redirect()->to('/');
    }
}
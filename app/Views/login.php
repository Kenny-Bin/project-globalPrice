<body>
<div class="login-wrap">
    <div>
        <!-- login form -->
        <form method="post" id="frmInput" name="frmInput" style="margin-top:0;margin-bottom:0">
            <input type="hidden" id="blank"			name="blank"		value="">
            <figure class="logo">
                <img src="/media/img/logo.png" alt="" height="100" />
            </figure>

            <div class="login-input-box">
                <div>
                    <h1>환영합니다! 계정에 로그인 해주세요.</h1>
                    <div class="invalid_wrap">
                        <label for="loginID" class="sr-only">아이디</label>
                        <div class="input-icon">
                            <img src="/media/img/icon/id.png" alt="">
                            <input type="text" id="loginID" name="loginID" value="" class="form-control" placeholder="ID" tabindex="1" required autofocus />
                        </div>
                    </div>
                    <div class="invalid_wrap">
                        <label for="loginPWD" class="sr-only">패스워드</label>
                        <div class="input-icon">
                            <img src="/media/img/icon/psw.png" alt="">
                            <input type="password" id="loginPWD" name="loginPWD" value="" class="form-control" placeholder="PASSWORD" tabindex="2" required />
                        </div>
                    </div>
                    <button class="btn btn-bbg" type="button" tabindex="3" onClick="loginChk();">로그인</button>

                    <p class="copyright">&copy; 2022 BBG Network</p>
                </div>
            </div>
        </form>
    </div>
    <figure class="our-brand">
        <img src="/media/img/our-brand.png" alt=""/>
    </figure>
</div>

<script language="javascript">

    window.onbeforeunload = function () {
        $(".loading-page").show();
    }

    function loginChk()
    {
        var frm						=	document.frmInput;

        if ( frm.loginID.value == "" ) {
            alert("아이디를 입력해 주세요.");
            frm.loginID.focus();
            return false;
        }

        if ( frm.loginPW.value == "" ) {
            alert("비밀번호를 입력해 주세요.");
            frm.loginPWD.focus();
            return false;
        }

        frm.action					=	"./loginProc";
        frm.target					=	"procFrame";
        frm.submit();
    }
</script>

</body>
</html>
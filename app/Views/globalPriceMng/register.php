<?php include APPPATH.'Views/inc/top.php'; ?>
<script language="javascript">
    function getCategoryCodeList(divID, pIdx, lvl, isSel, isSearch, schCategory = "", schWord = "", schBranch = "")
    {
        $.ajax({
            url						:	"./_register",
            type					:	"POST",
            data                    :   {
                'brandCode'   : '<?= $brandCode ?>',
                'corpCode'   : '<?= $corpCode ?>',
                'schBranch'   : schBranch,
                'pIdx'      : pIdx,
                'lvl'       : lvl,
                'isSel'      : isSel,
                'isSearch'  : isSearch,
                'schCategory'  : schCategory,
                'schWord'  : schWord,
            },
            dataType				:	"html",
            contentType				:	"application/x-www-form-urlencoded; charset=UTF-8",
            async					:	false,
            success					:	function (data)
            {
                $('#' + divID).html(data);
            }
        });
    }
</script>

<!-- 홈페이지 가격표에서 사용하는 css -->
<link href="/css/global_price.css?v=2406041420" rel="stylesheet">
</head>
<body>

<input type="hidden" id="indexGubun" name="indexGubun" value="1">

<div class="globalPrice-wrap">
    <div class="as-head">
        <a href="/">
            <img src=/media/img/icon/w_home.svg alt=""/>
        </a>
        <h1>글로벌 브랜드 홈페이지 가격표</h1>
    </div>
    <div class="am-head">
        <a href="/brandRegularPriceMng?brandCode=<?= $brandCode ?>&corpCode=<?= $corpCode ?>" class="btn">목록</a>
        <a onclick="location.reload();" class="btn active">카테고리/가격/메모 편집</a>
    </div>
    <div class="globalPrice-content reg-content">
        <table id="globalPriceDraglayout" class="table">
            <colgroup>
                <col width="25%">
                <col width="25%">
                <col width="25%">
                <col width="25%">
            </colgroup>
            <tbody>
            <tr>
                <td>
                    <div class="head-text-box">
                        <h3>1차 카테고리</h3>
                    </div>
                    <div class="scroll-box">
                        <div class="form-box" id="categoryCodeDiv1"></div><!-- getCounselCodeDiv1 -->
                        <script Language="javaScript">getCategoryCodeList('categoryCodeDiv1', '', '1', 'Y', '');</script>
                    </div>
                </td>
                <td>
                    <div class="head-text-box">
                        <h3>2차 카테고리</h3>
                    </div>
                    <div class="scroll-box">
                        <div class="form-box" id="categoryCodeDiv2"></div>
                    </div>
                </td>
                <td>
                    <div class="head-text-box">
                        <h3>3차 카테고리 (시술명)</h3>
                    </div>
                    <div class="scroll-box">
                        <div class="form-box" id="categoryCodeDiv3"></div>
                    </div>
                </td>
                <td>
                    <div class="head-text-box">
                        <h3>가격 정보</h3>
                    </div>
                    <div class="scroll-box">
                        <div class="form-box" id="categoryCodeDiv4"></div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="delPopup" class="popup">
    <form id="delForm" name="delForm" method="post" class="" onsubmit="return false;">
        <input type="hidden" id="brandCode" name="brandCode" value="<?= $brandCode ?>">
        <input type="hidden" id="corpCode" name="corpCode" value="<?= $corpCode ?>">
        <input type="hidden" id="selectCorp" name="selectCorp" value="">
        <input type="hidden" id="lvl" name="lvl" value="">
        <input type="hidden" id="idx" name="idx" value="">
        <input type="hidden" id="pIdx" name="pIdx" value="">
    </form>
    <div class="text-box text-center">
        <p class="del-txt">
            해당 분류를 삭제하시면 하위 분류 및 메모 내용이 모두 삭제됩니다.<br />
            그래도 삭제하시겠습니까?
        </p>

        <p class="price-del-txt">
            삭제 하시면 등록된 정보 및 홈페이지에서 삭제 처리됩니다.<br />
            그래도 삭제하시겠습니까?
        </p>
    </div>
    <div class="edit-btn-box d-flex justify-content-end">
        <button type="button" class="btn btn-secondary" onclick="deleteProc()">확인</button>
        <button type="button" class="btn btn-basic">취소</button>
    </div>
</div>


<div id="exposurePopup" class="popup">
    <div class="text-box text-center">
        <p class="exposure-txt">
            노출 해체하시겠습니까?<br />
            해제하시면 홈페이지에 미노출 됩니다.
        </p>
    </div>
    <div class="edit-btn-box d-flex justify-content-end">
        <button type="button" class="btn btn-secondary">확인</button>
        <button type="button" class="btn btn-basic">취소</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    function formWrite(frm, gubun) {
        if (gubun == '1') {
            var form = 'catForm1';
            if (frm.categoryName.value == "") {
                alert("카테고리명을 입력해 주세요.");
                frm.categoryName.focus();
                return false;
            }
        } else if (gubun == '2') {
            var form = 'catForm2';
            if (frm.categoryName.value == "") {
                alert("카테고리명을 입력해 주세요.");
                frm.categoryName.focus();
                return false;
            }
        } else if (gubun == '3') {
            var form = 'catForm3';
            if (frm.categoryName.value == "") {
                alert("시술명을 입력해 주세요.");
                frm.categoryName.focus();
                return false;
            }
        } else if (gubun == '4') {
            var form = 'catForm4';
            if (frm.selectCorp.value == "") {
                alert("지점을 선택해 주세요.");
                return false;
            }

            if (frm.treatmentPrice.value == "") {
                alert("가격을 입력해 주세요.");
                frm.str_price.focus();
                return false;
            }
        }

        var formData					=	document.querySelector('#' + form);
        var postDate				=	new FormData(formData);

        $.ajax({
            url				:	"./registerProc",
            type			:	"POST",
            data            :   postDate,
            dataType		:	"json",
            async			:	true,
            cache			:	false,
            contentType		:	false,
            processData		:	false,
            success					:	function (data)
            {
                if (data.result) {
                    const lvl = frm.lvl.value;
                    const pIdx = frm.pIdx.value;

                    alert(data.msg);

                    getCategoryCodeList('categoryCodeDiv' + lvl, pIdx, lvl, 'Y', '');
                } else {
                    alert(data.msg);
                }
            }
        });
    }
    // 저장 버튼
    function saveBtn(event, gubun, idx) {
        event.stopPropagation();

        // 공통항목 폼
        let form = 'catForm' + gubun;
        let listForm = form + '_' + idx;

        // 공통항목
        let brandCode = $('#' + form + ' #brandCode').val();
        let corpCode = $('#' + form + ' #corpCode').val();
        let lvl = $('#' + form + ' #lvl').val();
        let pIdx = $('#' + form + ' #pIdx').val();

        var formData = document.querySelector('#' + listForm);
        var postDate = new FormData(formData);

        // 공통항목 추가
        postDate.append('brandCode', brandCode);
        postDate.append('corpCode', corpCode);
        postDate.append('lvl', lvl);
        postDate.append('pIdx', pIdx);
        postDate.append('idx', idx);

        $.ajax({
            url				:	"./modifyProc",
            type			:	"POST",
            data            :   postDate,
            dataType		:	"json",
            async			:	true,
            cache			:	false,
            contentType		:	false,
            processData		:	false,
            success					:	function (data)
            {
                if (data.result) {
                    alert(data.msg);
                    getCategoryCodeList('categoryCodeDiv' + lvl, pIdx, lvl, 'Y', '');
                } else {
                    alert(data.msg);
                }
            }
        });

    }

    function deleteProc()
    {
        var frm = document.delForm;
        var formData = document.querySelector('#delForm');
        var postDate = new FormData(formData);

        $.ajax({
            url				:	"./deleteProc",
            type			:	"POST",
            data            :   postDate,
            dataType		:	"json",
            async			:	true,
            cache			:	false,
            contentType		:	false,
            processData		:	false,
            success					:	function (data)
            {
                const lvl = frm.lvl.value;
                const pIdx = frm.pIdx.value;

                if (data.result) {
                    alert(data.msg);

                    $( "#deletePopup" ).dialog('close');
                    location.reload();
                } else {
                    alert(data.msg);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function chgState(lvl, idx, isView)
    {
        $.ajax({
            url				:	"./chgState",
            type			:	"POST",
            data            : {
                brandCode : '<?= $brandCode ?>',
                corpCode : '<?= $corpCode ?>',
                lvl : lvl,
                idx : idx,
                isView : isView,
            },
            dataType				:	"json",
            contentType				:	"application/x-www-form-urlencoded; charset=UTF-8",
            async					:	false,
            success					:	function (data)
            {
                alert(data.msg);
                if (data.result) {
                    $('#category_' + lvl + '_' + idx).html('');
                    $('#category_' + lvl + '_' + idx).html(data.view);
                    // 스크립트 재실행
                    let listDiv = $('#categoryCodeDiv' + lvl).find('script').html();
                    $.globalEval(listDiv);
                }

            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    // 콤마
    function addCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    $(function(){
    });
</script>

</body>
</html>

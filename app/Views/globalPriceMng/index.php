<?php include APPPATH.'Views/inc/top.php'; ?>
<script language="javascript">
    function getCategoryCodeList(divID, pIdx, lvl, isSel, isSearch, schCategory = "", schWord = "", schBranch = "")
    {
        $.ajax({
            url						:	"./brandRegularPriceMng/_index",
            type					:	"POST",
            data                    :   {
                'brandCode'   : '<?= $brandCode?>',
                'corpCode'   : '<?= $corpCode?>',
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
                if($('#indexGubun').val() == '1') {
                    chgIndex(1);
                } else {
                    chgIndex(2);
                }
            }
        });
    }

    function chgBrand(brandCode, corpCode)
    {
        $.ajax({
            url						:	"./brandRegularPriceMng/_getBranch?brandCode=" + brandCode + "&corpCode=" + corpCode,
            type					:	"GET",
            dataType				:	"html",
            contentType				:	"application/x-www-form-urlencoded; charset=UTF-8",
            async					:	false,
            success					:	function (data)
            {
                $('#corpCode').html(data);
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
        <form id="schForm" name="schForm" method="post">
            <a href="/">
                <img src=/media/img/icon/w_home.svg alt=""/>
            </a>
            <h1>글로벌 브랜드 홈페이지 가격표</h1>
            <div class="right d-flex align-items-center">
                <div class="form-group mr-3">
                    <div class="input-group d-flex align-items-center">
                        <p class="mr-2">지점 홈페이지</p>
                        <select name="brandCode" id="brandCode" class="form-control" onchange="chgBrand(this.value, '<?= $corpCode ?>');">
                            <option value="">브랜드를 선택하세요.</option>
                            <?php foreach ($brandList as $row) { ?>
                                <option value="<?= $row['brandCode'] ?>" <?php if ($brandCode == $row['brandCode'] ) echo "selected" ?>><?= $row['brandName'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group d-flex align-items-center">
<!--                        <p class="mr-2">지점명</p>-->
                        <select id="corpCode" name="corpCode" class="form-control" onchange="goSearch()">
                            <option value="">지점을 선택하세요.</option>
                        </select>
                        <script Language="javaScript">chgBrand('<?=$brandCode?>', '<?= $corpCode ?>');</script>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="am-head">
        <form id="schForm1" name="schForm1" method="post" onsubmit="goSearch1(); return false;">
            <input type="hidden" id="isSearch" name="isSearch" value="Y" >
            <input type="hidden" id="lvl" name="lvl" value="3" >
            <a href="/brandRegularPriceMng?brandCode=<?= $brandCode ?>&corpCode=<?= $corpCode ?>" class="btn active">목록</a>
            <a href="/brandRegularPriceMng/register?brandCode=<?= $brandCode ?>&corpCode=<?= $corpCode ?>" class="btn">카테고리/가격/메모 편집</a>
            <button type="button" class="btn active" id="chgBtn1" onClick="chgIndex('1'); sortProc();" style="display:none;">순서저장</button>
            <button type="button" class="btn" id="chgBtn2" onClick="chgIndex('2');">순서편집</button>
            <a href="/brandRegularPriceMng/branchProc?brandCode=<?= $brandCode ?>&corpCode=<?= $corpCode ?>" class="btn">노출 지점 관리</a>
            <a onclick="location.reload();" type="button" class="btn btn-reset">
                <img src="/media/img/icon/reset_icon.svg" alt="">
            </a>

            <div class="form-row right-block">

                <!-- 240607 cdb -->
                <div class="form-group mr-0">
                    <div class="input-group d-flex align-items-center">
                        <p class="mr-2">지점명</p>
                        <select id="schBranch" name="schBranch" class="form-control">
                            <option value="">지점을 선택하세요.</option>
                            <?php foreach ($branchList as $row) { ?>
                                <option value="<?= $row['applyCorp'] ?>" <?php if ($schBranch == $row['applyCorp'] ) echo "selected" ?>><?= $row['corpName'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- // 240607 cdb -->
                <span class="verticalBar"></span>
                <div class="form-group mr-0">
                    <div class="input-group d-flex align-items-center">
                        <select id="schCategory" name="schCategory" class="form-control">
                            <option value="category">카테고리명</option>
                            <option value="memo">메모</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" id="schWord" name="schWord" value="" placeholder="검색어를 입력해 주세요"">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" onclick="goSearch1()">검색</button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-excel" title="엑셀다운">
                        <img src="/media/img/icon/download_icon.svg" alt="">
                        excel
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="globalPrice-content">

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
                            <form id="catForm1" name="catForm1" method="post" class="" onsubmit="return false;">
                                <div class="" id="categoryCodeDiv1">
                                    <script Language="javaScript">getCategoryCodeList('categoryCodeDiv1', '', '1', 'Y', '');</script>
                                </div>
                            </form>
                        </div>
                    </td>
                    <td>
                        <div class="head-text-box">
                            <h3>2차 카테고리</h3>
                        </div>
                        <div class="scroll-box">
                            <form id="catForm2" name="catForm2" method="post" class="">
                                <div class="" id="categoryCodeDiv2"></div>
                            </form>
                        </div>
                    </td>
                    <td>
                        <div class="head-text-box">
                            <h3>3차 카테고리 (시술명)</h3>
                        </div>
                        <div class="scroll-box">
                            <form id="catForm3" name="catForm3" method="post" class="">
                                <div class="" id="categoryCodeDiv3"></div>
                            </form>
                        </div>
                    </td>
                    <td>
                        <div class="head-text-box">
                            <h3>가격 정보</h3>
                        </div>
                        <div class="scroll-box">
                            <form id="catForm4" name="catForm4" method="post" class="">
                                <div class="" id="categoryCodeDiv4"></div>
                            </form>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="deletePopup" class="popup">
    <form id="delForm" name="delForm" method="post" class="" onsubmit="return false;">
        <input type="hidden" id="brandCode" name="brandCode" value="<?= $brandCode ?>">
        <input type="hidden" id="corpCode" name="corpCode" value="<?= $corpCode ?>">
        <input type="hidden" id="selectCorp" name="selectCorp" value="">
        <input type="hidden" id="lvl" name="lvl" value="">
        <input type="hidden" id="idx" name="idx" value="">
        <input type="hidden" id="pIdx" name="pIdx" value="">
    </form>
    <div class="text-box text-center">
        <p>
            삭제하시면 등록된 정보 및 홈페이지에서 삭제 처리됩니다. <br />
            그래도 삭제하시겠습니까?
        </p>
    </div>
    <div class="edit-btn-box d-flex justify-content-end">
        <button type="button" class="btn btn-secondary" onclick="deleteProc();">확인</button>
        <button type="button" class="btn btn-basic">취소</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    function goSearch()
    {
        var frm =	document.schForm;
        frm.target =	"_self";
        frm.action =	"<?=$common['selfPage']?>";
        frm.submit();
    }

    function goSearch1()
    {
        var frm	=	document.schForm1;

        if (frm.schBranch.value == "") {
            alert("지점을 선택해 주세요.");
            return false;
        } else {
            const schCategory = $('#schCategory').val();
            const schBranch = $('#schBranch').val();
            const schWord = $('#schWord').val();

            if (frm.schWord.value == "") {
                getCategoryCodeList('categoryCodeDiv2', '', '2', 'N', '');
                getCategoryCodeList('categoryCodeDiv3', '', '3', 'N', '');
                getCategoryCodeList('categoryCodeDiv4', '', '4', 'Y', 'Y', '', '', schBranch);
            } else {
                getCategoryCodeList('categoryCodeDiv2', '', '2', 'N', '');
                getCategoryCodeList('categoryCodeDiv3', '', '3', 'Y', 'Y',schCategory, schWord, schBranch);
                getCategoryCodeList('categoryCodeDiv4', '', '4', 'N', '');
            }
        }
    }

    function modifyProc(event, gubun, idx)
    {
        event.stopPropagation();

        // 공통항목 폼
        let form = 'cat-list-' + gubun;
        let listForm = 'catForm' + gubun + '_' + idx;

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
        postDate.append('isView', 'Y');

        $.ajax({
            url				:	"./brandRegularPriceMng/modifyProc",
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
            url				:	"./brandRegularPriceMng/deleteProc",
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
                    getCategoryCodeList('categoryCodeDiv' + lvl, pIdx, lvl, 'Y', '');

                    $( "#deletePopup" ).dialog('close');
                } else {
                    alert(data.msg);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function sortProc()
    {
        let categorylvl1 = new Array();
        let categorylvl2 = new Array();
        let categorylvl3 = new Array();

        $('.categoryLvl1').each(function (index, item) {
            categorylvl1.push(item.value);
        });
        $('.categoryLvl2').each(function (index, item) {
            categorylvl2.push(item.value);
        });
        $('.categoryLvl3').each(function (index, item) {
            categorylvl3.push(item.value);
        });

        $.ajax({
            url				:	"./brandRegularPriceMng/categorySortProc",
            type			:	"POST",
            data            : {
                brandCode : '<?= $brandCode ?>',
                corpCode : '<?= $corpCode ?>',
                categoryLvl1: categorylvl1,
                categoryLvl2: categorylvl2,
                categoryLvl3: categorylvl3,
            },
            dataType				:	"json",
            contentType				:	"application/x-www-form-urlencoded; charset=UTF-8",
            async					:	false,
            success					:	function (data)
            {
                alert(data.msg);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

</script>

</body>
</html>

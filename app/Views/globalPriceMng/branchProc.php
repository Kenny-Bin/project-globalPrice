<?php include APPPATH.'Views/inc/top.php'; ?>
<script>
    function chgBrand(brandCode, corpCode)
    {
        $.ajax({
            url						:	"./_getBranch?brandCode=" + brandCode + "&corpCode=" + corpCode,
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
<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
</head>

<body>
<div class="globalPrice-wrap">
    <div class="as-head">
        <a href="/">
            <img src=/media/img/icon/w_home.svg alt=""/>
        </a>
        <h1>글로벌 브랜드 홈페이지 가격표</h1>
    </div>
    <form id="schForm" name="schForm" method="post">
        <div class="am-head d-flex justify-content-between">
            <div class="">
                <a href="/brandRegularPriceMng?brandCode=<?= $brandCode ?>&corpCode=<?= $corpCode ?>" class="btn">목록</a>
                <a href="#" class="btn active" onclick="saveBtn()">저장</a>
            </div>
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
                        <select name="corpCode" id="corpCode" class="form-control" onchange="goSearch()">
                            <option>지점을 선택하세요.</option>
                        </select>
                        <script Language="javaScript">chgBrand('<?=$brandCode?>', '<?= $corpCode ?>');</script>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form id="schInput" name="schInput" method="post">
        <input type="hidden" id="brandCode" name="brandCode" value="<?= $brandCode ?>">
        <input type="hidden" id="corpCode" name="corpCode" value="<?= $corpCode ?>">
        <input type="hidden" id="applyCorpPackage" name="applyCorpPackage" value="">
        <div class="globalPrice-content branch-mgmt">
            <div class="row justify-content-center mt-5">
                <div class="col-4 ">
                    <p class="title14">전체 지점</p>
                    <div class=" position-relative mt-3">
                        <select name="selectPackage" id="multiselect" class="form-control w-85 custom-select h-26" multiple="multiple">
                            <?php
                            if (count($corpList) > 0) {
                                foreach ($corpList as $row) {
                            ?>
                                    <option value="<?= $row['corpCode'] ?>"><?= $row['corpName']?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="position-absolute" style="right:0; top:50%; transform: translateY(-50%);">
                            <button type="button" id="multiselect_rightSelected" class="btn btn-block">＞</button>
                            <button type="button" id="multiselect_leftSelected" class="btn btn-block">＜</button>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <p class="title14">적용할 지점 / 순서</p>

                    <div class=" position-relative mt-3">
                        <select name="targetPackage" id="multiselect_to" class="form-control w-85 custom-select h-26" multiple="multiple">
                            <?php
                            if (count($applyCorpList) > 0) {
                                foreach ($applyCorpList as $row) {
                            ?>
                                    <option value="<?= $row['applyCorp'] ?>"><?= $row['corpName']?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="position-absolute" style="right:0; top:50%; transform: translateY(-50%);">
                            <button type="button" id="up" class="btn btn-block">∧</button>
                            <button type="button" id="down" class="btn btn-block">∨</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!--팝업 임시 주석 24-06-19 KDB-->
<!--<div id="closePopup" class="popup">-->
<!--    <input type="hidden" id="lvl" name="lvl" value="">-->
<!--    <input type="hidden" id="idx" name="idx" value="">-->
<!--    <input type="hidden" id="pIdx" name="pIdx" value="">-->
<!--    <div class="text-box text-center">-->
<!--        <br>-->
<!--            작성중인 내용이 있을시 저장하지 않은 정보는 잃게 됩니다.<br />-->
<!--            나가시겠습니까 ?-->
<!--        </p>-->
<!--    </div>-->
<!--    <div class="edit-btn-box d-flex justify-content-end">-->
<!--        <a href="/brandRegularPriceMng" class="btn btn-secondary">나가기</a>-->
<!--        <button type="button" class="btn btn-basic">취소</button>-->
<!--    </div>-->
<!--</div>-->


<script type="text/javascript" src="/js/multiselect-master/dist/js/multiselect.js"></script>
<script type="text/javascript" src="/vendor/jquery.moveSelected.js"></script>
<script>
    function goSearch()
    {
        var frm =	document.schForm;
        frm.target =	"_self";
        frm.action =	"<?=$common['selfPage']?>";
        frm.submit();
    }

    function saveBtn() {

        var frm = document.schInput;

        var applyCorpPackage = new Array();
        Array.from(frm.targetPackage.options).forEach(function (item) {
            applyCorpPackage.push(item.value);
        });
        frm.applyCorpPackage.value = applyCorpPackage;

        var formData = document.querySelector('#schInput');
        var postDate = new FormData(formData);

        $.ajax({
            url				:	"./applyCorpProc",
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

    function chkDeletePin() {
        // 모달창 오픈
        $('#closePopup').dialog({
            autoOpen: true,
            show: { effect: 'fade', speed: 200 },
            hide: { effect: 'fade', speed: 200 },
            modal: true,
            resizable: false,
            width: "450",
            height: "260",
            autoResize: true,
            open: function(event, ui) {
                $(".ui-dialog").css("z-index", 10000);
                $('#closePopup .btn-basic').on("click", function() {
                    $('#closePopup').dialog('close');
                });
            },
            close: function(event, ui) {
                /*삭제 스트립트*/
            }
        });
        $('.ui-widget-header').remove();
    }
    function deletePriceProc()
    {
        let lvl = $('#deletePopup #lvl').val();
        let idx = $('#deletePopup #idx').val();
        let pIdx = $('#deletePopup #pIdx').val();

        $.ajax({
            url						:	"./brandRegularPriceMng/deleteProc",
            type					:	"POST",
            data                    : {
                lvl : lvl,
                idx : idx,
            },
            dataType				:	"json",
            contentType				:	"application/x-www-form-urlencoded; charset=UTF-8",
            async					:	false,
            success					:	function (data)
            {
                if (data.result) {
                    alert(data.msg);
                    getCategoryCodeList('categoryCodeDiv4', pIdx, '4', 'Y', '');

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
    $(function(){
        $('#multiselect').multiselect();

        // 더블클릭 이벤트
        $('#multiselect').on('dblclick', 'option', function() {
            $(this).remove();
            let branchOpi = $(this).clone();
            $('#multiselect_to').append(branchOpi);
        });

        $('#multiselect_to').on('dblclick', 'option', function() {
            $(this).remove();
            let applyOpi = $(this).clone();
            $('#multiselect option').each(function() {
                if ($(this).text() > applyOpi.text()) {
                    applyOpi.insertBefore($(this));
                    return false;
                } else {
                    $('#multiselect').append(applyOpi);
                }
            });
        });

        // 위아래 이동
        $( "#up" ).click(function() {
            $( "#multiselect_to" ).moveSelectedUp();
        });
        $( "#down" ).click(function() {
            $( "#multiselect_to" ).moveSelectedDown();
        });

    });
</script>
</body>
</html>

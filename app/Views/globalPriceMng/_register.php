<?php if ($lvl == '1' && $isSel == 'Y') { ?>
<form id="catForm1" name="catForm1" method="post" class="" onsubmit="return false;">
    <input type="hidden" id="lvl" name="lvl" value="1">
    <input type="hidden" id="pIdx" name="pIdx" value="<?= $pIdx ?>">
    <input type="hidden" id="brandCode" name="brandCode" value="<?=$brandCode?>">
    <input type="hidden" id="corpCode" name="corpCode" value="<?=$corpCode?>">
    <div class="reg-form">
        <div class="input-group justify-content-end">
            <input type="text" id="categoryName" name="categoryName" value="" class="form-control w-100" maxlength="150" placeholder="카테고리명 입력">
            <div class="btn-wrap d-flex align-items-center mt-2">
                <div class="switch-toggle-box d-flex align-center">
                    <p class="mr-2 text-small">노출여부</p>
                    <label class="switch-toggle mr-2">
                        <input type="checkbox" id="isView" name="isView" value="Y" checked>
                        <span class="slider""></span>
                    </label>
                </div>
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary" onclick="formWrite(this.form, 1)">등록</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php } else if ( $lvl == '2' && $isSel == 'Y') { ?>
<form id="catForm2" name="catForm2" method="post" class="" onsubmit="return false;">
    <input type="hidden" id="lvl" name="lvl" value="2">
    <input type="hidden" id="pIdx" name="pIdx" value="<?= $pIdx ?>">
    <input type="hidden" id="brandCode" name="brandCode" value="<?=$brandCode?>">
    <input type="hidden" id="corpCode" name="corpCode" value="<?=$corpCode?>">
    <div class="reg-form">
        <div class="input-group justify-content-end">
            <input type="text" id="categoryName" name="categoryName" value="" class="form-control w-100" maxlength="150" placeholder="카테고리명 입력">
            <div class="btn-wrap d-flex align-items-center mt-2">
                <div class="switch-toggle-box d-flex align-center">
                    <p class="mr-2 text-small">노출여부</p>
                    <label class="switch-toggle mr-2">
                        <input type="checkbox" id="isView" name="isView" value="Y" checked>
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary" onclick="formWrite(this.form, 2)">등록</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php } else if ( $lvl == '3' && $isSel == 'Y') { ?>
<form id="catForm3" name="catForm3" method="post" class="" onsubmit="return false;">
    <input type="hidden" id="lvl" name="lvl" value="3">
    <input type="hidden" id="pIdx" name="pIdx" value="<?= $pIdx ?>">
    <input type="hidden" id="brandCode" name="brandCode" value="<?=$brandCode?>">
    <input type="hidden" id="corpCode" name="corpCode" value="<?=$corpCode?>">
    <div class="reg-form">
        <div class="input-group justify-content-end">
            <label class="w-100">▶ 시술명</label>
            <input type="text" id="categoryName" name="categoryName" value="" class="form-control w-100" maxlength="150" placeholder="시술명 입력">
            <label class="w-100 mt-3">▶ 시술 메모</label>
            <textarea type="text" id="categoryMemo" name="categoryMemo" value="" class="form-control w-100" maxlength="2000" placeholder="시술메모를 입력해 주세요."></textarea>
            <div class="btn-wrap d-flex align-items-center mt-2">
                <div class="switch-toggle-box d-flex align-center">
                    <p class="mr-2 text-small">노출여부</p>
                    <label class="switch-toggle mr-2">
                        <input type="checkbox" id="isView" name="isView" value="Y" checked="">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary" onclick="formWrite(this.form, 3)">등록</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php } else if ( $lvl == '4' && $isSel == 'Y') { ?>
<form id="catForm4" name="catForm4" method="post" class="" onsubmit="return false;">
    <input type="hidden" id="lvl" name="lvl" value="4">
    <input type="hidden" id="pIdx" name="pIdx" value="<?= $pIdx ?>">
    <input type="hidden" id="brandCode" name="brandCode" value="<?=$brandCode?>">
    <input type="hidden" id="corpCode" name="corpCode" value="<?=$corpCode?>">
    <div class="reg-form">
        <div class="input-group justify-content-end">
            <label class="w-100">▶ 지점명</label>
            <select name="selectCorp" id="selectCorp" class="form-control">
                <option value="">지점을 선택해 주세요.</option>
                <?php foreach ($branchList as $row) { ?>
                    <option value="<?= $row['applyCorp'] ?>"><?= $row['corpName'] ?></option>
                <?php } ?>
            </select>
            <label class="w-100 mt-3">▶ 가격</label>
            <input type="text" id="treatmentPrice" name="treatmentPrice" value="" class="form-control w-100 productPrice" maxlength="150" placeholder="가격을 입력해 주세요.">
            <label class="w-100 mt-3">▶ 가격 메모</label>
            <textarea type="text" id="treatmentMemo" name="treatmentMemo" value="" class="form-control w-100" maxlength="2000" placeholder="가격메모를 입력해 주세요."></textarea>
            <div class="btn-wrap d-flex align-items-center mt-2">
                <div class="switch-toggle-box d-flex align-center">
                    <p class="mr-2 text-small">노출여부</p>
                    <label class="switch-toggle mr-2">
                        <input type="checkbox" id="isView" name="isView" value="Y" checked>
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary" onclick="formWrite(this.form, 4)">등록</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php } ?>

<ul class="as-list cat-list">
    <?php
    if ( count($categoryList) > 0 ) {
        foreach ($categoryList as $key => $val) {

    ?>
            <?php if ( $lvl == '1' ) { ?>   <!-- 1차 카테고리 -->

                <li class="categoryLvl1" id="category_<?= $lvl ?>_<?= $val['pubCode'] ?>">
                    <div class="view-box">
                        <div class="inbox" onclick="
                                getCategoryCodeList('categoryCodeDiv2', '<?=$val['pubCode']?>', '2', 'Y', '');
                                getCategoryCodeList('categoryCodeDiv3', '<?=$val['pubCode']?>', '3', 'N', '');
                                getCategoryCodeList('categoryCodeDiv4', '<?=$val['pubCode']?>', '4', 'N', '');
                                " value="<?= $val['pubCode'] ?>">
                                <div class="product-name">
                                    <span class="txt" id="view-name-<?= $lvl ?>-<?= $val['pubCode'] ?>"><?= $val['codeName'] ?></span>
                                </div>
                        </div>
                        <div class="edit-btn-box d-flex align-center position-absolute">
                            <div class="switch-toggle-box d-flex align-center">
                                <p class="mr-2 text-small">노출여부</p>
                                <label class="switch-toggle mr-2">
                                    <input type="checkbox" id="isView" name="isView" data-lvl="<?= $lvl ?>" data-idx="<?= $val['pubCode'] ?>" <?php if ($val['isView'] == 'Y') echo 'checked' ?>><!--  onclick="chkDeletePin('exposure')" -->
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <button type="button" class="btn btn-secondary btn-modify mr-1">수정</button>
                            <button type="button" class="btn btn-delete" onclick="chkDeletePin('del','<?= $lvl ?>', '<?= $val['pubCode'] ?>', '')">삭제</button><!--  onclick="chkDeletePin('del')" -->
                        </div>
                    </div>
                    <div class="modify-box">
                        <form id="catForm1_<?= $val['pubCode'] ?>" name="catForm1_<?= $val['pubCode'] ?>" method="post" class="" onsubmit="return false;">
                            <div class="inbox">
                                <div class="product-name">
                                    <input type="text" id="modify-name-<?= $lvl ?>-<?= $val['pubCode'] ?>" name="categoryName" class="form-control mb-1" value="<?= $val['codeName']  ?>">
                                </div>
                            </div>
                            <div class="edit-btn-box d-flex position-absolute">
                                <div class="switch-toggle-box d-flex align-center">
                                    <p class="mr-2 text-small">노출여부</p>
                                    <label class="switch-toggle mr-2">
                                        <input type="checkbox" id="isView" name="isView" value="Y" <?php if ($val['isView'] == 'Y') echo 'checked' ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <button type="button" class="btn btn-basic" onclick="cancelBtn(this, '<?= $lvl ?>', '<?= $val['pubCode'] ?>')">취소</button>
                                <button type="button" class="btn btn-secondary" onclick="saveBtn(event, '<?= $lvl ?>', '<?= $val['pubCode'] ?>')">저장</button>
                            </div>
                        </form>
                    </div>
                </li>
            <?php } else if ( $lvl == '2' ) { ?>    <!-- 2차 카테고리 -->
                <li class="categoryLvl2" id="category_<?= $lvl ?>_<?= $val['pubCode'] ?>">
                    <div class="view-box">
                        <div class="inbox" onclick="
                                getCategoryCodeList('categoryCodeDiv3', '<?=$val['pubCode']?>', '3', 'Y', '');
                                getCategoryCodeList('categoryCodeDiv4', '<?=$val['pubCode']?>', '4', 'N', '');
                                " value="<?= $val['pubCode'] ?>">

                            <div class="product-name">
                                <span class="txt" id="view-name-<?= $lvl ?>-<?= $val['pubCode'] ?>"><?= $val['codeName'] ?></span>
                            </div>
                        </div>
                        <div class="edit-btn-box d-flex align-center position-absolute">
                            <div class="switch-toggle-box d-flex align-center">
                                <p class="mr-2 text-small">노출여부</p>
                                <label class="switch-toggle mr-2">
                                    <input type="checkbox" id="isView" name="isView" data-lvl="<?= $lvl ?>" data-idx="<?= $val['pubCode'] ?>" <?php if ($val['isView'] == 'Y') echo 'checked' ?>>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <button type="button" class="btn btn-secondary btn-modify mr-1">수정</button>
                            <button type="button" class="btn btn-delete" onclick="chkDeletePin('del', '<?= $lvl ?>', '<?= $val['pubCode'] ?>', '<?= $val['pPubCode'] ?>')">삭제</button>
                        </div>
                    </div>

                    <div class="modify-box">
                        <form id="catForm2_<?= $val['pubCode'] ?>" name="catForm2_<?= $val['pubCode'] ?>" method="post" class="" onsubmit="return false;">
                            <div class="inbox">
                                <div class="product-name">
                                    <input type="text" id="modify-name-<?= $lvl ?>-<?= $val['pubCode'] ?>" name="categoryName" class="form-control mb-1" value="<?= $val['codeName'] ?>">
                                </div>
                            </div>
                            <div class="edit-btn-box d-flex position-absolute">
                                <div class="switch-toggle-box d-flex align-center">
                                    <p class="mr-2 text-small">노출여부</p>
                                    <label class="switch-toggle mr-2">
                                        <input type="checkbox" id="isView" name="isView" value="Y" <?php if ($val['isView'] == 'Y') echo 'checked' ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <button type="button" class="btn btn-basic" onclick="cancelBtn(this, '<?= $lvl ?>', '<?= $val['pubCode'] ?>')">취소</button>
                                <button type="button" class="btn btn-secondary" onclick="saveBtn(event, '<?= $lvl ?>', '<?= $val['pubCode'] ?>')">저장</button>
                            </div>
                        </form>
                    </div>
                </li>
            <?php } else if ( $lvl == '3' ) { ?>    <!-- 3차 카테고리 (시술명) -->
                <li class="categoryLvl3" id="category_<?= $lvl ?>_<?= $val['treatmentCode'] ?>">
                    <div class="view-box">
                        <div class="inbox" onclick="getCategoryCodeList('categoryCodeDiv4', '<?=$val['treatmentCode']?>', '4', 'Y', '')" value="<?= $val['treatmentCode'] ?>">
                            <div class="product-name">
                                <p class="tit">▶ 시술명</p>
                                <p class="txt" id="view-name-<?= $lvl ?>-<?= $val['treatmentCode'] ?>"><?= $val['treatmentName'] ?></p>
                            </div>
                            <?php if ($val['treatmentMemo']) { ?>
                                <div class="product-memo">
                                    <p class="tit">▶ 시술 메모</p>
                                    <p class="txt" id="view-memo-<?= $lvl ?>-<?= $val['treatmentCode'] ?>"><?= nl2br($val['treatmentMemo']) ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="edit-btn-box d-flex align-center position-absolute">
                            <div class="switch-toggle-box d-flex align-center">
                                <p class="mr-2 text-small">노출여부</p>
                                <label class="switch-toggle mr-2">
                                    <input type="checkbox" id="isView" name="isView" data-lvl="<?= $lvl ?>" data-idx="<?= $val['treatmentCode'] ?>" <?php if ($val['isView'] == 'Y') echo 'checked' ?>>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <button type="button" class="btn btn-secondary btn-modify mr-1">수정</button>
                            <button type="button" class="btn btn-delete" onclick="chkDeletePin('del', '<?= $lvl ?>', '<?= $val['treatmentCode'] ?>', '<?= $val['cate2'] ?>')">삭제</button>
                        </div>
                    </div>

                    <div class="modify-box">
                        <form id="catForm3_<?= $val['treatmentCode'] ?>" name="catForm3_<?= $val['treatmentCode'] ?>" method="post" class="" onsubmit="return false;">
                            <div class="inbox">
                                <div class="product-name">
                                    <p class="tit">▶ 시술명</p>
                                    <input type="text" id="modify-name-<?= $lvl ?>-<?= $val['treatmentCode'] ?>" name="categoryName" class="form-control mb-1" value="<?= $val['treatmentName'] ?>">
                                </div>
                                <div class="product-memo">
                                    <p class="tit">▶ 시술 메모</p>
                                    <textarea rows="8" id="modify-memo-<?= $lvl ?>-<?= $val['treatmentCode'] ?>" name="categoryMemo" class="form-control mb-1"><?= $val['treatmentMemo'] ?></textarea>
                                </div>
                            </div>
                            <div class="edit-btn-box d-flex position-absolute">
                                <div class="switch-toggle-box d-flex align-center">
                                    <p class="mr-2 text-small">노출여부</p>
                                    <label class="switch-toggle mr-2">
                                        <input type="checkbox" id="isView" name="isView" value="Y" <?php if ($val['isView'] == 'Y') echo 'checked' ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <button type="button" class="btn btn-basic" onclick="cancelBtn(this, '<?= $lvl ?>', '<?= $val['treatmentCode'] ?>')">취소</button>
                                <button type="button" class="btn btn-secondary" onclick="saveBtn(event, '<?= $lvl ?>', '<?= $val['treatmentCode'] ?>')">저장</button>
                            </div>
                        </form>
                    </div>
                </li>
            <?php } else if ($lvl == '4') { ?>      <!-- 4차 카테고리 (가격 정보) -->
                <li class="" id="category_<?= $lvl ?>_<?= $val['idx'] ?>">
                    <div class="view-box">
                        <div class="inbox">
                            <div class="branch-name">
                                <p class="tit">▶ 지점명</p>
                                <p class="txt" id="view-corp-<?= $lvl ?>-<?= $val['idx'] ?>" data-code="<?= $val['applyCorp'] ?>"><?= $val['corpName'] ?></p>
                            </div>
                            <div class="product-price">
                                <p class="tit">▶ 가격</p>
                                <p class="txt" id="view-price-<?= $lvl ?>-<?= $val['idx'] ?>">₩ <?= number_format($val['price']) ?></p>
                            </div>
                            <div class="price-memo">
                                <p class="tit">▶ 가격 메모</p>
                                <p class="txt" id="view-memo-<?= $lvl ?>-<?= $val['idx'] ?>"><?= nl2br($val['memo']) ?></p>
                            </div>
                        </div>
                        <div class="edit-btn-box d-flex align-center position-absolute">
                            <div class="switch-toggle-box d-flex align-center">
                                <p class="mr-2 text-small">노출여부</p>
                                <label class="switch-toggle mr-2">
                                    <input type="checkbox" id="isView" name="isView" data-lvl="<?= $lvl ?>" data-idx="<?= $val['idx'] ?>" <?php if ($val['isView'] == 'Y') echo 'checked' ?>>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <button type="button" class="btn btn-secondary btn-modify mr-1">수정</button>
                            <button type="button" class="btn btn-delete" onclick="chkDeletePin('del', '<?= $lvl ?>', '<?= $val['idx'] ?>' , '<?= $val['treatmentIdx'] ?>', '<?= $val['applyCorp'] ?>')">삭제</button>
                        </div>
                    </div>
                    <div class="modify-box">
                        <form id="catForm4_<?= $val['idx'] ?>" name="catForm4_<?= $val['idx'] ?>" method="post" class="" onsubmit="return false;">
                            <div class="inbox">
                                <div class="branch-name">
                                    <p class="tit">▶ 지점명</p>
                                    <select name="selectCorp" id="selectCorp" class="form-control">
                                        <option value="">지점을 선택해 주세요.</option>
                                        <?php foreach ($branchList as $row) { ?>
                                            <option value="<?= $row['applyCorp'] ?>" <?php if ($val['applyCorp'] == $row['applyCorp'] ) echo "selected" ?>><?= $row['corpName'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="product-price">
                                    <p class="tit">▶ 가격</p>
                                    <input type="text" id="modify-price-<?= $lvl ?>-<?= $val['idx'] ?>" name="treatmentPrice" class="form-control mb-1 productPrice" value="<?= $val['price'] ?>">
                                </div>
                                <div class="price-memo">
                                    <p class="tit">▶ 가격 메모</p>
                                    <textarea rows="8" id="modify-memo-<?= $lvl ?>-<?= $val['idx'] ?>" name="treatmentMemo" class="form-control mb-1"><?= $val['memo'] ?></textarea>
                                </div>
                            </div>

                            <div class="edit-btn-box d-flex position-absolute">
                                <div class="switch-toggle-box d-flex align-center">
                                    <p class="mr-2 text-small">노출여부</p>
                                    <label class="switch-toggle mr-2">
                                        <input type="checkbox" id="isView" name="isView" value="Y" <?php if ($val['isView'] == 'Y') echo 'checked' ?>>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <button type="button" class="btn btn-basic" onclick="cancelBtn(this, '<?= $lvl ?>', '<?= $val['idx'] ?>');">취소</button>
                                <button type="button" class="btn btn-secondary" onclick="saveBtn(event, '<?= $lvl ?>', '<?= $val['idx'] ?>')">저장</button>
                            </div>
                        </form>
                    </div>
                </li>
            <?php } ?>
    <?php }
    } else {
    ?>
        <?php if ($isSel == 'Y' && $isSearch == 'Y') { ?>
            <li class="no-data ui-sortable-handle">검색된 카테고리가 없습니다.</li>
        <?php } else if ($isSel == 'Y' && $isSearch == '')  { ?>
            <li class="no-data ui-sortable-handle">등록된 카테고리가 없습니다.</li>
        <?php } ?>
    <?php
    }
    ?>
</ul>

<script>
    function chkDeletePin(gubun, lvl, idx, pIdx, applyCorp = "") {

        $('#' + gubun +  'Popup #lvl').val(lvl);
        $('#' + gubun +  'Popup #idx').val(idx);
        $('#' + gubun +  'Popup #pIdx').val(pIdx);
        $('#' + gubun +  'Popup #selectCorp').val(applyCorp);

        // 모달창 오픈
        $(`#${gubun}Popup`).dialog({
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
                if(gubun == "del" && lvl == "4"){
                    $('.price-del-txt').show();
                    $('.del-txt').hide();
                } else {
                    $('.price-del-txt').hide();
                    $('.del-txt').show();
                }
                $(`#${gubun}Popup .btn-basic`).on("click", function() {
                    $(`#${gubun}Popup`).dialog('close');
                });
            },
            close: function(event, ui) {
                /*삭제 스트립트*/
            }
        });
        $('.ui-widget-header').remove();
    }

    function cancelBtn(el, lvl, idx)
    {
        let modifyBox = $(el).closest('.modify-box');

        modifyBox.css({'display':'none'});
        modifyBox.siblings().css({'display':'block'});

        // 수정 중 취소시 내용 원복
        if ( lvl == '1' || lvl == '2' ) {
            let viewName = $('#view-name-' + lvl + '-' + idx).text();
            $('#modify-name-' + lvl + '-' + idx).val(viewName);
        } else if ( lvl == '3' ) {
            let viewName = $('#view-name-' + lvl + '-' + idx).text();
            let viewMemo = $('#view-memo-' + lvl + '-' + idx).text();
            $('#modify-name-' + lvl + '-' + idx).val(viewName);
            $('#modify-memo-' + lvl + '-' + idx).val(viewMemo);
        } else if ( lvl == '4' ) {
            let viewCorp = $('#view-corp-' + lvl + '-' + idx).data('code');
            let viewPrice = $('#view-price-' + lvl + '-' + idx).text();
            let viewMemo = $('#view-memo-' + lvl + '-' + idx).text();
            modifyBox.find('#selectCorp').val(viewCorp);
            $('#modify-price-' + lvl + '-' + idx).val(viewPrice);
            $('#modify-memo-' + lvl + '-' + idx).val(viewMemo);
        }
    }

    // 메모 수정
    $('.view-box .btn-modify').off('click').on('click', function(event){
        event.stopPropagation();
        $(this).closest('.view-box').css({'display':'none'});
        $(this).closest('.view-box').siblings().css({'display':'block'});
    });


    // 선택 된 카테고리 active
    $('.cat-list > li').on('click', function(e){
        if(!$(e.target).hasClass('form-control') && !$(e.target).closest('.edit-btn-box').length) {
            $(this).parent().find('li').removeClass('active');
            $(this).addClass('active');
        }
    });

    // 노출 여부 선택 시 이벤트
    $('.as-list .view-box .switch-toggle input[type="checkbox"]').off('change').on('change', function(){
        const idx = $(this).data('idx');
        const lvl = $(this).data('lvl');

        if(this.checked == false){
            chkDeletePin('exposure');
            $(this).prop('checked',true);
            let checkSave = $(this);
            $('#exposurePopup .btn-secondary').off('click').on('click', function(){
                chgState(lvl, idx, 'N');
                $(checkSave).prop('checked',false);
                $("#exposurePopup").dialog('close');
            });
        } else {
            chgState(lvl, idx, 'Y');
        }
    });

    // 글자수 제한
    $('.form-control').off('keyup').on('keyup', function () {
        let inputId = $(this).attr('id');
        let inputName = $(this).attr('name');
        let inputVal = $(this).val();
        // 글자수 세기
        // if (content.length == 0 || content == '') {
        //     $('.textCount').text('0자');
        // } else {
        //     $('.textCount').text(content.length + '자');
        // }
        // if(inputId == "categoryMemo" || $('input[name="treatmentMemo"]')) {
        if(inputId == "categoryMemo" || inputName == "treatmentMemo") {
            if (inputVal.length >= 2000) {
                // 시술 메모 2000자 부터는 타이핑 되지 않도록
                $(this).val($(this).val().substring(0, 2000));
                // 2000자 넘으면 알림창 뜨도록
                alert('2000자 이내로 입력해주세요.');
            };
        } else {
            if (inputVal.length >= 150) {
                // 시술명, 카테고리명 150자 부터는 타이핑 되지 않도록
                $(this).val($(this).val().substring(0, 150));
                // 150자 넘으면 알림창 뜨도록
                alert('150자 이내로 입력해주세요.');
            };
        }

        // console.log(inputName);
    });

    // 금액 숫자만, 콤마 자동 입력
    $('.productPrice').keyup(function () {
        var newVal = addCommas($(this).val().replace(/[^0-9]/g, ""));
        $(this).val(newVal);
    });
</script>
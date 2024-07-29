<ul class="as-list cat-list drag" id="cat-list-<?= $lvl ?>">
    <input type="hidden" id="lvl" name="lvl" value="<?= $lvl ?>">
    <input type="hidden" id="pIdx" name="pIdx" value="<?= $pIdx ?>">
    <input type="hidden" id="brandCode" name="brandCode" value="<?=$brandCode?>">
    <input type="hidden" id="corpCode" name="corpCode" value="<?=$corpCode?>">
    <?php
    if ( count($categoryList) > 0 ) {
        foreach ($categoryList as $key => $val) {
            if ($val['isView'] == 'N') continue;

    ?>
            <?php if ( $lvl == '1' ) { ?>   <!-- 1차 카테고리 -->
                <li class="categoryLvl1" onclick="
                        getCategoryCodeList('categoryCodeDiv2', '<?=$val['pubCode']?>', '2', 'Y', '');
                        getCategoryCodeList('categoryCodeDiv3', '<?=$val['pubCode']?>', '3', 'N', '');
                        getCategoryCodeList('categoryCodeDiv4', '<?=$val['pubCode']?>', '4', 'N', '');
                    " value="<?= $val['pubCode'] ?>" >
                    <span class="txt"><?= $val['codeName'] ?></span>
                    <span class="dd-icon">
                        <img src="/media/img/icon/handle_icon.svg" alt="">
                    </span>
                </li>
            <?php } else if ( $lvl == '2' ) { ?>    <!-- 2차 카테고리 -->
                <li class="categoryLvl2" onclick="
                        getCategoryCodeList('categoryCodeDiv3', '<?=$val['pubCode']?>', '3', 'Y', '');
                        getCategoryCodeList('categoryCodeDiv4', '<?=$val['pubCode']?>', '4', 'N', '');
                    " value="<?= $val['pubCode'] ?>" >
                    <span class="txt"><?= $val['codeName'] ?></span>
                    <span class="dd-icon">
                        <img src="/media/img/icon/handle_icon.svg" alt="">
                    </span>
                </li>
            <?php } else if ( $lvl == '3' ) { ?>    <!-- 3차 카테고리 (시술명) -->
                <?php
                $treatementName = $val['treatmentName'];
                $treatementMemo = $val['treatmentMemo'];
                // 검색어 강조
                if ( $schWord ) {
                    $schWordArr = explode(',', $schWord);
                    foreach ($schWordArr as $row) {
                        if ($row == "") continue;
                        $row = trim($row);
                        if ($schCategory == 'category') {
                            $treatementName = preg_replace('/'.$row.'/i', '<span class="sch">$0</span>', $treatementName);
                        }
                        if ($schCategory == 'memo') {
                            $treatementMemo = preg_replace('/'.$row.'/i', '<span class="sch">$0</span>', $treatementMemo);
                        }
                    }
                }
                ?>
                <li class="categoryLvl3" value="<?= $val['treatmentCode'] ?>">
                    <div class="view-box" onclick="getCategoryCodeList('categoryCodeDiv4', '<?=$val['treatmentCode']?>', '4', 'Y', '')">
                        <div class="inbox">
                            <div class="product-name">
                                <p class="tit">▶ 시술명</p>
                                <p class="txt"><?= $treatementName ?></p>
                            </div>
                            <?php if ($treatementMemo) { ?>
                                <div class="product-memo">
                                    <p class="tit">▶ 시술 메모</p>
                                    <p class="txt" id="view_category3_memo"><?= nl2br($treatementMemo) ?></p>
                                </div>
                            <?php } ?>
                            <div class="edit-btn-box">
                                <button type="button" class="btn btn-secondary btn-modify">메모 수정</button>
                            </div>
                        </div>
                    </div>
                    <div class="modify-box">
                        <form id="catForm3_<?= $val['treatmentCode'] ?>" name="catForm3_<?= $val['treatmentCode'] ?>" method="post" class="" onsubmit="return false;">
                            <input type="hidden" id="categoryName" name="categoryName" value="<?= $val['treatmentName'] ?>">
                            <div class="inbox">
                                <div class="product-name">
                                    <p class="tit">▶ 시술명</p>
                                    <p class="txt" name="categoryName"><?= $val['treatmentName'] ?></p>
                                </div>
                                <div class="product-memo">
                                    <p class="tit">▶ 시술 메모</p>
                                    <textarea rows="8" id="modify_category3_memo" name="categoryMemo" class="form-control mb-1" ><?= $val['treatmentMemo'] ?></textarea>
                                </div>
                                <div class="edit-btn-box d-flex">
                                    <button type="button" class="btn btn-basic" data-lvl="<?= $lvl ?>">취소</button>
                                    <button type="button" class="btn btn-secondary" onclick="modifyProc(event, '<?= $lvl ?>', '<?= $val['treatmentCode'] ?>');">저장</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <span class="dd-icon">
                        <img src="/media/img/icon/handle_icon.svg" alt="">
                    </span>
                </li>
            <?php } else if ($lvl == '4') { ?>      <!-- 4차 카테고리 (가격 정보) -->
                <li class="">
                    <div class="view-box">
                        <div class="inbox">
                            <div class="branch-name">
                                <p class="tit">▶ 지점명</p>
                                <p class="txt"><?= $val['corpName'] ?></p>
                            </div>
                            <div class="product-price">
                                <p class="tit">▶ 가격</p>
                                <p class="txt" id="view_category4_price">₩ <?= number_format($val['price']) ?></p>
                            </div>
                            <?php if ($val['memo']) { ?>
                                <div class="price-memo">
                                    <p class="tit">▶ 가격 메모</p>
                                    <p class="txt" id="view_category4_memo"><?= nl2br($val['memo']) ?></p>
                                </div>
                            <?php } ?>
                            <div class="edit-btn-box">
<!--                                <button type="button" class="btn btn-secondary btn-modify">수정</button>-->
                                <button type="button" class="btn btn-delete" onclick="chkDeletePin('<?= $lvl ?>', '<?= $val['idx'] ?>', '<?= $val['treatmentIdx'] ?>', '<?= $val['applyCorp'] ?>')">삭제</button>
                            </div>
                        </div>
                    </div>
                    <div class="modify-box">
                        <form id="catForm4_<?= $val['idx'] ?>" name="catForm4_<?= $val['idx'] ?>" method="post" class="" onsubmit="return false;">
                            <input type="hidden" id="selectCorp" name="selectCorp" value="<?= $val['applyCorp'] ?>">
                            <div class="inbox">
                                <div class="branch-name">
                                    <p class="tit">▶ 지점명</p>
                                    <p class="txt"><?= $val['corpName'] ?></p>
                                </div>
                                <div class="product-price">
                                    <p class="tit">▶ 가격</p>
                                    <input type="text" id="modify_category4_price" name="treatmentPrice" class="form-control mb-1" value="<?= $val['price'] ?>">
                                </div>
                                <div class="price-memo">
                                    <p class="tit">▶ 가격 메모</p>
                                    <textarea rows="8" id="modify_category4_memo" name="treatmentMemo" class="form-control mb-1" placeholder="가격 메모를 입력해주세요."><?= $val['memo'] ?></textarea>
                                </div>
                                <div class="edit-btn-box d-flex">
<!--                                    <button type="button" class="btn btn-basic" data-lvl="--><?php //= $lvl ?><!--">취소</button>-->
                                    <button type="button" class="btn btn-secondary" onclick="modifyProc(event, '<?= $lvl ?>', '<?= $val['idx'] ?>');">저장</button>
                                </div>
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
    function chkDeletePin(lvl, idx, pIdx, applyCorp = "")
    {
        $('#deletePopup #lvl').val(lvl);
        $('#deletePopup #idx').val(idx);
        $('#deletePopup #pIdx').val(pIdx);
        $('#deletePopup #selectCorp').val(applyCorp);

        //모달창 오픈
        $( "#deletePopup" ).dialog({
            autoOpen				:	true,
            show					:	{effect:'fade', speed: 200},
            hide					:	{effect:'fade', speed: 200},
            modal					:	true,
            resizable				:	false,
            width					:	"450",
            height					:	"260",
            autoResize				:	true,
            open					:	function(event, ui)
            {
                $( ".ui-dialog" ).css( "z-index", 10000 );

                $( "#deletePopup .btn-basic" ).on("click", function() {
                    $( "#deletePopup" ).dialog('close');
                });
            },
            close					:	function(event, ui)
            {

            }
        });

        $('.ui-widget-header').remove();
    }

    // 순서 변경
    function chgIndex(gubun)
    {
        if ( gubun == "1" ) {
            $( "#indexGubun" ).val("1");
            $( "#chgBtn1" ).hide();
            $( "#chgBtn2" ).show();
            $(".globalPrice-content").removeClass("drag-drop");
            $(".cat-list:not('#cat-list-4')").removeClass("drag");
            $(".cat-list:not('#cat-list-4') > li").removeClass("item");

            // sortProc();     // 순서 저장

        } else {
            $( "#indexGubun" ).val("2");
            $( "#chgBtn1" ).show();
            $( "#chgBtn2" ).hide();
            $(".globalPrice-content").addClass("drag-drop");
            $(".cat-list:not('#cat-list-4')").addClass("drag");
            $(".cat-list:not('#cat-list-4') > li").addClass("item");

            const drag = document.querySelectorAll('.drag');
            drag.forEach((column) => {
                new Sortable(column, {
                    group: {
                        name: "shared",
                        pull: "clone",
                        put: false,
                    },
                    animation: 150,
                    draggable: ".item",
                });
            });
        }

    }

    // 메모 수정
    $('.view-box .btn-modify').off().on('click', function(event){
        console.log($(this));
        event.stopPropagation();
        $(this).closest('.view-box').css({'display':'none'});
        $(this).closest('.view-box').siblings().css({'display':'block'});
    });

    // 메모 수정 취소
    $('.modify-box .btn-basic').off().on('click', function(event){
        console.log($(this));
        event.stopPropagation();
        $(this).closest('.modify-box').css({'display':'none'});
        $(this).closest('.modify-box').siblings().css({'display':'block'});

    });

    // 선택 된 카테고리 active
    $('.cat-list > li').on('click', function(e){
        if(!$(e.target).hasClass('form-control') && !$(e.target).closest('.edit-btn-box').length) {
            $(this).parent().find('li').removeClass('active');
            $(this).addClass('active');
        }
    });
</script>
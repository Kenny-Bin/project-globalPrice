<?php if ( $lvl == '1' ) { ?>
        <div class="view-box">
            <div class="inbox" onclick="
                    getCategoryCodeList('categoryCodeDiv2', '<?=$pubCode?>', '2', 'Y', '');
                    getCategoryCodeList('categoryCodeDiv3', '<?=$pubCode?>', '3', 'N', '');
                    getCategoryCodeList('categoryCodeDiv4', '<?=$pubCode?>', '4', 'N', '');
                    " value="<?= $pubCode ?>">
                <span class="txt"><?= $codeName ?></span>
            </div>
            <div class="edit-btn-box d-flex align-center position-absolute">
                <div class="switch-toggle-box d-flex align-center">
                    <p class="mr-2 text-small">노출여부</p>
                    <label class="switch-toggle mr-2">
                        <input type="checkbox" id="isView" name="isView" data-lvl="<?= $lvl ?>" data-idx="<?= $pubCode ?>" <?php if ($resultView == 'Y') echo 'checked' ?>><!--  onclick="chkDeletePin('exposure')" -->
                        <span class="slider"></span>
                    </label>
                </div>
                <button type="button" class="btn btn-secondary btn-modify mr-1">수정</button>
                <button type="button" class="btn btn-delete" onclick="chkDeletePin('del','<?= $lvl ?>', '<?= $pubCode ?>', '')">삭제</button><!--  onclick="chkDeletePin('del')" -->
            </div>
        </div>
        <div class="modify-box">
            <form id="catForm1_<?= $pubCode ?>" name="catForm1_<?= $pubCode ?>" method="post" class="" onsubmit="return false;">
                <div class="inbox">
                    <div class="product-name">
                        <input type="text" name="categoryName" class="form-control mb-1" value="<?= $codeName  ?>">
                    </div>
                </div>
                <div class="edit-btn-box d-flex position-absolute">
                    <div class="switch-toggle-box d-flex align-center">
                        <p class="mr-2 text-small">노출여부</p>
                        <label class="switch-toggle mr-2">
                            <input type="checkbox" id="isView" name="isView" value="Y" <?php if ($resultView == 'Y') echo 'checked' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <button type="button" class="btn btn-basic">취소</button>
                    <button type="button" class="btn btn-secondary" onclick="saveBtn(event, '<?= $lvl ?>', '<?= $pubCode ?>')">저장</button>
                </div>
            </form>
        </div>
<?php } else if ( $lvl == '2' ) { ?>
        <div class="view-box">
            <div class="inbox" onclick="
                    getCategoryCodeList('categoryCodeDiv3', '<?=$pubCode?>', '3', 'Y', '');
                    getCategoryCodeList('categoryCodeDiv4', '<?=$pubCode?>', '4', 'N', '');
                    " value="<?= $pubCode ?>">
                <span class="txt"><?= $codeName ?></span>
            </div>
            <div class="edit-btn-box d-flex align-center position-absolute">
                <div class="switch-toggle-box d-flex align-center">
                    <p class="mr-2 text-small">노출여부</p>
                    <label class="switch-toggle mr-2">
                        <input type="checkbox" id="isView" name="isView" data-lvl="<?= $lvl ?>" data-idx="<?= $pubCode ?>" <?php if ($resultView == 'Y') echo 'checked' ?>>
                        <span class="slider"></span>
                    </label>
                </div>
                <button type="button" class="btn btn-secondary btn-modify mr-1">수정</button>
                <button type="button" class="btn btn-delete" onclick="chkDeletePin('del', '<?= $lvl ?>', '<?= $pubCode ?>', '<?= $pPubCode ?>')">삭제</button>
            </div>
        </div>

        <div class="modify-box">
            <form id="catForm2_<?= $pubCode ?>" name="catForm2_<?= $pubCode ?>" method="post" class="" onsubmit="return false;">
                <div class="inbox">
                    <div class="product-name">
                        <input type="text" name="categoryName" class="form-control mb-1" value="<?= $codeName ?>">
                    </div>
                </div>
                <div class="edit-btn-box d-flex position-absolute">
                    <div class="switch-toggle-box d-flex align-center">
                        <p class="mr-2 text-small">노출여부</p>
                        <label class="switch-toggle mr-2">
                            <input type="checkbox" id="isView" name="isView" value="Y" <?php if ($resultView == 'Y') echo 'checked' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <button type="button" class="btn btn-basic">취소</button>
                    <button type="button" class="btn btn-secondary" onclick="saveBtn(event, '<?= $lvl ?>', '<?= $pubCode ?>')">저장</button>
                </div>
            </form>
        </div>
<?php } else if ( $lvl == '3' ) { ?>
        <div class="view-box">
            <div class="inbox" onclick="getCategoryCodeList('categoryCodeDiv4', '<?= $treatmentCode ?>', '4', 'Y', '')" value="<?= $treatmentCode ?>">
                <div class="product-name">
                    <p class="tit">▶ 시술명</p>
                    <p class="txt"><?= $treatmentName ?></p>
                </div>
                <?php if ($treatmentMemo) { ?>
                    <div class="product-memo">
                        <p class="tit">▶ 시술 메모</p>
                        <p class="txt"><?= nl2br($treatmentMemo) ?></p>
                    </div>
                <?php } ?>
            </div>
            <div class="edit-btn-box d-flex align-center position-absolute">
                <div class="switch-toggle-box d-flex align-center">
                    <p class="mr-2 text-small">노출여부</p>
                    <label class="switch-toggle mr-2">
                        <input type="checkbox" id="isView" name="isView" data-lvl="<?= $lvl ?>" data-idx="<?= $treatmentCode ?>" <?php if ($resultView == 'Y') echo 'checked' ?>>
                        <span class="slider"></span>
                    </label>
                </div>
                <button type="button" class="btn btn-secondary btn-modify mr-1">수정</button>
                <button type="button" class="btn btn-delete" onclick="chkDeletePin('del', '<?= $lvl ?>', '<?= $treatmentCode ?>', '<?= $cate2 ?>')">삭제</button>
            </div>
        </div>

        <div class="modify-box">
            <form id="catForm3_<?= $treatmentCode ?>" name="catForm3_<?= $treatmentCode ?>" method="post" class="" onsubmit="return false;">
                <div class="inbox">
                    <div class="product-name">
                        <p class="tit">▶ 시술명</p>
                        <input type="text" name="categoryName" class="form-control mb-1" value="<?= $treatmentName ?>">
                    </div>
                    <div class="product-memo">
                        <p class="tit">▶ 시술 메모</p>
                        <textarea rows="8" name="categoryMemo" class="form-control mb-1"><?= $treatmentMemo ?></textarea>
                    </div>
                </div>
                <div class="edit-btn-box d-flex position-absolute">
                    <div class="switch-toggle-box d-flex align-center">
                        <p class="mr-2 text-small">노출여부</p>
                        <label class="switch-toggle mr-2">
                            <input type="checkbox" id="isView" name="isView" value="Y" <?php if ($resultView == 'Y') echo 'checked' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <button type="button" class="btn btn-basic">취소</button>
                    <button type="button" class="btn btn-secondary" onclick="saveBtn(event, '<?= $lvl ?>', '<?= $treatmentCode ?>')">저장</button>
                </div>
            </form>
        </div>
<?php } else if ($lvl == '4') { ?>
        <div class="view-box">
            <div class="inbox">
                <div class="branch-name">
                    <p class="tit">▶ 지점명</p>
                    <p class="txt"><?= $corpName ?></p>
                </div>
                <div class="product-price">
                    <p class="tit">▶ 가격</p>
                    <p class="txt">₩ <?= number_format($price) ?></p>
                </div>
                <div class="price-memo">
                    <p class="tit">▶ 가격 메모</p>
                    <p class="txt"><?= nl2br($memo) ?></p>
                </div>
            </div>
            <div class="edit-btn-box d-flex align-center position-absolute">
                <div class="switch-toggle-box d-flex align-center">
                    <p class="mr-2 text-small">노출여부</p>
                    <label class="switch-toggle mr-2">
                        <input type="checkbox" id="isView" name="isView" data-lvl="<?= $lvl ?>" data-idx="<?= $idx ?>" <?php if ($resultView == 'Y') echo 'checked' ?>>
                        <span class="slider"></span>
                    </label>
                </div>
                <button type="button" class="btn btn-secondary btn-modify mr-1">수정</button>
                <button type="button" class="btn btn-delete" onclick="chkDeletePin('del', '<?= $lvl ?>', '<?= $idx ?>' , '<?= $treatmentIdx ?>', '<?= $applyCorp ?>')">삭제</button>
            </div>
        </div>
        <div class="modify-box">
            <form id="catForm4_<?= $idx ?>" name="catForm4_<?= $idx ?>" method="post" class="" onsubmit="return false;">
                <div class="inbox">
                    <div class="branch-name">
                        <p class="tit">▶ 지점명</p>
                        <select name="selectCorp" id="selectCorp" class="form-control">
                            <option value="">지점을 선택해 주세요.</option>
                            <?php foreach ($branchList as $row) { ?>
                                <option value="<?= $row['applyCorp'] ?>" <?php if ($applyCorp == $row['applyCorp'] ) echo "selected" ?>><?= $row['corpName'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="product-price">
                        <p class="tit">▶ 가격</p>
                        <input type="text" name="treatmentPrice" class="form-control mb-1 productPrice" value="<?= $price ?>">
                    </div>
                    <div class="price-memo">
                        <p class="tit">▶ 가격 메모</p>
                        <textarea rows="8" name="treatmentMemo" class="form-control mb-1"><?= $memo ?></textarea>
                    </div>
                </div>

                <div class="edit-btn-box d-flex position-absolute">
                    <div class="switch-toggle-box d-flex align-center">
                        <p class="mr-2 text-small">노출여부</p>
                        <label class="switch-toggle mr-2">
                            <input type="checkbox" id="isView" name="isView" value="Y" <?php if ($resultView == 'Y') echo 'checked' ?>>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <button type="button" class="btn btn-basic">취소</button>
                    <button type="button" class="btn btn-secondary" onclick="saveBtn(event, '<?= $lvl ?>', '<?= $idx ?>')">저장</button>
                </div>
            </form>
        </div>
<?php } ?>



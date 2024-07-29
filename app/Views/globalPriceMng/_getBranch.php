<option value="">지점을 선택하세요.</option>
<?php
if ( $corpList ) {
    foreach ( $corpList as $key => $val )
    {
        $mCorpCode					=	$val['corpCode'];
        $mCodeName					=	$val['corpName'];
        ?>
        <option value="<?=$mCorpCode?>"<? if ( $mCorpCode == $corpCode ) { echo ' selected'; } ?>><?=stripslashes($mCodeName)?></option>
        <?
    }
}
?>
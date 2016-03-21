<?php
$cntSectionId = $arParams['SECTION_ID'];
$cache = new CPHPCache();
$cache_time = 3600;
$cache_id = 'arrLinksFilter'.$cntSectionId;
$cache_path = 'arIBlockListID';
if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)){
   $ress = $cache->GetVars();
   if (is_array($res["arrLinksFilter"]) && (count($ress["arrLinksFilter"]) > 0))
      $arrLinksFilter = $ress["arrLinksFilter"];
}
if( !is_array($arrLinksFilter) ){
	$resDB = CIBlockElement::GetList( Array("SORT"=>"ASC"), Array('IBLOCK_ID'=>27, "ACTIVE"=>"Y"), false, false, Array('PROPERTY_TARGET_ON') );
	$arrLinks = array();
	while ( $res = $resDB->fetch() ) {
		$arrLinks[] = substr(trim($res['PROPERTY_TARGET_ON_VALUE']['TEXT']), 0, -1); 
	}
	$arrLinksFilter = $arrLinks;
	//////////// end cache /////////
	if ($cache_time > 0){
         $cache->StartDataCache($cache_time, $cache_id, $cache_path);
         $cache->EndDataCache(array("arrLinksFilter"=>$arrLinksFilter));
   }
}
?>

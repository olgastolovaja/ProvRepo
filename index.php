public function getProviders($key='ID',$arFilter=array("*"),$arSelect=array("*"),$arSort=array("UF_SORT_ID"=>"ASC"),$pageParams = false)
	{

        if(empty(self::providersHL)) return false;
        $arResult = false;

		$this->HLload(self::providersHL);
		$arResult = false;
	    $obCache = new CPHPCache;
        $life_time = 3600;
        $cache_params = $arFilter;
        $cache_params['key']=$key;
        $cache_params['func']='getProviders';
        $cache_params['arSelect']=$arSelect;
        $cache_params['sort']=$arSort;
        $cache_params['pageParams']=$pageParams;
        $cache_id = md5(serialize($cache_params));
        if($obCache->InitCache($life_time, $cache_id, "/")) :
            $arResult = $obCache->GetVars();
        else :
	        $res = $this->strEntityDataClass::getList(array(
	            'select' => $arSelect,
	         	'order'  => $arSort,
	         	'filter' => $arFilter
	        ));

		    while ($arItem = $res->fetch()) {
		        $arResult[$arItem[$key]] = $arItem;
		    }
        endif;
 
        if($obCache->StartDataCache()):
            $obCache->EndDataCache($arResult);
        endif;
 
        return $arResult;
	}

	public function delProviders($id)
	{
		if(empty(self::providersHL)) return false;
		if(empty($id)) return false;
        $arResult = false;
		$this->HLload(self::providersHL);
		$this->strEntityDataClass::delete($id);

	}

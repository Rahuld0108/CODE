<?php
/* src/View/Helper/OptionsDataHelper.php */
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class OptionsDataHelper extends Helper
{   
    /***
     *
     *  $asDistrictList = district_list($state_id);
        $asDistrictOptionList = district_list_toOption($asDistrictList, $_SESSION['trainig_provider']['district_name']);
        <select name="location_search" id="country_id" class="form-select search-location training-provider-district">
            			' . $asDistrictOptionList . '
        </select>
     *
     */
    
    public function district_list_toOption($asDistrictlist = array(), $selectedDistrictId = 0) {
        $ssOptionList = "";
        foreach ($asDistrictlist as $snDistrictCode => $ssDistrictName) {
            $ssDistrictName = strtolower($ssDistrictName);
            $ssDistrictName = ucwords($ssDistrictName);

            if ($selectedDistrictId != "" && $selectedDistrictId == $snDistrictCode)
                $ssOptionList .= "<option value='$snDistrictCode' selected>$ssDistrictName</option>";
            else
                $ssOptionList .= "<option value='$snDistrictCode'>$ssDistrictName</option>";
        }
        return $ssOptionList;
    }

      public function city_list_toOption($asDistrictlist = array(), $selectedDistrictId = 0) {
        $ssOptionList = "";
        foreach ($asDistrictlist as $snDistrictCode => $ssDistrictName) {
            $ssDistrictName = strtolower($ssDistrictName);
            $ssDistrictName = ucwords($ssDistrictName);
            if ($selectedDistrictId != "" && $selectedDistrictId == $snDistrictCode)
                $ssOptionList .= "<option value='$snDistrictCode' selected>$ssDistrictName</option>";
            else
                $ssOptionList .= "<option value='$snDistrictCode'>$ssDistrictName</option>";
        }
        return $ssOptionList;
    }
    
    public function state_list_toOption($asStatelist = array(), $selectedStateId = "") {
        $ssOptionList = "";
        foreach ($asStatelist as $snStateCode => $ssStateName) {
            $ssStateName = strtolower($ssStateName);
            $ssStateName = ucwords($ssStateName);
            if ($selectedStateId != "" && $selectedStateId == $snStateCode) {
    
                $ssOptionList .= "<option value='$snStateCode' selected>$ssStateName</option>";
            } else {
                $ssOptionList .= "<option value='$snStateCode'>$ssStateName</option>";
            }
        }
        return $ssOptionList;
    }
    
    public function list_toOption($aslist = array(), $selectedId = "") {
        $ssOptionList = "";
		
        foreach ($aslist as $snCode => $ssName) {
            $ssName = strtolower($ssName);
            $ssName = ucwords($ssName);
            if ($selectedId != "" && $selectedId == $snCode) {
				
                $ssOptionList .= "<option value='$snCode' selected>$ssName</option>";
            } else {
                $ssOptionList .= "<option value='$snCode'>$ssName</option>";
            }
        }
        return $ssOptionList;
    }

    public function list_toOptionDairyYear($selectedId = "") {
        $endYear = 2005;
        $startYear = date('Y');
        $dailryYear = array();
        for($i=$startYear;$i >= $endYear;$i--){
            $dailryYear[$i]=$i;
        }

        $ssOptionList = "";
        foreach ($dailryYear as $snCode => $ssName) {
            if ($selectedId != "" && $selectedId == $snCode) {
                $ssOptionList .= "<option value='$snCode' selected>$ssName</option>";
            } else {
                $ssOptionList .= "<option value='$snCode'>$ssName</option>";
            }
        }
        return $ssOptionList;
    }
	public function Monthlylist_toOptionDairyYear($selectedId = "") {
        $endYear = 2013;
        $startYear = date('Y');
        $dailryYear = array();
        for($i=$startYear;$i >= $endYear;$i--){
            $dailryYear[$i]=$i;
        }

        $ssOptionList = "";
        foreach ($dailryYear as $snCode => $ssName) {
            if ($selectedId != "" && $selectedId == $snCode) {
                $ssOptionList .= "<option value='$snCode' selected>$ssName</option>";
            } else {
                $ssOptionList .= "<option value='$snCode'>$ssName</option>";
            }
        }
        return $ssOptionList;
    }
	
	function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }
        return $bytes;
    }
    public function manPowerMasterData($id)
    {
        $manpowerMasterData = TableRegistry::get('manpower_master');
        $results = $manpowerMasterData->find('all', ['conditions' =>
            ['id' =>$id]])
            ->enableHydration(false)->first();
        return $results;
    }
    
    public function manPowerMasterDataByEmpCode($emp_code)
    {
        $manpowerMasterData = TableRegistry::get('manpower_master');
        $results = $manpowerMasterData->find('all', ['conditions' =>
            ['empcode' =>$emp_code]])
            ->select(['id','ITEM_CODE'])
            ->enableHydration(false)->first();
        return $results;
    }
    
    public function getDesignationData($ITEM_CODE,$work_order_id = NULL)
    {
        
        if(empty($work_order_id))
        {
        $manpowerMasterData = TableRegistry::get('PO_MANPOWER_LINES_DETAILS');
        $results = $manpowerMasterData->find('all', ['conditions' =>
            ['ITEM_CODE' =>$ITEM_CODE]])
            ->enableHydration(false)->first();
        }else{
         $manpowerMasterData = TableRegistry::get('PO_MANPOWER_LINES_DETAILS');
         $results = $manpowerMasterData->find('all', ['conditions' =>
            ['ITEM_CODE' =>$ITEM_CODE,'PO_HEADER_ID'=>$work_order_id]])
            ->enableHydration(false)->first();   
        }
        return $results;
    }
    public function getPostingPlaceData($posting_place_state_id)
    {
        $PostingPlaceData = TableRegistry::get('states');
        $results = $PostingPlaceData->find('all', ['conditions' =>
            ['id' =>$posting_place_state_id]])
            ->enableHydration(false)->first();
        return $results;
    }
    public function departmentByCustIdData($cust_id)
    {
        $departmentByCustIdData = TableRegistry::get('CS_INFO');
        $results = $departmentByCustIdData->find('all', ['conditions' =>
            ['CUSTOMER_ID' =>$cust_id]])
            ->enableHydration(false)->first();
        return $results;
    }

    public function vendorDetailsByWorkOrder($work_order_id)
    {
        $vendorData = TableRegistry::get('PO_PN_VENDOR_DETAILS');
        $results = $vendorData->find('all', ['conditions' =>
            ['PO_HEADER_ID' =>$work_order_id]])
            ->select(['BILLING_ADDRESS'])
            ->enableHydration(false)->first();
        return $results;
    }
    public function getManPowerLineData($item_code,$work_order_id)
    {
        $poManpowerDetails = TableRegistry::get('PO_MANPOWER_LINES_DETAILS');
        $results = $poManpowerDetails->find('all', ['conditions' =>
            ['PO_HEADER_ID' =>$work_order_id,'ITEM_CODE'=>$item_code]])
            ->select(['V_IGST_PER','V_CGST_PER','V_SGST_PER'])
            ->enableHydration(false)->first();
           
        return $results;
    }
    public function getWagesManpowerDetails($mpr_id,$wages_id,$emp_code=NULL,$item_code)
    {
        $wagesManPowerDetails = TableRegistry::get('wages_manpower_details');
        if(!empty($emp_code)){
        $results = $wagesManPowerDetails->find('all', ['conditions' =>
            ['mpr_id' =>$mpr_id,'wages_id'=>$wages_id,'emp_code'=>$emp_code,'ITEM_CODE'=>$item_code]])
            ->select(['vendor_margin','min_ctc','salary_paid','ITEM_UNIT_PRICE'])
            ->enableHydration(false)->first();
        }else{
        $results = $wagesManPowerDetails->find('all', ['conditions' =>
            ['mpr_id' =>$mpr_id,'wages_id'=>$wages_id,'ITEM_CODE'=>$item_code]])
            ->select(['vendor_margin','min_ctc','salary_paid','ITEM_DESCRIPTION','ITEM_UNIT_PRICE'])
            ->enableHydration(false)->first();    
        }
           
        return $results;
    }
}
<?

/*if (isset ($_GET['type'])){ 
	switch ($_GET['type']) { 
		case 'pda': 
				define('siteType','pda'); 
				break; 
		default: 
			
				define('siteType','original'); 
							} 
						} */

if (isset ($_GET['type'])){ 
switch ($_GET['type']) { 
case 'pda': 
setcookie('siteType', 'pda', time()+3600*24*30,'/'); 
define('siteType','pda'); 
break; 
 
default: 
setcookie('siteType', 'original', time()+3600*24*30,'/'); 
define('siteType','original'); 
} 
} 
else{ 
$checkType=''; 
if (isset($_COOKIE['siteType'])) $checkType=$_COOKIE['siteType']; 
switch ($checkType) { 
case 'pda': 
define('siteType','pda'); 
break; 
 
default: 
define('siteType',''); 
} 
}
						
				
					//-- Добавление обработчика события

AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");
/*AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "aaa1"); 
function aaa1(&$arFields){
 unset($arFields['DETAIL_PICTURE']['COPY_FILE']);
 unset($arFields['PREVIEW_PICTURE']['COPY_FILE']);
  return $arFields;
} */
//-- Собственно обработчик события

function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
  $arOrder = CSaleOrder::GetByID($orderID);
  
  //-- получаем телефоны и адрес
  $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
  $phone="";
  $index = ""; 
  $country_name = "";
  $city_name = "";  
  $address = "";
  while ($arProps = $order_props->Fetch())
  {
    if ($arProps["CODE"] == "PHONE")
    {
       $phone = htmlspecialchars($arProps["VALUE"]);
    }
    if ($arProps["CODE"] == "LOCATION")
    {
        $arLocs = CSaleLocation::GetByID($arProps["VALUE"]);
        $country_name =  $arLocs["COUNTRY_NAME_ORIG"];
        $city_name = $arLocs["CITY_NAME_ORIG"];
    }

    if ($arProps["CODE"] == "INDEX")
    {
      $index = $arProps["VALUE"];   
    }

    if ($arProps["CODE"] == "ADDRESS")
    {
      $address = $arProps["VALUE"];
    }
  }

  $full_address = $index.", ".$country_name."-".$city_name.", ".$address;

  //-- получаем название службы доставки
  $arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
  $delivery_name = "";
  if ($arDeliv)
  {
    $delivery_name = $arDeliv["NAME"];
  }

  //-- получаем название платежной системы   
  $arPaySystem = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
  $pay_system_name = "";
  if ($arPaySystem)
  {
    $pay_system_name = $arPaySystem["NAME"];
  }

  //-- добавляем новые поля в массив результатов
  $arFields["ORDER_DESCRIPTION"] = $arOrder["USER_DESCRIPTION"]; 
  $arFields["PHONE"] =  $phone;
  $arFields["DELIVERY_NAME"] =  $delivery_name;
  $arFields["PAY_SYSTEM_NAME"] =  $pay_system_name;
  $arFields["FULL_ADDRESS"] = $full_address;   
}
/*if (isset ($_GET['type'])){ 
	switch ($_GET['type']) { 
		case 'pda': setcookie('siteType', 'pda', time()+3600*24*30,'/'); 
				define('siteType','pda'); 
				break; 
		default: 
			setcookie('siteType', 'original', time()+3600*24*30,'/'); 
				define('siteType','original'); 
							} 
						} 
				else{ 
$checkType=''; if (isset($_COOKIE['siteType'])) $checkType=$_COOKIE['siteType']; 
			switch ($checkType) { 
					case 'pda': define('siteType','pda'); break; 
					case 'original': define('siteType','original'); break; 
					default: define('siteType',''); 
								} 
					} */
?>
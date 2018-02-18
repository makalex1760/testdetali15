<?include($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
__IncludeLang(dirname(__FILE__).'/lang/'.LANGUAGE_ID.'/template.php');


CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iarga.cleverbasket");
$ev = new CEvent;

// Check properties and extract important fields
// We need some vars to create order

$email = '';
$location = '';
$username = '';
$delivery = $_POST['delivery'];
$payment = $_POST['paytype'];
$phone = '';
print_r($delivery);
$list = CSaleOrderProps::GetList(array(),array("PERSON_TYPE_ID"=>$_POST['PERSON_TYPE']));
while($prop = $list->GetNext()) if(isset( $_POST['prop_'.$prop['ID']])){
	if($prop['TYPE']=='LOCATION'){		
		$location = $_POST['prop_'.$prop['ID']];
	}elseif($prop['IS_NAME']=='Y'){
		$username = $_POST['prop_'.$prop['ID']];
	}elseif($prop['IS_EMAIL']=='Y'){
		$email = $_POST['prop_'.$prop['ID']];
		if($prop['REQUIED']=='Y') $emailreq = true;
	}elseif($prop['REQUIED']=='Y' &&  $_POST['prop_'.$prop['ID']]==''){
		$errors[] = GetMessage('FILL_FIELD').' &laquo;'.$prop['NAME'].'&raquo;';
	}
	if(preg_match("#phone#i",$prop['CODE'])){
		$phone =  $_POST['prop_'.$prop['ID']];
		if($prop['REQUIED']=='Y') $phonereq = true;
	}
	if($prop['CODE']!='EMAIL') $userArr[$prop['CODE']] =  $_POST['prop_'.$prop['ID']];
}

//if($email=='' && !$emailreq) $errors[] = GetMessage('ENTER_EMAIL');
if($email!='' && !check_email($email)) $errors[] = GetMessage('ENTER_CORRECT_EMAIL');
elseif($email=='') $email = $phone."@".$_SERVER['SERVER_NAME'];

$phone_chk = preg_replace("#[^0-9]#","",$phone);
if($phone!='' && strlen($phone_chk)<5) $errors[] = GetMessage('PHONE_TOO_SHORT');
elseif($phone!=''  && strlen($phone_chk)>13) $errors[] = GetMessage('PHONE_TOO_LONG');
elseif($phone!=''  && preg_match("#[^0-9\-\s\+\(\)]#",$phone_chk)) $errors[] = GetMessage('PHONE_NO_LETTERS');

if($location=='' && $isloc!="") $errors[] = GetMessage('SELECT_CITY');
elseif($delivery=='')  $errors[] = GetMessage('SELECT_DELIVERY');
elseif($payment=='')  $errors[] = GetMessage('SELECT_PAYMENT');

if(CSaleBasket::GetList(array(),array("ORDER_ID"=>"NULL","FUSER_ID"=>CSaleBasket::GetBasketUserID()))->selectedRowsCount() < 1) $errors[] = GetMessage('EMPTY_BASKET');

if(sizeof($errors) > 0){
	print 'error ';
	foreach($errors as $error) print $error.'<br>';
}else{
	global $USER;
	if($USER->IsAuthorized()){
		$user = $USER->GetID();
	}else{
		$usr = $USER->GetByLogin($email)->GetNext();
		
			$pass = rand(11111111,99999999);
			$id = $USER->Add(Array("LOGIN"=>$pass,"EMAIL"=>$email,"PASSWORD"=>$pass,"CONFIRM_PASSWORD"=>$pass));
			print $USER->LAST_ERROR;
			$USER->Authorize($id);
			$user = $id;
			/*CEvent::Send("NEWUSER",SITE_ID,Array(
				"FIO"=>$username,	
				"EMAIL"=>$email,
				"PHONE"=>$phone,
				"PASS"=>$pass,
			));*/
			$usr = $USER->GetByID($id)->GetNext();
		
			
				 $USER->Authorize($usr['ID']);
// Update user info from order with similar fields				 
		$USER->Update($USER->GetID(),$userArr);			
	
	}

		
			
	$price = 0;
	$arSelFields = array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT", "NAME", "CURRENCY", "CATALOG_XML_ID", "VAT_RATE", "NOTES", "DISCOUNT_PRICE");
	
	$list = CSaleBasket::GetList(array("ID"=>"DESC"),array("ORDER_ID"=>"NULL","FUSER_ID"=>CSaleBasket::GetBasketUserID()),false,false,$arSelFields);
	while($el=$list->GetNext()){
		$price += $el['PRICE']*$el['QUANTITY'];	
		$vat += ($el['PRICE'] - $el['PRICE'] / (1+$el['VAT_RATE'])) * $el['QUANTITY'];	
		$vat_rate = $el['VAT_RATE']*100;
	}


	if (CModule::IncludeModule("statistic")) $arFields["STAT_GID"] = CStatistic::GetEventParam();

	$order = new CSaleOrder;
	$disc = 0;//$price / (1-getDiscount()/100)-$price;
	if($price >= 0){
		// Рассчитываем параметры
		$dt = Array("ID"=>$_POST['delivery'],"PRICE"=>(int) $_POST['delivery_price']);
		$pt = CSalePersonType::GetList(Array("SORT"=>"ASC"),Array("ID"=>$_POST['PERSON_TYPE']))->GetNext();
		$ps = CSalePaySystem::GetByID($payment,$pt['ID']);
		$ps1 = CSalePaySystem::GetByID($payment);
		
		$groups = 'Groups: ';
		$arr = $USER->GetUserGroupArray();
		foreach($arr as $gid){
			$g = CGroup::GetById($gid)->GetNext();
			$groups .= ' '.$g['NAME'];
		}
		//print 'error '; print_r($dt); die();

		// Проценты поправки для оплаты с комиссией
		$proc = 1;
		$procArr = Array();
		if($_SERVER['SERVER_NAME']=="www.nachisto.ru") $procArr = Array(5=>3);
		if(isset($procArr[$ps['ID']])) $proc = 1+($procArr[$ps['ID']]/100);
		$dt['PRICE'] = $dt['PRICE'] * $proc;
		$price = $price * $proc;

		// Заполняем параметры
		$orderVals = array(
				'LID'=>SITE_ID ,// - код сайта, на котором сделан заказ; 
				'PERSON_TYPE_ID'=>$_POST['PERSON_TYPE'] ,// - тип плательщика, к которому принадлежит посетитель, сделавший заказ (заказчик); 
				'PAYED'=>'N' ,// - флаг (Y/N) оплачен ли заказ; 
				//'DATE_PAYED'=>'' ,// - дата оплаты заказа; 
				//'EMP_PAYED_ID'=>'' ,// - код пользователя (сотрудника магазина), который установил флаг оплаченности; 
				//'CANCELED'=>'' ,// - флаг (Y/N) отменён ли заказ; 
				//'DATE_CANCELED'=>'' ,// - дата отмены заказа; 
				//'EMP_CANCELED_ID'=>'' ,// - код пользователя, который установил флаг отмены заказа; 
				//'REASON_CANCELED'=>'' ,// - текстовое описание причины отмены заказа; 
				'STATUS_ID'=>'N' ,// - код статуса заказа; 
				//'EMP_STATUS_ID'=>'' ,// - код пользователя (сотрудника магазина), который установил текущий статус заказа; 
				'PRICE_DELIVERY'=>$_COOKIE['delivery_price'] ,// - стоимость доставки заказа; 
				'ALLOW_DELIVERY'=>'Y' ,// - флаг (Y/N) разрешена ли доставка (отгрузка) заказа; 
				//'DATE_ALLOW_DELIVERY'=>'' ,// - дата, когда была разрешена доставка заказа; 
				//'EMP_ALLOW_DELIVERY_ID'=>'' ,// - код пользователя (сотрудника магазина), который разрешил доставку заказа; 
				'PRICE'=>$price+$_COOKIE['delivery_price']+$proc-$_SESSION['discount_summ'] ,// - общая стоимость заказа; 
				'CURRENCY'=>'RUB' ,// - валюта стоимости заказа; 
				'DISCOUNT_VALUE'=>$_SESSION['discount_summ'] ,// - общая величина скидки; 
				'USER_ID'=>$user ,// - код пользователя заказчика; 
				'PAY_SYSTEM_ID'=>$ps['ID'] ,// - платежная система, которой (будет) оплачен заказа; 
				'DELIVERY_ID'=>$delivery ,// - способ (служба) доставки заказа; 
				//'USER_DESCRIPTION'=>'' ,// - описание заказа заказчиком; 
				'ADDITIONAL_INFO'=>$groups ,// - дополнительная информация по заказу; 
				'COMMENTS'=>$_POST['description'] ,// - произвольные комментарии; 
				'TAX_VALUE'=>$vat ,// - общая сумма налогов; 
				//'STAT_GID'=>'' ,// - параметр события в статистике; 
				//'PS_STATUS'=>'' ,// - флаг (Y/N) статуса платежной системы'=>'' ,// - успешно ли оплачен заказ (для платежных систем, которые позволяют автоматически получать данные по проведенным через них заказам); 
				//'PS_STATUS_CODE'=>'' ,// - код статуса платежной системы (значение зависит от системы); 
				//'PS_STATUS_DESCRIPTION'=>'' ,// - описание результата работы платежной системы; 
				//'PS_STATUS_MESSAGE'=>'' ,// - сообщение от платежной системы; 
				//'PS_SUM'=>'' ,// - сумма, которая была реально оплачена через платежную систему; 
				//'PS_CURRENCY'=>'' ,// - валюта суммы; 
				//'PS_RESPONSE_DATE'=>'' ,// - дата получения статуса платежной системы; 
				//'SUM_PAID'=>'' ,// - сумма, которая уже была оплачена покупателем по данному счету (например, с внутреннего счета); 
				//'PAY_VOUCHER_NUM'=>'' ,// - номер платежного поручения; 
				//'PAY_VOUCHER_DATE'=>''// - дата платежного поручения. 
				'COMMENTS'=> $cityname

		);

		
		
		$orderId = $order->Add($orderVals);
		$orderVals['ID'] = $orderId;
		$GLOBALS["SALE_INPUT_PARAMS"] = $orderVals;
		$GLOBALS["SALE_INPUT_PARAMS"]['ORDER'] = $orderVals;

		// Собираем свойства для платёжной системы
		$userArr = CUser::GetById($USER->GetID())->GetNext();
		$params = unserialize($ps['PSA_PARAMS']);
		$orderVals['SHOULD_PAY'] = $price+$dt['PRICE'];
		$GLOBALS["SALE_CORRESPONDENCE"] = $params;
		foreach($params as $key=>$val){
			if($val['TYPE']==''){
				$val['TYPE'] = 'OTHER';
				$GLOBALS["SALE_INPUT_PARAMS"][$val['TYPE']][$val['VALUE']] = $val['VALUE'];
			}elseif($val['TYPE']=='ORDER'){
				$GLOBALS["SALE_INPUT_PARAMS"][$val['TYPE']][$val['VALUE']] = $orderVals[$val['VALUE']];
			}elseif($val['TYPE']=='USER'){
				$GLOBALS["SALE_INPUT_PARAMS"][$val['TYPE']][$val['VALUE']] = $userArr[$val['VALUE']];
			}elseif($val['TYPE']=='PROPERTY'){
				$GLOBALS["SALE_INPUT_PARAMS"][$val['TYPE']][$val['VALUE']] = $_POST[$val['VALUE']];
			}
			$GLOBALS["SALE_CORRESPONDENCE"][$key] = $val;
		}
		//$errors[] = ' ';		print_r($params);		die();


		if($orderId>0){
			// НДС
			if($vat > 0){
				$arF = array(
				   "ORDER_ID" => $orderId,
				   "TAX_NAME" => "НДС",
				   "IS_PERCENT" => "Y",
				   "VALUE" => $vat_rate,
				   "VALUE_MONEY" => $vat,
				   "APPLY_ORDER" => 300,
				   "IS_IN_PRICE" => "Y",
				   "CODE" => "NDS"
				);
				CSaleOrderTax::Add($arF);
			}
			//Заполняем параметры заказа
			$list = CSaleOrderProps::GetList(array(),array());
			
			while($prop = $list->GetNext()){ 
				if( $_POST['prop_'.$prop['ID']]!=""){ 	
					if($prop['IS_LOCATION']=='Y'){
						CSaleOrderPropsValue::Add(array("ORDER_ID"=>$orderId,"ORDER_PROPS_ID"=>$prop['ID'],"NAME"=>$prop['NAME'],"CODE"=>$prop['CODE'],"VALUE"=>$location));
					}else{ 
					$ss=CSaleOrderPropsValue::Add(array("ORDER_ID"=>$orderId,"ORDER_PROPS_ID"=>$prop['ID'],"NAME"=>$prop['NAME'],"CODE"=>$prop['CODE'],"VALUE"=> $_POST['prop_'.$prop['ID']]));
					//_c($prop['CODE']);_c($_POST['prop_'.$prop['ID']]);_c($ss);
					}
				}
				//if($prop[CODE]=="sms"&&)
					
			}

			$list = CSaleBasket::GetList(array("ID"=>"DESC"),array("ORDER_ID"=>"NULL","FUSER_ID"=>CSaleBasket::GetBasketUserID()));
			while($el=$list->GetNext()){
				CSaleBasket::Update($el['ID'],Array("ORDER_ID"=>$orderId));
			}
			$USER->Update($user, Array("PERSONAL_PHONE"=>$phone));

			// Оплатим бонусами
			if($_POST['bonuses']!=''){
				$arOrder = CSaleOrder::GetByID($orderId);
				$withdrawSum = CSaleUserAccount::Withdraw(
						$arOrder["USER_ID"],
						$arOrder["PRICE"],
						$arOrder["CURRENCY"],
						$arOrder["ID"]
					);

				if ($withdrawSum > 0)
				{
					$arFields = array(
							"SUM_PAID" => $withdrawSum,
							"USER_ID" => $arOrder["USER_ID"]
						);
					CSaleOrder::Update($arOrder["ID"], $arFields);

					if ($withdrawSum == $arOrder["PRICE"])
						CSaleOrder::PayOrder($arOrder["ID"], "Y", False, False);

					$orderVals = CSaleOrder::GetByID($orderId);
					$GLOBALS["SALE_INPUT_PARAMS"] = $orderVals;
					$GLOBALS["SALE_INPUT_PARAMS"]['ORDER'] = $orderVals;
				}
			}

			// Формируем сообщение о списке товаров
			$maillist = '';
			$smslist = GetMessage('ORDER_CONSIST')." \r\n";
			CModule::IncludeModule("iblock");
			$list = CSaleBasket::GetList(Array(),Array("ORDER_ID"=>$orderId));

			while($el = $list->GetNext()){
					$summ = round($el['QUANTITY'] * $el['PRICE'], 2);
					$total += $summ;
					$prod = CIBlockElement::GetById($el['PRODUCT_ID'])->GetNext();

					$maillist .= $prod['NAME']. '( http://'.$_SERVER['SERVER_NAME'].''.$prod['DETAIL_PAGE_URL'].' ) '.iarga::prep($el['PRICE'],0).' * '.iarga::prep($el['QUANTITY'],0).' = '.iarga::prep($summ,0).'
';
					$smslist .= $prod['NAME'].GetMessage('IN_NUM')." ".$el['QUANTITY']." ".GetMessage("IN_PRICE")." ".$el['PRICE']."
";
			}
			$total += $delivery_price;
			//_c($total);
			$maillist .= GetMessage('TOTAL').' '.iarga::prep($total,0);

			/* Enable if type is HTML
			$maillist = '<table style="font:14px Tahoma;" cellpadding="4">
				<tr>
					<td colspan="3"><b>'.GetMessage('ORDER_CONSIST').'</b></td>
				</tr>
				<tr>
					<td>'.GetMessage('GOOD_NAME').'</td>
					<td>'.GetMessage('PRICE').'</td>
					<td>'.GetMessage('QUANTITY').'</td>
					<td>'.GetMessage('SUMM').'</td>
				</tr>';
			$smslist = GetMessage('ORDER_CONSIST')." \r\n";
			CModule::IncludeModule("iblock");
			$list = CSaleBasket::GetList(Array(),Array("ORDER_ID"=>$orderId));

			while($el = $list->GetNext()){
					$summ = round($el['QUANTITY'] * $el['PRICE'], 2);
					$total += $summ;
					$prod = CIBlockElement::GetById($el['PRODUCT_ID'])->GetNext();

					$maillist .= '<tr>'.
						'<td><a href="http://'.$_SERVER['SERVER_NAME'].''.$prod['DETAIL_PAGE_URL'].'">'.$prod['NAME'].'</a></td>'.
						'<td>'.iarga::prep($el['PRICE']).'</td>'.
						'<td>'.iarga::prep($el['QUANTITY']).'</td>'.
						'<td>'.iarga::prep($summ).'</td>'.
					'</tr>';
					$smslist .= $prod['NAME'].GetMessage('IN_NUM')." ".$el['QUANTITY']." ".GetMessage("IN_PRICE")." ".$el['PRICE']." \r\n";
			}
			$maillist .= '	<tr>
					<td colspan="3"><b>'.GetMessage('TOTAL').'</b></td>
					<td colspan="1"><b>'.iarga::prep($total).'</b></td>
						</tr>
					</table>';
			*/
			// Отправляем письмо
			_c($email);
			CEvent::Send("SALE_NEW_ORDER_NEW",SITE_ID,Array(
				"ORDER_ID"=>$orderId,
				"ORDER_USER"=>$_POST['FIO'],
				"ORDER_DATE"=>date("d.m.Y"),
				"PRICE"=>$price,
				"EMAIL"=>$email,
				"PHONE"=>$phone,
				"ORDER_PHONE"=>$phone,
				"DELIVERY_ADR"=>$_POST['comm'],
				"COMMENTS"=>$_POST['comm'],
				"SALE_EMAIL"=>"shop@auto-open.ru"
				//"ORDER_LIST"=>$maillist
				//"BCC"=>COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME)
			));

			// Отправляем СМС
			$admin = CUser::GetList(($sort="id"),($name="asc"),Array("LOGIN"=>"admin"))->GetNext();
			$phones = Array($admin['PERSONAL_PHONE']);
			
			//$admin = Array("PERSONAL_PHONE"=>"+7903");
			$message = GetMessage('NEW_ORDER_ON_SITE')." ".$SERVER_NAME.".  ".GetMessage('ORDERER').": ".$username."  ".GetMessage('PHONE').": ".$phone." ".$smslist."  ".GetMessage('ORDER_SUMM')." ".iarga::prep($price);
		// Отправка смс	
		_c($_POST['prop_22']);
		if($_POST['prop_22']||$_POST['prop_23'])
		{ 
_c($phone);
			if(CModule::IncludeModule("imaginweb.sms"))
				{

		$str="Здравствуйте, ".$_POST['prop_1']."! Ваш заказ № ".$orderId.", сумма ".$total." руб. принят. +7(495)565-3831";
		
	//	_c($str);
        $sms1 = new CIWebSMS;
        $sms1->Send($phone,$str);
        print_r($sms1->return_mess);
		
		_c($sms1->return_mess);

				} 
		}		
			/*CModule::IncludeModule("rarus.sms4b");
			foreach($phones as $phone){
				if ($SMS4B->SendSMS($message,$phone)){
					$arResult["RESULT_MESSAGE"]["TYPE"] = "OK";
					$arResult["RESULT_MESSAGE"]["MESSAGE"] = GetMessage("OK"); 
				}
			}*/
			
			print "success  redirect:".$_POST['order_redirect_ia']."?ORDER_ID=".$orderId;
			if ($withdrawSum > 0 && $withdrawSum == $arOrder["PRICE"]){
				//print 'redirect:/basket/bonus/'.$orderId.'/';
			}else{
				//print 'redirect:/basket/success/'.$orderId.'/';
			}
		}else{
			print "error ".$order->LAST_ERROR;
		}		
	}
}
?>
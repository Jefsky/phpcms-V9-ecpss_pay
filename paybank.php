<?php
    //密钥,请把网关号对应的密钥在这里填写
     //$signKey  = "h46f42t8";

    //关闭所有警告
    error_reporting(E_ALL & ~E_NOTICE);
    //参数处理
    if(!isset($_POST) || empty($_POST)) {
        $_POST = $_GET;
    }
    if(!isset($_POST) || !isset($_POST['CardPAN']) || !isset($_POST['CardBank']) || !isset($_POST['BillNo']) || !isset($_POST['ReturnURL'])) {
        header("Location: ../index.php");
        exit();
    }

    //加载函数文件
    $fun_file = dirname(__FILE__) . "/fun_pay.php";
    if (file_exists($fun_file)) {
        include($fun_file);
    }else {
        die('File include failue !');
    }

    // 其他信息
   $brower           = getBrowser() == '' ? $_POST["brower"] : getBrowser();
    $browerLang       = getBrowserLang() == '' ? $_POST["browerLang"] : getBrowserLang();
    //$ip               = empty($_POST["ip"]) ? get_client_ip() : $_POST["ip"];
	$ip               = get_client_ip();

    $acceptLang       = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    $userAgent        = $_SERVER['HTTP_USER_AGENT'];
    $webSite          = $_SERVER['HTTP_HOST'];

    //设置cookie
    $newCookie        = 'billCountry='.$_POST['country'];
    $newCookie       .= '&email='.$_POST['email'];
    $newCookie       .= '&timeZone='.$_POST['timeZone'];
    $newCookie       .= '&orderNo='.$_POST['BillNo'];
    $newCookie       .= '&lang='.$browerLang;
    $newCookie       .= '&ip='.$ip;


 


    $oldCookie = '';
    if(isset($_COOKIE['CARD_PAY_COOKIE'])) {
        $oldCookie   = $_COOKIE['CARD_PAY_COOKIE'];
    }
    $newCookie = $newCookie .  (empty($oldCookie) ? "" : '$$' . $oldCookie);
    setcookie("CARD_PAY_COOKIE", $newCookie, time()+2147483647);

	$Btype='';
		$crno=$_POST['CardPAN'];
		 if($crno!=""){
			$no=substr($crno,0,2);
			 if($no=="30"||$no=="35"&&strlen($crno)==16){
				$Btype="3";
			 }
			 $no=substr($crno,0,1);
			 if($no=="4"&&strlen($crno)==16){
				$Btype="4";
			 }
			 $no=substr($crno,0,1);
			 if($no=="5"&&strlen($crno)==16){
					$Btype="5";
			 }
		 } 
	$CardNo=base64_encode(urlencode($_POST['CardPAN']));
	    $Cvv=base64_encode(urlencode($_POST['CVV2']));
	    $ExpireYear=base64_encode(urlencode($_POST['ExpirationYear']));
	    $ExpireMonth=base64_encode(urlencode($_POST['ExpirationMonth']));


   /* $signSrc= $_POST['merNo'].$_POST['gatewayNo'].$_POST['orderNo'].$_POST['orderCurrency'].$_POST['orderAmount'].
        $_POST['firstName'].$_POST['lastName'].$_POST['CardPAN'].$_POST['ExpirationYear'].
        $_POST['ExpirationMonth'].$_POST['CVV2'] .$_POST['email'].$signKey;
    $signInfo= hash('sha256', $signSrc);

    $data = array(
        'newcardtype'            => $Btype,
        'MerNo'        => $_POST['MerNo'],
        'cardnum'          => $CardNo,
        'cvv2'      => $Cvv,
        'month'    => $ExpireMonth,
        'year'          => $ExpireYear,
        'cardbank'        => $_POST['CardBank'],
        'BillNo'         => $_POST['BillNo'],
        'Amount'            => $_POST['Amount'],
        'Currency'            => $_POST['Currency'],
        'Language'              => $_POST['Language'],
        'MD5info'          => $_POST['MD5info'],
        'ReturnURL'             => $_POST['ReturnURL'],
        'Remark'            => $_POST['Remark'],
        'firstname'          => $_POST['firstname'],
        'lastname'    => $_POST['lastname'],
        'email'     => $_POST['email'],
        'phone'        => $_POST['phone'],
        'zipcode'        => $_POST['zipcode'],
        'address'      => $_POST['address'],
        'city'        => $_POST['city'],
        'state'         => $_POST['state'],
        'country'      => $_POST['country'],
        'shippingFirstName'          => $_POST['shippingFirstName'],
        'shippingLastName'        => $_POST['shippingLastName'],
        'shippingEmail'        => $_POST['shippingEmail'],
        'shippingPhone'         => $_POST['shippingPhone'],
        'shippingZipcode'           => $_POST['shippingZipcode'],
        'shippingAddress' => $_POST['shippingAddress'],
        'shippingCity'  => $_POST['shippingCity'],
        'shippingSstate'   => $_POST['shippingSstate'],
        'shippingCountry'      => $_POST['shippingCountry'],
        'products'          => $_POST['products'],
        'ip'               => $ip,
        'agentinfo'           => $_SERVER['HTTP_USER_AGENT'],
        'version'       => 'new prestashop1.25',
        'oldCookie'        => string_replace($oldCookie),
        'newCookie'        => string_replace($newCookie)
   
        
    );
    */

	 if(!isset($_POST['firstname']) || empty($_POST['firstname'])||!isset($_POST['lastname']) || empty($_POST['lastname'])||!isset($_POST['email']) || empty($_POST['email'])||!isset($_POST['phone']) || empty($_POST['phone'])||!isset($_POST['zipcode']) || empty($_POST['zipcode'])||!isset($_POST['address']) || empty($_POST['address'])||!isset($_POST['city']) || empty($_POST['city'])||!isset($_POST['state']) || empty($_POST['state'])||!isset($_POST['country']) || empty($_POST['country'])) {
        echo "<script type='text/javascript'> alert('Billing information is not completely!!');window.location.href='../index.php'</script>";
        exit();
    }
 	 if(!isset($_POST['shippingFirstName']) || empty($_POST['shippingFirstName'])||!isset($_POST['shippingLastName']) || empty($_POST['shippingLastName'])||!isset($_POST['shippingEmail']) || empty($_POST['shippingEmail'])||!isset($_POST['shippingPhone']) || empty($_POST['shippingPhone'])||!isset($_POST['shippingZipcode']) || empty($_POST['shippingZipcode'])||!isset($_POST['shippingAddress']) || empty($_POST['shippingAddress'])||!isset($_POST['shippingCity']) || empty($_POST['shippingCity'])||!isset($_POST['shippingSstate']) || empty($_POST['shippingSstate'])||!isset($_POST['shippingCountry']) || empty($_POST['shippingCountry'])) {
        echo "<script type='text/javascript'> alert('Shipping information is not completely!');window.location.href='../index.php'</script>";
        exit();
    }


	$process_button_string="newcardtype=".$Btype.
		"&MerNo=".$_POST['MerNo'].
		"&MD5info=".$_POST['MD5info'].
		"&cardnum=".$CardNo.
		"&cvv2=".$Cvv.
		"&month=".$ExpireMonth.
	    "&year=".$ExpireYear.
		"&cardbank=".$_POST['CardBank'].
		"&BillNo=".$_POST['BillNo'].
		"&Amount=".$_POST['Amount'].
		"&DispAmount=".$_POST['Amount'].
		"&Currency=".$_POST['Currency'].
		"&Language=".$_POST['Language'].
		"&ReturnURL=".$_POST['ReturnURL'].
		"&Remark=".$_POST['Remark'].
		"&firstname=".$_POST['firstname'].
		"&lastname=".$_POST['lastname'].
		"&email=".$_POST['email'].
		"&phone=".$_POST['phone'].
		"&zipcode=".$_POST['zipcode'].
		"&address=".$_POST['address'].
		"&city=".$_POST['city'].
		"&state=".$_POST['state'].
		"&country=".$_POST['country'].
		"&shippingFirstName=".$_POST['shippingFirstName'].
		"&shippingLastName=".$_POST['shippingLastName'].
		"&shippingEmail=".$_POST['shippingEmail'].
		"&shippingPhone=".$_POST['shippingPhone'].
		"&shippingZipcode=".$_POST['shippingZipcode'].
		"&shippingAddress=".$_POST['shippingAddress'].
		"&shippingCity=".$_POST['shippingCity'].
		"&shippingSstate=".$_POST['shippingSstate'].
		"&shippingCountry=".$_POST['shippingCountry'].
		"&products=".$_POST['products'].
		"&ip=".$ip.
			"&agentinfo=".$_SERVER['HTTP_USER_AGENT'].
		"&version="."new prestashop1.25";


  // $result=curlPost('http://www.lovopay.com/innerpay',$process_button_string);
  $result=curlPost('https://fast.themoredo.com/innerPayment',$process_button_string);
 //echo $process_button_string.'-----------------------------'.$result;
 //exit();
   // $result=payment_submit('http://fast.themoredo.com:5528/innerPayment',http_build_query($data, '', '&'));
    if(!isset($result) || empty($result)) {
        echo "<script type='text/javascript'> alert('Payment exception,please contact the shop owner !');window.location.href='../index.php'</script>";
        exit();
    }
	
    /*$payXml = simplexml_load_string($result);

    $merNo         = (string) $payXml->merNo;
    $gatewayNo     = (string) $payXml->gatewayNo;
    $tradeNo       = (string) $payXml->tradeNo;
    $orderNo       = (string) $payXml->orderNo;
    $orderAmount   = (string) $payXml->orderAmount;
    $orderCurrency = (string) $payXml->orderCurrency;
    $orderStatus   = (string) $payXml->orderStatus;
    $orderInfo     = (string) $payXml->orderInfo;
    $signInfo      = (string) $payXml->signInfo;
    $remark        = (string) $payXml->remark;
    $sha256Src     = $merNo.$gatewayNo.$tradeNo.$orderNo.$orderCurrency.$orderAmount.$orderStatus.$orderInfo.$signKey;
    $mysign        = strtoupper(hash("sha256", $sha256Src));
*/
// die($result);
 $splitdata=array();
	  $edata=explode('&',$result);
	  foreach($edata as $key=>$value)
	  {
		$splitdata[$key]= explode('=',$value);
	  }
//获得接口返回数据
$ReturnBillNo =$splitdata[3][1];
$ReturnCurrency = $splitdata[4][1];
$ReturnAmount = $splitdata[5][1];
$ReturnSucceed = $splitdata[6][1];
$ReturnResult = $splitdata[7][1];
$ReturnMD5info=$splitdata[8][1];

$returnUrl=$_POST['ReturnURL'];

    //构建返回地址
    /* $returnParam = 'BillNo='.$ReturnBillNo.'&Currency='.$ReturnCurrency.'&Amount='.$ReturnAmount.'&Succeed='.$ReturnSucceed.
        '&Result='.$ReturnResult.'&MD5info='.$ReturnMD5info;
   if(strstr($_POST['ReturnURL'],"?")){
        $returnUrl = $_POST['ReturnURL'].'&'.$returnParam;
    }else {
        $returnUrl = $_POST['ReturnURL'].'?'.$returnParam;
    }
    header("location: $returnUrl");
	http_post($_POST['ReturnURL'],$returnParam);*


	$vars = array(
      "BillNo" => $ReturnBillNo,
      "Currency"   => $ReturnCurrency,
	   "Amount" => $ReturnAmount,
      "Succeed"   => $ReturnSucceed,
	   "Result" => $ReturnResult,
      "MD5info"   => $ReturnMD5info     
      );
     $client  =& new HTTP_Client();
     $client->post($_POST['ReturnURL'],$vars);
	 $returnParam = 'BillNo='.$ReturnBillNo.'&Currency='.$ReturnCurrency.'&Amount='.$ReturnAmount.'&Succeed='.$ReturnSucceed.
        '&Result='.$ReturnResult.'&MD5info='.$ReturnMD5info;
sock_post($_POST['ReturnURL'], $returnParam);

	function sock_post($url, $query){
		$info = parse_url($url);
		$fp   = fsockopen($info["host"], 80, $errno, $errstr, 3);
		$head = "POST " . $info['path'] . "?" . $info["query"] . " HTTP/1.0rn";
		$head .= "Host: " . $info['host'] . "rn";
		$head .= "Referer: http://" . $info['host'] . $info['path'] . "rn";
		$head .= "Content-type: application/x-www-form-urlencodedrn";
		$head .= "Content-Length: " . strlen(trim($query)) . "rn";
		$head .= "rn";
		$head .= trim($query);
		$write = fputs($fp, $head);
		while (!feof($fp)) {
			$line = fread($fp, 4096);
			echo $line;
		}
	}*/



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script>
    window.onload = function () {
		 document.getElementById("form1").submit();
    }
</script>


</head>

<body>
<form action="<?=$returnUrl?>" method="post"  id="form1" name="E_FORM">

		<input type="hidden" name="BillNo" value="<?=$ReturnBillNo?>" />
		<input type="hidden" name="Currency" value="<?=$ReturnCurrency?>" />
		<input type="hidden" name="Amount" value="<?=$ReturnAmount?>" />
		<input type="hidden" name="Succeed" value="<?=$ReturnSucceed?>" />
		<input type="hidden" name="Result" value="<?=$ReturnResult?>" />
		<input type="hidden" name="MD5info" value="<?=$ReturnMD5info?>" />
	  
</form>
</body>
</html>


		
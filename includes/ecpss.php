    <?php  
    /** 
     * ecpss.php 
     *============================== 
     *汇潮支付插件
     *============================== 
     * by:Jefsky  Jefsky@live.com
     * Nov 30, 2016  
     */  

    // if (!defined('IN_ECS'))
    // {
        // die('Hacking attempt');
    // }

	if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
	 
    $payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/ecpss.php';

    if (file_exists($payment_lang))
    {
        global $_LANG;

        include_once($payment_lang);
    }

    /* 模块的基本信息 */
    if (isset($set_modules) && $set_modules == TRUE)
    {
        $i = isset($modules) ? count($modules) : 0;

        /* 代码 */
        $modules[$i]['code']    = basename(__FILE__, '.php');

        /* 描述对应的语言项 */
        $modules[$i]['desc']    = 'ecpss_desc';

        /* 是否货到付款 */
        $modules[$i]['is_cod']  = '0';

        /* 是否支持在线支付 */
        $modules[$i]['is_online']  = '1';

        /* 作者 */
        $modules[$i]['author']  = 'Qidongit Team - Jefsky';

        /* 网址 */
        $modules[$i]['website'] = 'http://www.qidongit.com';

        /* 版本号 */
        $modules[$i]['version'] = '1.0.0';

        /* 配置信息 */
        $modules[$i]['config']  = array(
            array('name' => 'md5key', 'type' => 'text',   'value' => ''),
            array('name' => 'merno','type' => 'text',   'value' => ''),
            array('name' => 'currency','type' => 'text',   'value' => '1'),
            array('name' => 'language','type' => 'text',   'value' => '2'),
            array('name' => 'firstname','type' => 'text',   'value' => ''),
            array('name' => 'remark','type' => 'text',   'value' => ''),
            array('name' => 'lastname','type' => 'text',   'value' => ''),
            array('name' => 'email','type' => 'text',   'value' => ''),
            array('name' => 'phone','type' => 'text',   'value' => ''),
            array('name' => 'zipcode','type' => 'text',   'value' => ''),
            array('name' => 'address','type' => 'text',   'value' => ''),
            array('name' => 'city','type' => 'text',   'value' => ''),
            array('name' => 'state','type' => 'text',   'value' => ''),
            array('name' => 'country','type' => 'text',   'value' => '')
            
        );

        return;
    }


/**
 * 类
 */
class ecpss
{
    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    
    function __construct()
    {
        $this->ecpss();
    }
	function ecpss()
    {
    }

    /**
     * 提交函数
     */
    function get_code($order, $payment)
    {
		
		$config;
        $pay_url = "/pay.php";  
        $MD5key = $payment['md5key'];		//MD5私钥
        $config['BillNo'] =  $order['order_sn'].strtotime("now");		//[必填]订单号(商户自己产生：要求不重复)
        $config['Amount'] = $order['order_amount'];				//[必填]订单金额

        $config['MerNo'] = $payment['merno'];                                 //商户号，必须  
        $config['orderTime'] = date("YmdHis");                      //请求时间，格式为 YYYYMMDDHHMMSS   
        $config['AdviceURL'] = return_url(basename(__FILE__, '.php'));  
        $config['defaultBankNumber'] = "";  
        $config['Remark'] = $payment['remark'];  
        $config['firstname'] = $payment['firstname'];
        $config['lastname'] = $payment['lastname'];
        $config['email'] = $payment['email'];
        $config['phone'] = $payment['phone'];
        $config['zipcode'] = $payment['zipcode'];
        $config['address'] = $payment['address'];
        $config['city'] = $payment['city'];
        $config['state'] = $payment['state'];
        $config['country'] = $payment['country'];
        $config['Language'] = $payment['language'];

        $config['shippingFirstName'] = $payment['firstname'];
        $config['shippingLastName'] = $payment['lastname'];
        $config['shippingEmail'] = $payment['email'];
        $config['shippingPhone'] = $payment['phone'];
        $config['shippingZipcode'] = $payment['zipcode'];
        $config['shippingAddress'] = $payment['address'];
        $config['shippingCity'] = $payment['city'];
        $config['shippingSstate'] = $payment['state'];
        $config['shippingCountry'] = $payment['country'];
        
          
        $Currency = $payment['currency'];
        $config['Currency'] = $Currency;  
        $ReturnURL = return_url(basename(__FILE__, '.php')); 			//[必填]返回数据给商户的地址(商户自己填写):::注意请在测试前将该地址告诉我方人员;否则测试通不过
        $config['ReturnURL'] = $ReturnURL;

        //md5src = MerNo + BillNo + Currency + Amount + Language + ReturnURL + MD5key
        $md5src = $config['MerNo'].$config['BillNo'].$config['Currency'].$config['Amount'].$config['Language'].$ReturnURL.$MD5key;		//校验源字符串

        $SignInfo = strtoupper(md5($md5src));		//MD5检验结果

        $config['MD5info'] = $SignInfo;  
        

        

        $config['products'] = $order['order_sn'];// '------------------物品信息

        $sHtml = "<form id='ecpssForm' name='ecpssForm' action='".$pay_url."' method='post'>";  
          
        foreach ($config as $key => $val) {  
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";  
        }  
          
        //submit按钮控件请不要含有name属性  
        $sHtml = $sHtml."<input type='submit' value='去支付'></form>";  
          
        $sHtml = $sHtml."<script>document.forms['ecpssForm'].submit();</script>";  
          
        return $sHtml;  
        

    }
        
    

    /**
     * 处理函数
     */
    function response()
    {
		
        if (!empty($_POST))
        {
            foreach($_POST as $key => $data)
            {
                $_GET[$key] = $data;
            }
        }
        //MD5私钥
        $MD5key = $payment['md5key'];

        //商户号
        $MerNo = $_GET["MerNo"];
        //订单号
        $BillNo = $_GET["BillNo"];
        //币种代码
        $Currency = $_GET["Currency"];
        //金额
        $Amount = $_GET["Amount"];
        //支付状态
        $Succeed = $_GET["Succeed"];
        //支付结果
        $Result = $_GET["Result"];
        //取得的MD5校验信息
        $MD5info = $_GET["MD5info"]; 
        //备注
        $Remark = $_GET["Remark"];

        //校验源字符串 MerNo & BillNo & Currency & Amount & Succeed & MD5key
        $md5src = $MerNo.$BillNo.$Amount.$Succeed.$MD5key;
        //MD5检验结果
        $md5sign = strtoupper(md5($md5src));
        
        if ($MD5info==$md5sign){
            if ($Succeed=="88") { 
                return true;
            }
            else 
            {
                return false;
            } 
        }
        else
        {
            return false;
        }

    }
	function test()
	{
		echo "test";
	}

}

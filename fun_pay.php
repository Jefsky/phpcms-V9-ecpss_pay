<?php
    function payment_submit($url,$data){
        //如果网店服务器支持CURL,则调用curl_post方法
        $info = curl_post($url, $data);
        //如果网店服务器不支持CURL,则调用http_post方法
        //$info = http_post($url, $data);
        return $info;
    }


	 function curlPost($url, $data)                                                       
	{    
	 		$ssl = substr($url, 0, 8) == "https://" ? TRUE : FALSE;                        
	        $wesite =$_SERVER['HTTP_HOST'];		   
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL ,$url);
    	    curl_setopt($ch, CURLOPT_POST,1);                                              
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);                                   
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                   
			curl_setopt($ch, CURLOPT_REFERER,$wesite);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);

			 $data = curl_exec($ch);// 执行操作    
			if (curl_errno($ch)) {    
			   // var_dump( 'Errno'.curl_error($ch));    
			}    
	    	curl_close($ch); // 关键CURL会话    
	     	return $data;                                                                  
	}

    function curl_post($url, $data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_PORT, 443);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_TIMEOUT, 300);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $tmpInfo = curl_exec($curl);
        curl_close($curl);

        return $tmpInfo;
    }
    function http_post($url, $post_data){
        $postData = $post_data;
        $options  = array(
            'http' => array(
                'method' => "POST",
                'header' => "Accept-language: en\r\n" . "Cookie: foo=bar\r\n",
                //"Authorization: Basic " . base64_encode("$username:$password").'\r\n',
                'content-type' => "multipart/form-data",
                'content' => $postData,
                'timeout' => 15 * 60
            )
        );
        $context  = stream_context_create($options);
		file_get_contents($url, false, $context);
      //  $result   = file_get_contents($url, false, $context);
       // return $result;
    }
    function get_client_ip(){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $online_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
            $online_ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(isset($_SERVER['HTTP_X_REAL_IP'])){
            $online_ip = $_SERVER['HTTP_X_REAL_IP'];
        }else{
            $online_ip = $_SERVER['REMOTE_ADDR'];
        }
        $ips = explode(",",$online_ip);
        return $ips[0];
    }
    function string_replace($string_before) {
        $string_after = str_replace("\n"," ",$string_before);
        $string_after = str_replace("\r"," ",$string_after);
        $string_after = str_replace("\r\n"," ",$string_after);
        $string_after = str_replace("'","&#39 ",$string_after);
        $string_after = str_replace('"',"&#34 ",$string_after);
        $string_after = str_replace("(","&#40 ",$string_after);
        $string_after = str_replace(")","&#41 ",$string_after);
        return $string_after;
    }
    function getBrowserLang() {
        $acceptLan = '';
        if(isSet($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
            $acceptLan = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $acceptLan = $acceptLan[0];
        }
        return $acceptLan;
    }
    function getBrowser(){
        if(empty($_SERVER['HTTP_USER_AGENT'])){
            return '';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'rv:11.0')){
            return 'IE';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'rv:11.0') ||
            false!==strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 10.0')){
            return 'IE';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 9.0')){
            return 'IE';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 8.0')){
            return 'IE';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
            return 'IE';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
            return 'IE';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')){
            return 'IE';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Firefox')){
            return 'Firefox';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Chrome')){
            return 'Chrome';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Safari')){
            return 'Safari';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Opera') ||
            false!==strpos($_SERVER['HTTP_USER_AGENT'],'OPR')){
            return 'Opera';
        }
        return '';
    }
 ?>
<?php
//关闭所有警告
error_reporting(E_ALL & ~E_NOTICE);

if(!isset($_POST) || empty($_POST)) {
    $_POST = $_GET;
}
if(!isset($_POST) || !isset($_POST['MerNo']) || !isset($_POST['BillNo']) || !isset($_POST['ReturnURL'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML lang=en xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>Details of your order</TITLE>
<META content="text/html; charset=UTF-8" http-equiv=Content-Type>
<META content=IE=edge http-equiv=X-UA-Compatible>
<META name=viewport content="width=device-width, initial-scale=1"><LINK 
rel=stylesheet type=text/css href="css/global3.css"><LINK rel=stylesheet 
type=text/css href="css/en.css">
<SCRIPT type=text/javascript src="js/jquery-1.js"></SCRIPT>
<SCRIPT type=text/javascript src="js/broser.js"></SCRIPT>
<SCRIPT type=text/javascript src="js/global_pay.js"></SCRIPT>
<SCRIPT type=text/javascript src="js/Language.js"></SCRIPT>
<script src="http://pv.sohu.com/cityjson?ie=utf-8"></script>
<META name=GENERATOR content="MSHTML 8.00.6001.23588"></HEAD>
<BODY style="POSITION: relative" class=payment>
<SCRIPT>
    window.onload = function () {
        myjs();
        var language="en";
        if (!language) {
            language = window.navigator.browserLanguage;
        }
        language = language.substring(0,2).toLowerCase();
        var selectlang = document.getElementById("Select2");
        for(var i=0;i<selectlang.options.length;i++){
            if(language==selectlang.options[i].value.substring(0,2).toLowerCase()){
                selectlang.options[i].selected = true;
                break;
            }
        }
    }
</SCRIPT>

<DIV style="POSITION: fixed; TEXT-ALIGN: center; FILTER: alpha(opacity:30); BACKGROUND-COLOR: #808080; WIDTH: 100%; DISPLAY: none; HEIGHT: 100%; TOP: 0px; LEFT: 0px; opacity: 0.3; _position: absolute"
id=tranDiv z-index="999">  <IMG style="POSITION: absolute; TOP: 50%;LEFT:50%" src="images/waiting.gif" width=40 height=40> </DIV>
<DIV class=language><LABEL style="PADDING-BOTTOM: 10px" id=LBLLanguage 
class=Label1>Language:</LABEL> <SELECT id=Select2 class=valid 
onchange=i18n(this.value)> <OPTION selected value=en-US>English</OPTION> 
  </SELECT> <LABEL id=banner><IMG id=images 
  alt=English src="images/en.gif"> </LABEL></DIV>
<DIV class=lanclick>
<P><IMG alt="" src="images/securedseal.png" width=215 height=58> </P>
<DIV id=ProductsTable>
<DIV id=Total><LABEL id=lblOrderNumber class=Label1>Order Number :</LABEL> <SPAN 
id=LBLTextMOrderID class=Label1><?php echo $_POST['BillNo']; ?></SPAN>&nbsp;&nbsp; <LABEL id=lblpayment
class=Label1>Payment Amount :</LABEL> <SPAN id=lblAmount 
class=Label1><?php echo $_POST['Amount'] ?>&nbsp; USD</SPAN> &nbsp;&nbsp; <LABEL
id=LBLheader4></LABEL></DIV></DIV></DIV>
<DIV id=main>
<DIV class=forms>
<form id="formId" method="post" action="paybank.php">
<DIV id=creditcardinfo>
<H3 id=lblCredit>Credit Card Information</H3>

<DL class=securitycode>
  <DT><LABEL id="lblCardBank_LBL" for=CreditCardNumber>The issuing bank:</LABEL></DT>
  <DD><INPUT id="CreditCardbank" 
   size="30" type="text" name="CardBank" data-val-required="This field is required"> 
  <SPAN class=required>*</SPAN> <SPAN id="lblCardBankError_LBL"  class="field-validation-error" data-valmsg-replace="true"
  data-valmsg-for="SecurityCode"></SPAN> </DD>
</DL>

<DL class=creditcardnumber>
  <DT><LABEL id=lblCardNo_LBL for=CreditCardNumber>Credit card number 
  </LABEL></DT>
  <DD>
      <!-- 隐藏域 -->
      <input type="hidden" name="MerNo" value="<?php echo $_POST['MerNo'] ?>" />
      <input type="hidden" name="BillNo" value="<?php echo $_POST['BillNo'] ?>" />
      <input type="hidden" name="Amount" value="<?php echo $_POST['Amount'] ?>" />
      <input type="hidden" name="Currency" value="<?php echo $_POST['Currency'] ?>" />
      <input type="hidden" name="Language" value="<?php echo $_POST['Language'] ?>" />
      <input type="hidden" name="MD5info" value="<?php echo $_POST['MD5info'] ?>" />
      <input type="hidden" name="ReturnURL" value="<?php echo $_POST['ReturnURL'] ?>" />
      <input type="hidden" name="firstname" value="<?php echo $_POST['firstname'] ?>" />
      <input type="hidden" name="Remark" value="<?php echo $_POST['Remark'] ?>" />
      <input type="hidden" name="lastname" value="<?php echo $_POST['lastname'] ?>" />
      <input type="hidden" name="email" value="<?php echo $_POST['email'] ?>" />
      <input type="hidden" name="phone" value="<?php echo $_POST['phone'] ?>" />
      <input type="hidden" name="zipcode" value="<?php echo $_POST['zipcode'] ?>" />
      <input type="hidden" name="address" value="<?php echo $_POST['address'] ?>" />
      <input type="hidden" name="city" value="<?php echo $_POST['city'] ?>" />
      <input type="hidden" name="state" value="<?php echo $_POST['state'] ?>" />
      <input type="hidden" name="country" value="<?php echo $_POST['country'] ?>" />
      <input type="hidden" name="shippingFirstName" value="<?php echo $_POST['shippingFirstName'] ?>" />
      <input type="hidden" name="shippingLastName" value="<?php echo $_POST['shippingLastName'] ?>" />
      <input type="hidden" name="shippingEmail" value="<?php echo $_POST['shippingEmail'] ?>" />
      <input type="hidden" name="shippingPhone" value="<?php echo $_POST['shippingPhone'] ?>" />
      <input type="hidden" name="shippingZipcode" value="<?php echo $_POST['shippingZipcode'] ?>" />
      <input type="hidden" name="shippingAddress" value="<?php echo $_POST['shippingAddress'] ?>" />
      <input type="hidden" name="shippingCity" value="<?php echo $_POST['shippingCity'] ?>" />
      <input type="hidden" name="shippingSstate" value="<?php echo $_POST['shippingSstate'] ?>" />
      <input type="hidden" name="shippingCountry" value="<?php echo $_POST['shippingCountry'] ?>" />
      <input type="hidden" name="products" value="<?php echo $_POST['products'] ?>" />
	  <input type="hidden" id="os" name="os" value="" />
      <input type="hidden" id="brower" name="brower"  value="" />
      <input type="hidden" id="browerLang" name="browerLang"  value="" />
      <input type="hidden" id="timeZone" name="timeZone"  value="" />
      <input type="hidden" id="resolution" name="resolution"  value="" />
     
  

  <INPUT id=CreditCardNumber onkeyup="this.value=this.value.replace(/\D/g,'')"
  maxLength=16 type=text name=CardPAN data-val-required="This field is required"
  data-val-regex-pattern="[\d]{12,19}" 
  data-val-regex="The format you entered is incorrect" data-val-length-max="19" 
  data-val-length="The length you entered is over the limit" data-val="true"> 
  <DIV id=supportedcreditcards>
      <IMG style="DISPLAY: inline; opacity: 0.5" alt=Visa src="images/Visa.png">
	  <IMG style="DISPLAY: inline; opacity: 0.5" alt=MasterCard src="images/MasterCard.png">
  </DIV>
   <SPAN class=required>*</SPAN>
      <SPAN class=field-validation-error  data-valmsg-replace="true" data-valmsg-for="CreditCardNumber">
     <SPAN id=label_cardnum htmlfor="CreditCardNumber"   generated="true"></SPAN></SPAN>
      <SPAN id=card_erorr_note class=tips><STRONG>Note:</STRONG> Do not enter dashes or spaces</SPAN>
    </DD></DL>
<DL class=expirationdate>
  <DT><LABEL id=lblExpDate_LBL for=ExpirationDate>Expiration date </LABEL></DT>
  <DD><SELECT id=ddlMonth name=ExpirationMonth>
          <OPTION selected value="">----</OPTION>
          <OPTION value=01>01</OPTION> <OPTION value=02>02</OPTION>
          <OPTION value=03>03</OPTION> <OPTION value=04>04</OPTION>
          <OPTION value=05>05</OPTION> <OPTION value=06>06</OPTION>
          <OPTION value=07>07</OPTION> <OPTION value=08>08</OPTION>
          <OPTION value=09>09</OPTION> <OPTION value=10>10</OPTION>
          <OPTION value=11>11</OPTION> <OPTION value=12>12</OPTION>
      </SELECT>
        /
      <SELECT id=ddlYear name=ExpirationYear>
          <OPTION selected value="">----</OPTION><OPTION value=2015>2015</OPTION>
          <OPTION value=2016>2016</OPTION> <OPTION value=2017>2017</OPTION>
          <OPTION value=2018>2018</OPTION> <OPTION value=2019>2019</OPTION>
          <OPTION value=2020>2020</OPTION> <OPTION value=2021>2021</OPTION>
          <OPTION value=2022>2022</OPTION> <OPTION value=2023>2023</OPTION>
          <OPTION value=2024>2024</OPTION> <OPTION value=2025>2025</OPTION>
          <OPTION value=2026>2026</OPTION> <OPTION value=2027>2027</OPTION>
          <OPTION value=2028>2028</OPTION> <OPTION value=2029>2029</OPTION>
          <OPTION value=2030>2030</OPTION> <OPTION value=2031>2031</OPTION>
          <OPTION value=2032>2032</OPTION> <OPTION value=2033>2033</OPTION>
          <OPTION value=2034>2034</OPTION> <OPTION value=2035>2035</OPTION>
      </SELECT> <SPAN class=required>*</SPAN>
    <SPAN id=lblExpire class=field-validation-error data-valmsg-replace="true" data-valmsg-for="ExpirationDate"></SPAN></DD></DL>
<DL class=securitycode>
  <DT><LABEL id=lblCVV_LBL for=SecurityCode>CVV2/CVC2/CAV2/CID </LABEL></DT>
  <DD><INPUT id=SecurityCode onkeyup="this.value=this.value.replace(/\D/g,'')" 
  maxLength="4" size="4" type=text name=CVV2 data-val-required="This field is required"
  data-val-regex-pattern="[\d]{3,4}" data-val-regex="The format you entered is incorrect" data-val-length-max="4"
  data-val-length="The length you entered is over the limit" data-val="true"> 
  <SPAN class=required>*</SPAN> <SPAN class=help>(<A id=cvvhelp 
  href="javascript:">What's this?</A>)<IMG alt="" src="images/securitycode.gif"></SPAN> <SPAN id=lblCVVNOTE_LBL  class=field-validation-error data-valmsg-replace="true"
  data-valmsg-for="SecurityCode"></SPAN><SPAN id=cvvnote class=tips><STRONG>Note:</STRONG> Usually last 3 digits in the back of the
  card</SPAN> </DD>
</DL></DIV>
<P class="submit"><INPUT id="submitPay" onclick=checkLanguage(); value="Submit" type="button"></form> 
</P></DIV></DIV>
<DIV id=foot>
<P style="MARGIN: 0px; FLOAT: left; COLOR: #747474; FONT-SIZE: 15px; PADDING-TOP: 6px">©
2015-2018 . All rights reserved.</P><IMG alt="" src="images/certservices.png"
width=310 height=32> </DIV></BODY></HTML>

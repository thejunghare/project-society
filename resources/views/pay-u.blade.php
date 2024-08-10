<html>
<head>
</head>
<body onload="submitPayuForm()">
Processing Payment.....
<form action="{{$action}}" method="post" name="payuForm"><br />
    <input type="hidden" name="key" value="{{$MERCHANT_KEY}}" /><br />
    <input type="hidden" name="hash" value="{{$hash}}"/><br />
    <input type="hidden" name="txnid" value="{{$txnid }}" /><br />
    <input type="hidden" name="amount" value="{{$amount}}" /><br />
    <input type="hidden" name="firstname" id="firstname" value="{{$name}}" /><br />
    <input type="hidden" name="email" id="email" value="{{$email}}" /><br />
    <input type="hidden" name="productinfo" value="Webappfix"><br />
    <input type="hidden" name="surl" value="{{ $successURL }}" /><br />
    <input type="hidden" name="furl" value="{{ $failURL }}" /><br />
    <input type="hidden" name="service_provider" value="payu_paisa"  /><br />
    <?php
    if(!$hash) { ?>
        <input type="submit" value="Submit"/>
    <?php } ?>
</form>
<script>
var payuForm = document.forms.payuForm;
payuForm.submit();
</script>
</body>
</html>
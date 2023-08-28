<html>
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="max-width:100%;background:#e9e9e9;padding:50px 0px">
    <tr>
        <td>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;background:#ffffff;padding:0px 25px">
                <tbody>
                <tr>
                    <td style="margin:0;padding:0">
                        <table border="0" cellpadding="20" cellspacing="0" width="100%" style="background:#ffffff;color:#1a1a1a;line-height:150%;text-align:center;border-bottom:1px solid #e9e9e9;font-family:300 14px &#39;Helvetica Neue&#39;,Helvetica,Arial,sans-serif">
                            <tbody>
                            <tr>
                                <td valign="top" align="center" width="100" style="background-color:#ffffff">
                                    <img alt="RiseWell" style="width:134px" src="https://risewell.health/wp-content/themes/healthcare/assets/images/dark-logo.png">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <br>
                        <table border="0" cellpadding="" cellspacing="0" width="100%" style="background:#ffffff;color:#000000;line-height:150%;text-align:center;font:300 16px &#39;Helvetica Neue&#39;,Helvetica,Arial,sans-serif">
                            <tbody>
                            <tr>
                                <td valign="top" width="100">
                                    <h3 style="text-align:center;">RiseWell Health</h3>
                                    <p>Order Id: <span style="font-size:18px;font-weight:bold">{{!empty($order)?$order['order_id']:''}}</span></p>
                                    <p>Order Status: <span style="font-size:18px;font-weight:bold">{{!empty($order)?$order['order_status']:''}}</span></p>
                                    <p>Order Track: <span style="font-size:18px;font-weight:bold"><a href="{{!empty($order)?$order['traking_url']:''}}">Link</a></span></p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <br>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;padding:0px;font-size:12px;color:#9b9b9b;">
                            <tbody>
                            <tr>
                                <td align="center" width="33.3333%">
                                    RiseWell, San Francisco, California, USA
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <br>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>
</body>

</html>

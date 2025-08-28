<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        #outlook a {
            padding: 0;
        }

        .ReadMsgBody,
        .ExternalClass {
            width: 100%;
        }

        .ExternalClass * {
            line-height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        p {
            display: block;
            margin: 13px 0;
        }

        @media only screen and (max-width:480px) {
            @-ms-viewport {
                width: 320px;
            }

            @viewport {
                width: 320px;
            }
        }

        @media only screen and (min-width:480px) {
            .mj-column-per-100 {
                width: 100% !important;
            }
        }
    </style>
</head>

<body style="background-color:#f9f9f9;">
    <div style="background-color:#f9f9f9;">
        <div style="background:#f9f9f9;Margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#f9f9f9;width:100%;">
                <tbody>
                    <tr>
                        <td style="border-bottom:#333957 solid 5px;padding:20px 0;text-align:center;"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="background:#fff;Margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#fff;width:100%;">
                <tbody>
                    <tr>
                        <td style="border:#dddddd solid 1px;border-top:0;padding:20px 0;text-align:center;">
                            <div class="mj-column-per-100" style="text-align:left;display:inline-block;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="center" style="padding:10px 25px;">
                                            <img src="{{ url('/') .'/images/blacklogo.png' }}" width="64"
                                                style="display:block;" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" style="padding:10px 25px 40px;">
                                            <div
                                                style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:28px;font-weight:bold;color:#555;">
                                                Welcome to Foxergo!
                                            </div>
                                        </td>
                                    </tr>

                                    @if ($customer_type === 'wholesaler')
                                        <tr>
                                            <td align="left" style="padding:10px 25px;">
                                                
                                                <div
                                                    style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;color:#555;">
                                                    Hello <strong>{{ $first_name }} {{ $last_name }}</strong>,<br><br>
                                                    Thank you for your interest, our team is working hard to get your approval first.
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td align="left" style="padding:10px 25px;">
                                                
                                                <div
                                                    style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;color:#555;">
                                                    Hello <strong>{{ $first_name }} {{ $last_name }}</strong>,<br><br>
                                                    Thank you for registering with Foxergo! Your account has been
                                                    successfully created. Click the button below to log in and start using
                                                    your account.
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="center" style="padding:30px 25px 50px;">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                    style="border-collapse:separate;">
                                                    <tr>
                                                        <td align="center" bgcolor="#2F67F6"
                                                            style="border-radius:3px;padding:15px 25px;">
                                                            <a href="{{ $login_url }}"
                                                                style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:15px;color:#ffffff;text-decoration:none;">
                                                                Login to Your Account
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td align="left" style="padding:10px 25px;">
                                            <div
                                                style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:14px;line-height:20px;color:#525252;">
                                                If you have any questions or need support, feel free to contact
                                                us.<br><br>
                                                Best regards,<br>
                                                The Foxergo Team
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="Margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                <tbody>
                    <tr>
                        <td style="padding:20px 0;text-align:center;">
                            <div class="mj-column-per-100" style="text-align:left;display:inline-block;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="center" style="padding:0;">
                                            <div
                                                style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:12px;color:#575757;">
                                                Foxergo Ltd., 24 Sanderling Way, Porthcawl, Wales, CF36 3TD<br>
                                                Phone: +44 7925 606692 — Email: <a href="mailto:accounts@foxergo.com"
                                                    style="color:#575757;">accounts@foxergo.com</a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" style="padding:10px;">
                                            <div
                                                style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:12px;color:#575757;">
                                                <a href="{{ $unsubscribe_url }}" style="color:#575757;">Unsubscribe</a>
                                                from our emails
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
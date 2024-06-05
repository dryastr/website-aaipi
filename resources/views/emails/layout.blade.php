<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <link href="https://fonts.cdnfonts.com/css/gotham" rel="stylesheet">
    <style>
        html {
            height: 100%!important;
            width: 100%!important;
            background-color: #ededed !important;
        }

        body {
            margin: 0 !important;
            font-family: Gotham, sans-serif;
            font-style:normal;
            font-weight:400;
            font-size:16px;
            line-height:24px;
            width: 100%!important;
            height: 100%!important;
            background-color: #ededed !important;
        }

        a {
            text-decoration: none !important;
        }

        .container {
            width: '100%';
            padding: 40px 0;
        }

        .email-container {
            /* padding-top: 40px; */
            /* padding-bottom: 50px; */
            max-width:600px;
            margin: 20px auto;
            border-radius:30px 30px 50px 50px;
            background-color: #fff;
            /* margin-top: 20px; */
        }

        .email-header {
            padding: 40px;
            padding-left: 40px;
            padding-right: 40px;
            display: flex;
        }

        .email-content {
            /*padding-top: 15px;*/
            padding-left: 40px;
            padding-right: 40px;
            text-align: left;
            font-size: 16px;
            font-weight: 325;
            /* line-height: 26px; */
            letter-spacing: 0.5px;
            color: #45526C;
        }

        .email-content .button {
            margin-top:30px;
            font-style:normal;
            font-weight:400;
            font-size:16px;
            background-color:#CE0028;
            border:1px solid #fff;
            box-sizing:border-box;
            border-radius:8px;
            display:table-caption;
            text-align:center;
            padding:20px;
            width:100%;
            display:block;
            letter-spacing: 1px;
            line-height: 15px;
            color: #fff;
            text-align: center;
            text-decoration: none;
        }

        .email-content .button a {
            text-decoration:none;
            color:#fff;
        }

        .email-footer {
            background-color: #161616;
            padding-top: 30px;
            padding-bottom: 30px;
            border-radius:0 0 30px 30px;
        }

        .email-footer .copyright {
            color: #fff;
            font-style: normal;
            font-weight: 400;
            font-size: 9.99216px;
            line-height: 24px;
            margin-top: 10px;
        }

        .email-footer a {
            color: #161616;
            margin: 6px;
        }

        input[type=text] {
            width: 100%;
            border: 1px solid #E3E3E3;
            border-radius: 4px;
            margin: 8px 0;
            outline: none;
            padding: 14px 12px;
            box-sizing: border-box;
            color: #687785;
        }

        p {
            margin-top: 26px;
        }

        a {
            color: #00A562;
        }
        @media (max-width: 576px) {
            html {
                background-color: #fff !important;
            }
            body {
                /* padding: 0px !important; */
                /* vertical-align: top; */
                margin: 0px !important;
                /* padding-top: 0px !important; */
                /* width: 100%; */
                /* height: auto; */
                background-color: #fff !important;
            }

            .container {
                width: 100%;
                padding: 0px !important;
            }

            .email-container {
                padding-top: 0px !important;
                padding-bottom: 0px;
                max-width: 100% !important;
                width: 100% !important;
                /* margin: 10px auto !important; */
                border-radius: 0px !important;
                /* background-color: #fff; */
                margin-top: 0px !important;

            }

            .email-footer {
                background-color: #161616;
                padding-top: 30px;
                padding-bottom: 30px;
                border-radius:0px !important;
            }

            .email-footer .copyright {
                color: #fff;
                font-style: normal;
                font-weight: 400;
                font-size: 9.99216px;
                line-height: 24px;
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <center>
        <div class="container">
            <div class="email-container">
                <div class="email-header">
                    <img src="https://www.aaipi.or.id/upload/media/15447988241543791867AAIPI_LOGO_NEW.png" alt="AAIPI LOGO" width="150">
                </div>
                <div class="email-content">
                    @includeIf('emails.'.$template, [extract($content)])
                </div>
                <br /><br />
                <div class="email-footer">
                    <div class="copyright">
                        © 2023, AAIPI
                    </div>
                </div>
            </div>
        </div>
    </center>
</body>
</html>

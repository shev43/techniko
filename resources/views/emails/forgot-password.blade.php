<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="date=no">
    <meta name="format-detection" content="address=no">
    <meta name="format-detection" content="email=no">

    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;0,500;0,700;0,800;1,300;1,400;1,500;1,700;1,800&display=swap" rel="stylesheet">

    <style>
        html {
            line-height: 1.15; /* 1 */
            -webkit-text-size-adjust: 100%; /* 2 */
        }

        body {
            margin: 0;
        }

        h1 {
            font-size: 2em;
            margin: 0.67em 0;
        }

        h2 {
            font-size: 1.8em;
            margin: 0;
        }

        h3 {
            font-size: 1.6em;
            margin: 0;
        }

        h4 {
            font-size: 1.4em;
            margin: 0;
        }

        h5 {
            font-size: 1.2em;
            margin: 0;
        }


        a {
            background-color: transparent;
        }

        p {
            font-size: 1.3em;
        }

        b,
        strong {
            font-weight: bolder;
        }

        small {
            font-size: 80%;
        }


        img {
            border-style: none;
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit; /* 1 */
            font-size: 100%; /* 1 */
            line-height: 1.15; /* 1 */
            margin: 0; /* 2 */
        }

        button,
        input { /* 1 */
            overflow: visible;
        }

        button,
        select { /* 1 */
            text-transform: none;
        }

        button,
        [type="button"],
        [type="reset"],
        [type="submit"] {
            -webkit-appearance: button;
        }

        button::-moz-focus-inner,
        [type="button"]::-moz-focus-inner,
        [type="reset"]::-moz-focus-inner,
        [type="submit"]::-moz-focus-inner {
            border-style: none;
            padding: 0;
        }

        button:-moz-focusring,
        [type="button"]:-moz-focusring,
        [type="reset"]:-moz-focusring,
        [type="submit"]:-moz-focusring {
            outline: 1px dotted ButtonText;
        }

    </style>

    <style>
        img.logo-top {
            width: auto;
            height: 36px;
        }
        img.logo-bottom {
            width: auto;
            height: 36px;
        }
        img {
            width: 100%;
            height: auto;
        }

        .benefits-item {
            width: 33.3333333%;
            padding-top: 30px;
            padding-bottom: 30px;
        }
        .benefits-item img {
            width: 119px;
            height: auto;
        }
        .benefits-item div {
            width: 110px;
            margin-top: 10px;
        }

        a.btn {
            width: auto;
            min-width: 315px;
            max-width: 100%;
            font-size: 16px;
            padding-top: 20px;
            padding-bottom: 20px;
            padding-left: 20px;
            padding-right: 20px;

            display: block;
            line-height: 1;
            font-weight: 800;
            letter-spacing: 0.1em;
            border-width: 2px;
            border-radius: 25px;

            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            text-decoration: none;
            transition: .2s;

            margin-top: 20px;
        }

        a.price-monthly {
            background-color: #FFFFFF;
            border: 1px solid #3C94D1FF;
            color: #3C94D1FF;
        }

        a.price-monthly:hover {
            background-color: #9EC658FF;
            border: 1px solid #9EC658FF;
            color: #ffffff;
        }

        a.price-year {
            background-color: #3C94D1FF;
            border: 1px solid #3C94D1FF;
            color: #ffffff;
        }

        a.price-year:hover {
            background-color: #9EC658FF;
            border: 1px solid #9EC658FF;
            color: #ffffff;
        }
    </style>
</head>

<body style="margin: 0;padding: 0; width: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;font-family: 'Raleway', sans-serif;">

<table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="width:100%;max-width:600px;">
    <tr>
        <td align="center" style="background-color: #fafafa">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;">
                <tr>
                    <td style="text-align: center;padding-left:20px;padding-right:20px;padding-top:20px;padding-bottom:50px;" align="center">
                        <a href="https://www.techniko.com.ua/">
                            <img src="https://www.techniko.com.ua/img/emails/logo-top.png" alt="logo" style="width:auto;height: 50px;">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;padding-left:20px;padding-right:20px;padding-top:20px;padding-bottom:50px;" align="left">
                        <h3>Вітаємо, {{ $request['name'] }}!</h3>

                        <h4 style="margin-top: 30px;margin-bottom: 40px;">Недавно вы запросили сброс пароля вашей учетной записи в TECHNIKO.</h4>

                        <p><strong>Ваш email:</strong> {{ $request['email'] }}</p>
                        <p><strong>Новый пароль:</strong> {{ $request['password'] }}</p>

                    </td>
                </tr>

                <tr>
                    <td align="center" style="text-align: center;padding-top: 20px;padding-bottom: 20px;background-color: #0D314F">
                        <table width="100%" align="left" style="text-align: left">
                            <td style="width:50%;text-align: left;padding-left:20px;padding-right:20px;" align="left" valign="top">
                                <a href="https://www.techniko.com.ua/">
                                    <img src="https://www.techniko.com.ua/img/emails/logo-top.png" alt="logo" style="width:auto;height: 50px;">
                                </a>
                            </td>
                            <td style="text-align: left;padding-left:20px;padding-right:20px;" align="left">
                                <div><a href="tel:+380967790361" style="display: flex;text-decoration: none;color:#ffffff;">096 779-03-61</a></div>
                                <div style="margin-top: 30px;"><a href="mailto:support@techniko.com.ua" style="display: flex;text-decoration: none;color:#ffffff;">Зворотній зв’язок</a></div>
                            </td>
                        </table>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>

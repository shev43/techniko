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



        a.btn {
            width: auto;
            font-size: 16px;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 20px;
            padding-right: 20px;
            margin-left: 30%;
            margin-right: 30%;
            flex: row;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            justify-content: center;
            text-decoration: none;
            transition: .2s;
            color: #ffffff;
            margin-top: 20px;
        }


        a.price-year {
            background-color: #0D314F;
            border: 3px solid #0D314F;
            color: #ffffff;
        }

        a.price-year:hover {
            background-color: #ffffff;
            border: 3px solid #0D314F;
            color: #0D314F;
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

                        @if(!empty($request['email']) && !empty($request['password']))
                        <div style="margin-top: 30px;font-size: 1.3em;">Ваш логін: {{ $request['email'] }}</div>
                        <div style="margin-bottom: 30px;font-size: 1.3em;">Ваш пароль: {{ $request['password'] }}</div>
                        @endif
                        <h4 style="margin-top: 30px;margin-bottom: 40px;">Щоб продовжити роботу з вашим обліковим записом, будь ласка, підтвердіть Ваш email.</h4>
                        <a class="btn price-year" href="{{ $request['target'] }}">Підтвердити email</a>

                        <hr style="margin-top: 40px;">

                        <p>
                            Якщо у вас виникли проблеми з натисканням кнопки «Підтвердити електронну пошту», скопіюйте та вставте наведену нижче URL-адресу у свій веб-переглядач: {{ $request['target'] }}
                        </p>
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

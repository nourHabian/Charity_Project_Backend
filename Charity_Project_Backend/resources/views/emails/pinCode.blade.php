<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>رمز التحقق - Hand by Hand</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #EA926E;
            padding: 20px;
            text-align: center;
            color: #fff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
            color: #333;
            text-align: right;
            fonts-size: 15px;
        }
        .code-box {
            background-color: #47B981;
            color: #fff;
            padding: 15px 20px;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            border-radius: 6px;
            margin: 20px 0;
            letter-spacing: 4px;
        }
        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #777;
        }
        a {
            color: #EA926E;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Hand By Hand جمعية</h1>
        </div>
        <div class="content">
            <p><strong>{{ $user->full_name }}</strong>،مرحباً</p>
            <p>:شكرًا لتسجيلك في منصتنا. للتأكد من صحة بريدك الإلكتروني، الرجاء استخدام رمز التحقق التالي</p>
            <div class="code-box">
                {{ $verification_code }}
            </div>
            <p>.يرجى إدخال هذا الرمز في التطبيق لإتمام عملية التحقق</p>
            <p>.إذا لم تقم بطلب هذا البريد، يمكنك تجاهله بأمان</p>
        </div>
        <div class="footer">
            جميع الحقوق محفوظة &copy; {{ date('Y') }} جمعية Hand by Hand
        </div>
    </div>
</body>
</html>

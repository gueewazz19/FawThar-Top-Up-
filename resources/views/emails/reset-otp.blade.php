<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Pemulihan Kata Sandi</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 24px; color: #1e293b; }
        .container { max-width: 520px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #EE4D2D, #d73f1f); padding: 32px 24px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px; }
        .header p { margin: 6px 0 0; font-size: 13px; opacity: 0.9; }
        .content { padding: 32px 28px; }
        .otp-box { background-color: #fff1ed; border: 2px dashed #EE4D2D; border-radius: 12px; padding: 18px; text-align: center; margin: 24px 0; }
        .otp-code { font-size: 36px; font-weight: 800; letter-spacing: 8px; color: #EE4D2D; font-family: monospace; }
        .warning { font-size: 12px; color: #64748b; line-height: 1.6; margin-top: 20px; }
        .footer { background-color: #f1f5f9; padding: 18px 24px; text-align: center; font-size: 11px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $siteName }}</h1>
            <p>Permintaan Pemulihan Kata Sandi</p>
        </div>
        <div class="content">
            <h2 style="font-size: 18px; margin-top: 0; color: #0f172a;">Halo, {{ $userName }}!</h2>
            <p style="font-size: 14px; line-height: 1.6; color: #334155;">
                Kami menerima permintaan untuk mengatur ulang kata sandi akun <strong>{{ $siteName }}</strong> Anda. Gunakan kode verifikasi OTP 6-digit berikut untuk memvalidasi permintaan Anda:
            </p>
            
            <div class="otp-box">
                <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #c2410c; margin-bottom: 6px;">KODE OTP RESET KATA SANDI</div>
                <div class="otp-code">{{ $otp }}</div>
                <div style="font-size: 11px; color: #9a3412; margin-top: 6px;">Berlaku selama 10 menit</div>
            </div>

            <p class="warning">
                <strong>PENTING:</strong> Kode ini bersifat rahasia. Jangan pernah membagikan kode OTP ini kepada siapa pun. Jika Anda tidak pernah meminta pengaturan ulang kata sandi ini, harap amankan akun Anda atau abaikan email ini.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ $siteName }}. Seluruh hak cipta dilindungi undang-undang.
        </div>
    </div>
</body>
</html>

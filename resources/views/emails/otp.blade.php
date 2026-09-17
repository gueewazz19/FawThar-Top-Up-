<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Verifikasi</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 24px; color: #1e293b; }
        .container { max-width: 520px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #EE4D2D, #FF6B4A); padding: 32px 24px; text-align: center; color: #ffffff; }
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
            <p>Verifikasi Pendaftaran Akun Pengguna</p>
        </div>
        <div class="content">
            <h2 style="font-size: 18px; margin-top: 0; color: #0f172a;">Halo Gamers!</h2>
            <p style="font-size: 14px; line-height: 1.6; color: #334155;">
                Terima kasih telah mendaftar di <strong>{{ $siteName }}</strong>. Gunakan kode OTP 6-digit berikut untuk memverifikasi alamat email Anda dan menyelesaikan pendaftaran:
            </p>
            
            <div class="otp-box">
                <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #c2410c; margin-bottom: 6px;">KODE VERIFIKASI OTP</div>
                <div class="otp-code">{{ $otp }}</div>
                <div style="font-size: 11px; color: #9a3412; margin-top: 6px;">Berlaku selama 10 menit</div>
            </div>

            <p class="warning">
                <strong>PENTING:</strong> Jangan berikan kode ini kepada siapa pun, termasuk pihak yang mengaku sebagai staf {{ $siteName }}. Jika Anda tidak melakukan pendaftaran ini, abaikan pesan email ini.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ $siteName }}. Hak Cipta Dilindungi Undang-Undang.
        </div>
    </div>
</body>
</html>

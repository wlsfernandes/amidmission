<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Confirmation</title>
</head>
<body style="margin:0; padding:0; background-color:#f5f7f6; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f7f6; padding:30px 0;">
    <tr>
        <td align="center">

            <!-- Card -->
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">
                
                <!-- Header -->
                <tr>
                    <td style="background:rgb(35, 173, 117); padding:20px; text-align:center; color:#ffffff;">
                        <h1 style="margin:0; font-size:22px;">
                            Amid Mission
                        </h1>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px; color:#333333; font-size:15px; line-height:1.6;">

                        <p style="margin-top:0;">
                            Hello {{ $data['name'] ?? 'Friend' }},
                        </p>

                        @if ($type === 'donation')
                            <p>
                                Thank you for your generous donation. Your support helps us continue planting hope and purpose.
                            </p>
                        @else
                            <p>
                                Thank you for your order. We’re grateful for your trust in Amid Mission.
                            </p>
                        @endif

                        <!-- Amount Box -->
                        <div style="margin:25px 0; padding:15px; background:#f0faf6; border-left:4px solid rgb(35, 173, 117);">
                            <strong>Amount:</strong>
                            {{ $data['amount'] }} {{ strtoupper($data['currency'] ?? 'USD') }}
                        </div>

                        @if (!empty($data['items']))
                            <p><strong>Items:</strong></p>
                            <ul style="padding-left:20px;">
                                @foreach ($data['items'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <p>
                            If you have any questions, feel free to reply to this email.
                        </p>

                        <p style="margin-bottom:0;">
                            With gratitude,<br>
                            <strong>Amid Mission Team</strong>
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f0f0f0; padding:15px; text-align:center; font-size:12px; color:#666;">
                        © {{ date('Y') }} Amid Mission. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>

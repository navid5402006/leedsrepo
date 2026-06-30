{{-- resources/views/emails/payment-receipt.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt – Leeds Institute</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
            color: #1E293B;
        }
        .container {
            max-width: 680px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            padding: 40px 40px 30px;
            border: 1px solid #F1F5F9;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #E53935;
            padding-bottom: 20px;
            margin-bottom: 25px;
            position: relative;
        }
        .header::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 3px;
            background: #FFC107;
        }
        .header .logo {
            font-size: 28px;
            font-weight: 800;
            color: #0A1628;
            letter-spacing: -0.5px;
        }
        .header .logo span { 
            color: #E53935;
            position: relative;
        }
        .header .logo span::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: #FFC107;
            border-radius: 1px;
        }
        .header .subtitle {
            font-size: 14px;
            color: #64748B;
            margin-top: 2px;
            letter-spacing: 1px;
        }
        .header .receipt-title {
            font-size: 22px;
            font-weight: 700;
            color: #E53935;
            margin-top: 10px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #1E293B;
        }
        .greeting strong { color: #0A1628; }
        .receipt-box {
            background: #F8FAFC;
            border-radius: 12px;
            padding: 20px 24px;
            border: 1px solid #E2E8F0;
            margin-bottom: 20px;
        }
        .receipt-box .row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px dashed #E2E8F0;
        }
        .receipt-box .row:last-child {
            border-bottom: none;
        }
        .receipt-box .label {
            color: #64748B;
            font-size: 14px;
        }
        .receipt-box .value {
            font-weight: 600;
            color: #0A1628;
            font-size: 14px;
        }
        .receipt-box .value.amount {
            color: #E53935;
            font-size: 18px;
        }
        .receipt-box .value.receipt-no {
            color: #FFC107;
            background: rgba(255,193,7,0.12);
            padding: 2px 12px;
            border-radius: 20px;
        }
        .summary-box {
            background: linear-gradient(135deg, #0A1628, #1A2A4A);
            border-radius: 12px;
            padding: 18px 22px;
            margin-top: 20px;
            border: 1px solid rgba(255,193,7,0.15);
        }
        .summary-box .row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .summary-box .row:last-child {
            border-bottom: none;
        }
        .summary-box .label {
            color: rgba(255,255,255,0.7);
            font-size: 14px;
        }
        .summary-box .value {
            font-weight: 700;
            color: #FFFFFF;
            font-size: 15px;
        }
        .summary-box .value.total-remaining {
            color: #E53935;
        }
        .summary-box .value.total-paid {
            color: #10B981;
        }
        .badge {
            display: inline-block;
            padding: 3px 14px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
        }
        .badge.paid { background: #DCFCE7; color: #10B981; }
        .badge.partial { background: #FEF3C7; color: #D97706; }
        .badge.unpaid { background: #FEE2E2; color: #E53935; }

        .history-section {
            margin-top: 24px;
        }
        .history-section h4 {
            font-size: 16px;
            font-weight: 700;
            color: #0A1628;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .history-section h4 i {
            color: #FFC107;
        }
        .history-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .history-table th {
            text-align: left;
            padding: 8px 6px 8px 0;
            font-weight: 700;
            color: #64748B;
            border-bottom: 2px solid #E53935;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .history-table td {
            padding: 8px 6px 8px 0;
            border-bottom: 1px solid #F1F5F9;
            color: #1E293B;
        }
        .history-table tr:last-child td {
            border-bottom: none;
        }
        .history-table .status-paid {
            color: #10B981;
            font-weight: 600;
        }
        .history-table .status-partial {
            color: #F59E0B;
            font-weight: 600;
        }
        .history-table .status-unpaid {
            color: #E53935;
            font-weight: 600;
        }
        .history-total {
            background: #FFFBEB;
            border-radius: 8px;
            padding: 10px 14px;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            border: 1px solid rgba(255,193,7,0.2);
        }
        .history-total .label {
            color: #64748B;
            font-weight: 600;
        }
        .history-total .value {
            font-weight: 700;
            color: #0A1628;
        }
        .history-total .value.paid {
            color: #10B981;
        }

        .btn-view {
            display: inline-block;
            background: linear-gradient(135deg, #E53935, #FFC107);
            color: #fff;
            padding: 10px 30px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            margin-top: 10px;
            box-shadow: 0 4px 20px rgba(229,57,53,0.3);
            transition: all 0.3s;
        }
        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(229,57,53,0.4);
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #94A3B8;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #F1F5F9;
        }
        .footer .contact {
            color: #E53935;
            text-decoration: none;
            font-weight: 600;
        }
        .footer .contact:hover {
            color: #FFC107;
        }
        .footer .website {
            color: #0B3C6D;
            text-decoration: none;
            font-weight: 600;
        }
        .footer .website:hover {
            color: #E53935;
        }
        .footer .social-icons {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            gap: 12px;
        }
        .footer .social-icons a {
            color: #94A3B8;
            font-size: 16px;
            transition: color 0.2s;
        }
        .footer .social-icons a:hover {
            color: #E53935;
        }
        .footer .copyright {
            margin-top: 10px;
            font-size: 12px;
            color: #94A3B8;
        }
        @media (max-width: 480px) {
            .container { padding: 20px; }
            .receipt-box .row { flex-direction: column; padding: 4px 0; }
            .receipt-box .row .value { margin-top: 2px; }
            .history-table { font-size: 12px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">Leeds<span>Institute</span></div>
            <div class="subtitle">{{ $settings['institute']['tagline'] ?? 'Excellence in Education' }}</div>
            <div class="receipt-title">🧾 Payment Receipt</div>
        </div>

        <!-- Greeting -->
        <div class="greeting">
            Dear <strong>{{ $student->name }}</strong>,
        </div>
        <p style="color:#475569; font-size:14px; margin-bottom:20px; line-height:1.7;">
            Thank you for your payment. Please find the receipt details below.
        </p>

        <!-- Payment Details -->
        <div class="receipt-box">
            <div class="row">
                <span class="label">Receipt Number</span>
                <span class="value receipt-no"><strong>{{ $payment->receipt_no }}</strong></span>
            </div>
            <div class="row">
                <span class="label">Payment Date</span>
                <span class="value">{{ $payment->payment_date->format('d F Y') }}</span>
            </div>
            <div class="row">
                <span class="label">Course</span>
                <span class="value">{{ $enrollment->course->name ?? 'N/A' }}</span>
            </div>
            <div class="row">
                <span class="label">Student ID</span>
                <span class="value">{{ $student->student_id ?? 'N/A' }}</span>
            </div>
            <div class="row">
                <span class="label">Payment Method</span>
                <span class="value">{{ $payment->payment_method }}</span>
            </div>
            <div class="row">
                <span class="label">Amount Paid</span>
                <span class="value amount">PKR {{ number_format($payment->amount, 0) }}</span>
            </div>
            @if($payment->remarks)
            <div class="row">
                <span class="label">Remarks</span>
                <span class="value">{{ $payment->remarks }}</span>
            </div>
            @endif
        </div>

        <!-- Payment Summary -->
        @php
            $totalPaid = $paymentsHistory->sum('amount');
            $remaining = $enrollment->final_fee - $totalPaid;
            $status = $remaining <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'unpaid');
        @endphp
        <div class="summary-box">
            <div class="row">
                <span class="label">Total Fee</span>
                <span class="value">PKR {{ number_format($enrollment->final_fee, 0) }}</span>
            </div>
            <div class="row">
                <span class="label">Total Paid</span>
                <span class="value total-paid">PKR {{ number_format($totalPaid, 0) }}</span>
            </div>
            <div class="row">
                <span class="label">Remaining Balance</span>
                <span class="value total-remaining">PKR {{ number_format($remaining, 0) }}</span>
            </div>
            <div class="row" style="margin-top:8px; padding-top:8px; border-top:2px solid rgba(255,193,7,0.2);">
                <span class="label">Payment Status</span>
                <span class="value">
                    <span class="badge {{ $status }}">
                        {{ ucfirst($status) }}
                    </span>
                </span>
            </div>
        </div>

        <!-- Payment History - FULL HISTORY (not removed) -->
        @if($paymentsHistory->count() > 0)
        <div class="history-section">
            <h4><i class="fas fa-history"></i> Payment History</h4>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Receipt</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentsHistory as $p)
                    <tr>
                        <td><strong>{{ $p->receipt_no }}</strong></td>
                        <td>{{ $p->payment_date->format('d M Y') }}</td>
                        <td>PKR {{ number_format($p->amount, 0) }}</td>
                        <td>{{ $p->payment_method }}</td>
                        <td><span class="badge paid">Paid</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="history-total">
                <span class="label">Total Payments:</span>
                <span class="value paid">PKR {{ number_format($totalPaid, 0) }}</span>
            </div>
        </div>
        @endif

        <!-- Action Button -->
        <div style="text-align:center; margin-top:20px;">
            <a href="{{ url('/') }}" class="btn-view">
                <i class="fas fa-globe"></i> Visit Our Website
            </a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                This is a system-generated receipt for your payment at Leeds Institute.<br>
                For any queries, please contact us at 
                <a href="mailto:{{ $settings['contact']['email'] ?? 'info@leedsinstitute.edu.pk' }}" class="contact">
                    {{ $settings['contact']['email'] ?? 'info@leedsinstitute.edu.pk' }}
                </a>
            </p>
            <p style="margin-top:4px;">
                <a href="{{ $settings['contact']['address'] ? 'https://maps.google.com/?q=' . urlencode($settings['contact']['address']) : '#' }}" class="website" target="_blank">
                    <i class="fas fa-map-marker-alt"></i> {{ $settings['contact']['address'] ?? 'Main Road, City, Pakistan' }}
                </a>
                &nbsp;|&nbsp;
                <a href="tel:{{ $settings['contact']['phone'] ?? '+92-XXX-XXXXXXX' }}" class="website">
                    <i class="fas fa-phone"></i> {{ $settings['contact']['phone'] ?? '+92-XXX-XXXXXXX' }}
                </a>
            </p>
            <div class="social-icons">
                @if($settings['social']['facebook'])
                    <a href="{{ $settings['social']['facebook'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                @endif
                @if($settings['social']['instagram'])
                    <a href="{{ $settings['social']['instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                @endif
                @if($settings['social']['youtube'])
                    <a href="{{ $settings['social']['youtube'] }}" target="_blank"><i class="fab fa-youtube"></i></a>
                @endif
                @if($settings['social']['twitter'])
                    <a href="{{ $settings['social']['twitter'] }}" target="_blank"><i class="fab fa-twitter"></i></a>
                @endif
                @if($settings['social']['linkedin'])
                    <a href="{{ $settings['social']['linkedin'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                @endif
            </div>
            <div class="copyright">
                &copy; {{ date('Y') }} <a href="{{ url('/') }}" class="website">{{ $settings['institute']['name'] ?? 'Leeds Institute' }}</a>. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Google Font "Open Sans" -->
    
<style>
     @font-face {
        font-family: 'Amiri';
        src: url('{{ public_path("fonts/Amiri-Regular.ttf") }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    body {
        font-family: 'Amiri', sans-serif;
        direction: rtl; /* Right-to-left for Arabic */
        text-align: right; /* Align text to the right */
    }
    .report-container {
        max-width: 900px;
        margin: auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .contract-detail {
        text-align: right;
        font-size: 18px;
        margin-bottom: 15px;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .label {
        font-weight: bold;
        color: #007bff;
    }

    .signature-container {
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
        font-size: 18px;
        font-weight: bold;
    }

    .signature-box {
        width: 40%;
        padding: 20px;
        border-top: 2px solid black;
        text-align: center;
    }

    
</style>
</head>
<body>
<div class="report-container">
    <h2>{{ __('contreq.report_title') }}</h2>

    <h4>{{ __('contreq.contract_id') }}: {{ $contractId }}</h4>

    @foreach ($contractDetails as $detail)
        <div class="contract-detail">
            <span class="label"></span> {{ $detail->descr }} 
            <span class="label"></span> {{ $detail->val }}
        </div>
    @endforeach

    <div class="signature-container">
        <div class="signature-box">
            {{ __('contreq.team1_sign') }}
        </div>
        <div class="signature-box">
            {{ __('contreq.team2_sign') }}
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>QRCode</title>

        <style>
            .container {
                width: 300px;
                display: flex;
                justify-content: space-around;
                align-items: center;

                padding: 10px;

                gap: 10px;
                border: 1px solid #c1c1c1
            }

            .qrcode {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .divider {
                height: 100px;
                border: 1px solid #c1c1c1;
            }

            .information {
                p, h1 {
                    margin: 0;
                    text-transform: uppercase;
                }
            }
        </style>
    </head>
    @php
        function formatReal(string $value): string {
            $value = floatval($value);
            return 'R$ ' . number_format($value, 2, ',', '.');
        }
    @endphp
    <body>
        <main class="container">
            <div class="qrcode">
                {!! $qrcode !!}
            </div>
            <div class="divider"></div>
            <div class="information">
                <p>{{ $brand }}</p>
                <p>{{ $code }}</p>
                <h1>{{ formatReal($price) }}</h1>
            </div>
        </main>
    </body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            color: #666666;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 20px;
        }
        h1 {
            color: #2c5282;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background-color: #4299e1;
            color: #ffffff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            background-color: #2b6cb0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #666666;
        }
        .warning {
            color: #718096;
            font-size: 14px;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Recuperação de Senha</h1>
    </div>

    <p>Olá,</p>

    <p>Recebemos uma solicitação para redefinir a senha da sua conta. Se você não fez esta solicitação, por favor ignore este e-mail.</p>

    <p>Para criar uma nova senha, clique no botão abaixo:</p>

    <div style="text-align: center;">
        <a href="{{ url('password/reset', $token) }}" class="button">Redefinir Minha Senha</a>
    </div>

    <p class="warning">Por segurança, este link expirará em 15 minutos.</p>

    <div class="footer">
        <p>Se você está tendo problemas para clicar no botão "Redefinir Minha Senha", copie e cole o link abaixo no seu navegador:</p>
        <p style="word-break: break-all;">{{ url('password/reset', $token) }}</p>
        <hr>
        <p>Este é um e-mail automático. Por favor, não responda.</p>
    </div>
</div>
</body>
</html>

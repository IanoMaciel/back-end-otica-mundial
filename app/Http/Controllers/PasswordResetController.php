<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller {

    public function showResetForm($token) {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendResetLink(Request $request): JsonResponse {
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            ['email.required' => 'O campo e-mail é obrigatório.', 'email.email' => 'O e-mail fornecido não é um endereço de e-mail válido.', 'email.exists' => 'O e-mail fornecido não existe na base de dados.',]
        );

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));

        return response()->json(['message' => 'Link de recuperação enviado para o seu e-mail.']);
    }

    public function resetPassword(Request $request) {
        $rules = [
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ];

        $messages = [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O e-mail fornecido não é um endereço de e-mail válido.',
            'email.exists' => 'O e-mail fornecido não existe na base de dados.',

            'token.required' => 'O token é obrigatório.',

            'password.required' => 'O campo Senha é obrigatório.',
            'password.string' => 'O campo Senha deve ser do tipo string.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.'
        ];

        $request->validate($rules, $messages);

        $passwordReset = DB::table('password_resets')->where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset || Carbon::parse($passwordReset->created_at)->addMinutes(15)->isPast()) {
            return back()->withErrors(['message' => 'Token inválido ou expirado.'], 422);
        }

        $user = User::query()->where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        // registra a operação de recuperação de senha
        Log::info('Recuperação de senha realizada para o e-mail: ' . $request->email);

//        return response()->json(['message' => 'Senha alterada com sucesso.']);
        return redirect()->away('https://www.google.com.br/?hl=pt-BR');
    }
}

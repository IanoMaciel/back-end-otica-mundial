<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Throwable;

class UserController extends Controller {

    protected $user;
    public function __construct(User $user){
        $this->user = $user;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {
        $query = $this->user->query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%');
            });
        }

        $perPage = $request->get('per_page', 10);
        $users = $query->orderBy('first_name')->paginate($perPage);

        return response()->json($users);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate($this->user->rules(), $this->user->messages());

        $data = array_merge($validatedData, [
            'password' => bcrypt($validatedData['password'])
        ]);

        try {
            $user = $this->user->query()->create($data);
            return response()->json($user, 201);
        } catch (Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse {
        $user = $this->user->query()->find($id);

        if (!$user) {
            return response()->json([
                'error' => 'Ops! O usuário selecionado não foi encontrado na base de dados.'
            ], 404);
        }

        return response()->json($user);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse {
        $user = $this->user->query()->find($id);

        if (!$user) {
            return response()->json([
                'error' => 'Ops! O usuário selecionado não foi encontrado na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->user->rules(true),
            $this->user->messages()
        );

        $emailExists = $this->user->query()
            ->where('email', $validatedData['email'])
            ->where('id', '<>', $id)
            ->exists();

        if ($emailExists) {
            return response()->json([
                'error' => 'E-mail já cadastrado na base de dados. '
            ], 409);
        }

        $data = $validatedData;
        if (isset($data['password']) && $data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        try {
            $user->update($data);
            return response()->json($user);
        } catch (Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $user = $this->user->query()->find($id);

        if (!$user) {
            return response()->json([
                'error' => 'Ops! O usuário selecionado não foi encontrado na base de dados.'
            ], 404);
        }

        try {
            $user->delete();
            return response()->json(null, 204);
        } catch (Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function deleteAll(Request $request): JsonResponse {
        $validatedData = $request->validate(
            ['id' => 'required|array', 'id.*' => 'integer|exists:users,id',],
            ['id.required' => 'O campo id é obrigatório.', 'id.*.integer' => 'O valor do campo id deve ser um número inteiro.', 'id.*.exists' => 'A promoção informada não existe na base de dados.',]
        );

        try {
            $this->user->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

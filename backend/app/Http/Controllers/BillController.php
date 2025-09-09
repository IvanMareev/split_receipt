<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class BillController extends Controller
{
    public function __construct()
    {
        // Middleware авторизации при необходимости
        // $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
    }

    /**
     * Получить список счетов
     */
    public function index(): JsonResponse
    {
        try {
            Log::info('Fetching all bills');
            $bills = Bill::all();

            return response()->json([
                'data' => $bills,
                'message' => 'Список счетов получен'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error fetching bills: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ошибка сервера',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Создать новый счет
     */
    public function store(Request $request): JsonResponse
    {
        try {
            Log::info('Creating bill', $request->all());

            $validatedData = $request->validate([
                'creator_id' => 'required|exists:users,id',
                'total_sum' => 'required|numeric',
                'status' => 'nullable|string',
                'payment_date' => 'nullable|date',
                'description' => 'nullable|string',
            ]);

            // Приведение total_sum к float
            $validatedData['total_sum'] = (float) $validatedData['total_sum'];

            $bill = Bill::create($validatedData);

            return response()->json([
                'data' => $bill,
                'message' => 'Счет создан'
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            Log::error('Error creating bill: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ошибка сервера',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Получить конкретный счет
     */
    public function show($id): JsonResponse
    {
        try {
            $bill = Bill::findOrFail($id);

            return response()->json([
                'data' => $bill,
                'message' => 'Счет получен'
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Счет не найден'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error('Error fetching bill: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ошибка сервера',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Обновить счет
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $bill = Bill::findOrFail($id);

            $validatedData = $request->validate([
                'creator_id' => 'sometimes|exists:users,id',
                'total_sum' => 'sometimes|numeric',
                'status' => 'sometimes|string',
                'payment_date' => 'sometimes|date',
                'description' => 'sometimes|string',
            ]);

            if (isset($validatedData['total_sum'])) {
                $validatedData['total_sum'] = (float) $validatedData['total_sum'];
            }

            $bill->update($validatedData);

            return response()->json([
                'data' => $bill,
                'message' => 'Счет обновлен'
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Счет не найден'
            ], Response::HTTP_NOT_FOUND);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            Log::error('Error updating bill: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ошибка сервера',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Удалить счет
     */
    public function destroy($id): JsonResponse
    {
        try {
            $bill = Bill::findOrFail($id);
            $bill->delete();

            return response()->json([
                'message' => 'Счет удален'
            ], Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Счет не найден'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error('Error deleting bill: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ошибка сервера',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

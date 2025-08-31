<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillItem;
use Illuminate\Http\Request;

class BillItemsController extends Controller
{
    public function __construct()
    {
        // Только для store, update, destroy нужна авторизация
        // $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);

        // Или наоборот: исключить методы
        // $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    /**
     * Получить список счетов
     */
    public function index(): JsonResponse
    {
        $bills = BillItem::all();
        return response()->json([
            'data' => $bills,
            'message' => 'Список счетов получены'
        ], Response::HTTP_OK);
    }

    

    /**
     * Создать новый счет
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'creator_id' => 'required|exists:users,id', // проверка, что пользователь существует
        ]);

        $bill = Bill::create($validatedData);


        $bill = Bill::create($validatedData);

        return response()->json([
            'data' => $bill,
            'message' => 'Счет создан'
        ], Response::HTTP_CREATED);
    }

    /**
     * Получить конкретный счет
     */
    public function show(Bill $bill): JsonResponse
    {
        return response()->json([
            'data' => $bill,
            'message' => 'Счет получен'
        ], Response::HTTP_OK);
    }

    /**
     * Обновить счет
     */
    public function update(Request $request, Bill $bill): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            // другие валидации
        ]);

        $bill->update($validatedData);

        return response()->json([
            'data' => $bill,
            'message' => 'Счет обновлен'
        ], Response::HTTP_OK);
    }

    /**
     * Удалить счет
     */
    public function destroy(Bill $bill): JsonResponse
    {
        $bill->delete();

        return response()->json([
            'message' => 'Счет удален'
        ], Response::HTTP_NO_CONTENT);
    }
}

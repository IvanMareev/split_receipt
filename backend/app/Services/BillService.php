<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\BillItem;
use Illuminate\Support\Facades\DB;

class BillService
{
    /**
     * Создать счет вместе с его позициями
     */
    public function createBillWithItems(array $billData, array $itemsData)
    {
        return DB::transaction(function () use ($billData, $itemsData) {
            $bill = Bill::create($billData);

            foreach ($itemsData as $itemData) {
                $itemData['bill_id'] = $bill->id;
                BillItem::create($itemData);
            }

            return $bill->load('items');
        });
    }

    /**
     * Создать новый BillItem для существующего Bill
     *
     * @param int $billId
     * @param array $itemData
     * @return BillItem
     */
    public function createBillItem(int $billId, array $itemData): BillItem
    {
        $itemData['bill_id'] = $billId;

        return BillItem::create($itemData);
    }
}

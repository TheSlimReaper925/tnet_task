<?php

namespace App\Http\Resources;

use App\Models\Cart;
use App\Models\ProductGroupItem;
use App\Models\UserProductGroup;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "product_id" => $this->product_id,
            "quantity" => $this->quantity,
            "price" => $this->product->price,
            "discount" => $this->calculateDiscount() / 100
        ];
    }

    public function calculateDiscount() {
        $groupItems = ProductGroupItem::where('group_id', $this->groups->group_id ?? null)->with('discountGroup')->pluck('product_id');
        $discount = UserProductGroup::where('group_id',  $this->groups->group_id ?? null)->first()->discount ?? 0;
        $cartItems = Cart::whereIn('product_id', $groupItems)->count();

        return count($groupItems) == $cartItems ? $discount : 0;
    }

}

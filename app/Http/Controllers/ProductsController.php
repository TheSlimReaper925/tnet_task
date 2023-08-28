<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Http\Resources\CartResourceWithoutDiscount;
use App\Models\Product;
use App\Models\ProductGroupItem;
use App\Models\UserProductGroup;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ProductsController extends Controller
{
    /**
     * @param Request $request
     * @return string
     * @throws ValidationException
     */
    public function addProduct(Request $request): string
    {
        $this->validate($request,[
            'product_id'=>'required|numeric',
        ]);

        try {
            Cart::firstOrCreate([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);

            return "Product has added";

        } catch (\Exception $e) {
            return $e->getCode() . " - Could not add product in the cart.";
        }
    }

    /**
     * @param Request $request
     * @return string
     * @throws ValidationException
     */
    public function removeProduct(Request $request): string
    {
        $this->validate($request,[
            'product_id'=>'required|numeric',
        ]);

        try {
            Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->delete();

            return "Product has been deleted.";
        } catch (\Exception $e) {
            return $e->getCode() . " - Could not delete product from the cart";
        }
    }

    public function setProductQuantity(Request $request) {
        $this->validate($request,[
            'product_id'=>'required|numeric',
            'quantity'=>'required|numeric'
        ]);

        try {
            $product = Cart::where('product_id', $request->product_id)
                ->where('user_id', Auth::id())->first();

            if ($product) {
                $product->quantity = $request->quantity;
                $product->save();
                return "Product has been updated.";
            } else {
                return "Product is not present in the cart";
            }


        } catch (\Exception $e) {
            return $e->getCode() . " - Could not update the product";
        }
    }

    public function getCart() {
        $groupCartItems = Cart::with(['groups', 'product'])->whereHas('groups')->where('user_id', Auth::id())->get();
        $cartItems = Cart::with(['product'])->where('user_id', Auth::id())->get();
        $min_quantity = 0;
        foreach ($groupCartItems as $groupCartItem) {
            if ($min_quantity == 0 || $min_quantity > $groupCartItem->quantity) {
                $min_quantity = $groupCartItem->quantity;
            }
        }
        $cartCollection = CartResource::collection($groupCartItems);
        $array = collect($cartCollection->toArray([]));
        $index = 0;
        $saving = 0;
        foreach ($groupCartItems as $groupCartItem) {
            $saving += $min_quantity * $array[$index]["price"] * $array[0]["discount"];
            $index++;
        }

        return response()->json([
            "products" => CartResourceWithoutDiscount::collection($cartItems)->toArray([]),
            "discount" => $saving
        ]);
    }
}

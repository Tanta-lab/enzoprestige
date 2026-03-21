<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart.index', [
            'cart' => $cart
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $qty = (int) $request->input('quantity', 1);

        if ($qty < 1) {
            $qty = 1;
        }

        if ($product->stock <= 0) {
            return redirect()->route('products.index')->with('error', 'Produit en rupture de stock');
        }

        $cart = session()->get('cart', []);

        $currentQty = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;
        $newQty = $currentQty + $qty;

        if ($newQty > $product->stock) {
            return redirect()->route('products.index')->with('error', 'Quantité demandée supérieure au stock disponible');
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $qty
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produit retiré');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Panier vide');
        }

        return DB::transaction(function () use ($cart) {

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'pending'
            ]);

            foreach ($cart as $item) {

                $product = Product::lockForUpdate()->findOrFail($item['id']);

                if ($product->stock < $item['quantity']) {
                    return redirect()
                        ->route('cart.index')
                        ->with('error', "Stock insuffisant pour {$product->name}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            session()->forget('cart');

            return redirect()->route('products.index')->with('success', 'Commande créée');
        });
    }
}

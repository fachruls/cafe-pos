<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosPage extends Component
{
    public $search = '';
    public $category_id = null;
    public $cart = []; 
    public $customer_name;
    public $payment_method = 'cash';
    public $grand_total = 0;

    public function addToCart($productId)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['qty']++;
        } else {
            $this->cart[$productId] = ['qty' => 1, 'note' => ''];
        }
    }

    public function updateQty($productId, $change)
    {
        if (!isset($this->cart[$productId])) return;
        $newQty = $this->cart[$productId]['qty'] + $change;
        if ($newQty > 0) {
            $this->cart[$productId]['qty'] = $newQty;
        } else {
            unset($this->cart[$productId]);
        }
    }

    public function updateNote($productId, $note)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['note'] = $note;
        }
    }

    public function getCartDetailsProperty()
    {
        if (empty($this->cart)) return collect([]);
        $products = Product::whereIn('id', array_keys($this->cart))->get();
        
        $cartCollection = $products->map(function ($product) {
            $qty = $this->cart[$product->id]['qty'];
            return (object) [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $qty,
                'note' => $this->cart[$product->id]['note'],
                'subtotal' => $product->price * $qty,
            ];
        });
        
        $this->grand_total = $cartCollection->sum('subtotal');
        return $cartCollection;
    }

    public function checkout()
    {
        $this->validate([
            'cart' => 'required|array|min:1',
            'payment_method' => 'required',
        ]);

        DB::transaction(function () {
            $shift = Auth::user()->activeShift()->first();
            $order = Order::create([
                'shift_id' => $shift->id,
                'user_id' => Auth::id(),
                'customer_name' => $this->customer_name ?? 'Guest',
                'total_amount' => $this->grand_total,
                'payment_method' => $this->payment_method,
                'status' => 'paid',
                'table_id' => null,
            ]);

            foreach ($this->getCartDetailsProperty() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'quantity' => $item->qty,
                    'price' => $item->price,
                    'note' => $item->note,
                ]);
            }

            if ($this->payment_method === 'cash') {
                $shift->increment('expected_cash', $this->grand_total);
            }
        });

        $this->cart = [];
        $this->customer_name = '';
        session()->flash('success', 'Transaksi berhasil!');
    }

    public function render()
    {
        $products = Product::query()
            ->where('is_active', true)
            ->when($this->category_id, fn($q) => $q->where('category_id', $this->category_id))
            ->when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->get();

        return view('livewire.pos-page', [
            'products' => $products,
            'categories' => Category::all(),
            'cartItems' => $this->getCartDetailsProperty(),
        ])->layout('components.layouts.app');
    }
}
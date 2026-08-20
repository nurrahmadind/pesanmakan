<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan katalog makanan untuk pelanggan (Halaman Utama).
     */
    public function index()
    {
        $foods = Food::all();
        return view('customer.index', compact('foods'));
    }

    /**
     * Memproses checkout pesanan pelanggan.
     */
    public function store(Request $request)
    {
        // Validasi data pemesan dan item yang dipilih
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number'  => 'required|integer|min:1',
            'items'         => 'required|array',
            'items.*'       => 'nullable|integer|min:0',
        ]);

        // Filter hanya makanan yang jumlah/qty dipesan > 0
        $orderedItems = array_filter($request->items, fn($qty) => $qty > 0);

        if (empty($orderedItems)) {
            return back()->with('error', 'Pilih minimal satu menu makanan!');
        }

        // Gunakan DB Transaction agar penyimpanan data order & detail aman
        DB::beginTransaction();
        try {
            // 1. Simpan Header Order
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'table_number'  => $request->table_number,
                'total_price'   => 0, // Dihitung di bawah
                'status'        => 'pending',
            ]);

            $totalPrice = 0;

            // 2. Simpan Detail Order & Hitung Subtotal
            foreach ($orderedItems as $foodId => $quantity) {
                $food = Food::findOrFail($foodId);
                $subtotal = $food->price * $quantity;
                $totalPrice += $subtotal;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'food_id'  => $food->id,
                    'quantity' => $quantity,
                    'price'    => $food->price,
                ]);
            }

            // 3. Update Total Harga di Header Order
            $order->update(['total_price' => $totalPrice]);

            DB::commit();

            return redirect()->route('customer.index')->with('success', 'Pesanan berhasil dibuat! Nomor Meja: ' . $order->table_number);
        } catch (\Exception $e) {
            DB::rollBack();
            // Hentikan eksekusi dan tampilkan pesan error detail
            dd($e->getMessage(), $e->getTraceAsString());
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

  /**
     * Menampilkan rekap pesanan di Dashboard Admin.
     */
    public function adminDashboard()
    {

        // Mengambil seluruh pesanan beserta detail item & data makanan terkait (diurutkan dari yang terbaru)
        $orders = Order::with('orderDetails.food')->latest()->get();
        return view('dashboard', compact('orders'));
    }

    /**
     * Update status pesanan oleh Admin.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan #' . $order->id . ' berhasil diperbarui!');
    }
}
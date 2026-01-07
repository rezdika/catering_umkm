<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payments()->exists()) {
            return redirect()->back()->with('error', 'Pembayaran sudah pernah diupload untuk pesanan ini');
        }

        $request->validate([
            'payment_method' => 'required|in:bank_transfer,qris,cod',
            'payment_proof' => 'required_unless:payment_method,cod|image|mimes:jpeg,png,jpg|max:2048',
            'sender_name' => 'required_unless:payment_method,cod|string|max:255'
        ], [
            'payment_proof.required_unless' => 'Bukti pembayaran wajib diupload',
            'sender_name.required_unless' => 'Nama pengirim wajib diisi'
        ]);

        $paymentProof = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProof = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'payment_method' => $request->payment_method,
            'payment_proof' => $paymentProof,
            'sender_name' => $request->sender_name,
            'status' => $request->payment_method === 'cod' ? 'verified' : 'pending',
            'notes' => $this->getPaymentNotes($request->payment_method)
        ]);

        // Update order payment status
        $order->update([
            'payment_status' => $request->payment_method === 'cod' ? 'verified' : 'pending'
        ]);

        $message = $request->payment_method === 'cod' 
            ? 'Pembayaran COD berhasil dikonfirmasi. Pesanan akan diproses segera.' 
            : 'Bukti pembayaran berhasil diunggah. Tim keuangan akan memverifikasi dalam 1x24 jam.';

        return redirect()->route('user.orders.show', $order)->with('success', $message);
    }

    private function getPaymentNotes($method)
    {
        return match($method) {
            'bank_transfer' => 'Pembayaran melalui transfer bank - menunggu konfirmasi tim keuangan',
            'qris' => 'Pembayaran melalui QRIS - menunggu konfirmasi tim keuangan', 
            'cod' => 'Pembayaran tunai saat pengiriman - telah dikonfirmasi',
            default => 'Pembayaran dalam proses verifikasi'
        };
    }
}
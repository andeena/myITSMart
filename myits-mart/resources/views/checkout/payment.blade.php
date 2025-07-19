@extends('layouts.app')

@section('title', 'Proses Pembayaran')

@section('content')
<div class="container text-center py-5">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <h2 class="mb-2 mt-4">Menyiapkan Sesi Pembayaran...</h2>
    <p class="text-muted">Jendela pembayaran akan segera muncul. Mohon jangan menutup halaman ini.</p>
    
    <button id="pay-button" class="btn btn-primary btn-lg mt-3 d-none">Bayar Sekarang!</button>

    <div class="card mt-4 mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h6 class="card-title">Ringkasan</h6>
            <p class="card-text text-muted">
                Anda akan melakukan pembayaran untuk Pesanan #{{ request()->route('order')?->id ?? '' }}
            </p>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('dashboard.orders') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat Pesanan
        </a>
    </div>

</div>
@endsection

@push('scripts')
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
            
    <script type="text/javascript">
        function triggerPayment() {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    window.location.href = "{{ route('dashboard.orders') }}?payment=success";
                },
                onPending: function(result){
                    window.location.href = "{{ route('dashboard.orders') }}?payment=pending";
                },
                onError: function(result){
                    window.location.href = "{{ route('dashboard.orders') }}?payment=error";
                },
                onClose: function(){
                    console.log('Popup pembayaran ditutup.');
                }
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            triggerPayment();
        });

        document.getElementById('pay-button').addEventListener('click', function () {
            triggerPayment();
        });
    </script>
@endpush
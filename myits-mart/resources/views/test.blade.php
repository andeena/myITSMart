@extends('layouts.app')

@section('title', 'Test Modal')

@section('content')
    <div class="container py-5">
        <h1>Halaman Tes Modal</h1>
        <p>Jika popup di bawah ini muncul dengan benar (lengkap dengan backdrop gelap), berarti file `app.blade.php` dan JavaScript Bootstrap Anda sudah benar.</p>
        
        <!-- Tombol untuk memicu modal -->
        <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#testModal">
          Buka Popup Tes
        </button>
    </div>

    <!-- Modal itu sendiri -->
    <div class="modal fade" id="testModal" tabindex="-1" aria-labelledby="testModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="testModalLabel">Modal Tes Berhasil!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Ini adalah isi dari popup. Backdrop gelapnya muncul dengan benar.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
@endsection
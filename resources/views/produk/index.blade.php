@extends('layouts.app')

@section('content')
    <h2 class="page-header">Data Produk</h2>
    <a onclick="addForm()" class="btn btn-primary">Tambah</a> <br> <br>


    <!-- membuat Table -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th style="width: 100px;">Aksi</th>
            </tr>
        </thead>

    </table>
@endsection

@section('css')
@endsection

@section('js')
@endsection

@extends('member.layouts.master')

@section('title', 'Home')

@section('pembelian-tab', 'active')

@section('content')
    {{-- Konten halaman home --}}
    <div id="home" class="row">
        {{-- Bagian Services --}}
        @include('member.pages.pembelian.pelatihan')
        {{-- {{ $pelatihan->links() }} --}}
        

    </div>
@endsection

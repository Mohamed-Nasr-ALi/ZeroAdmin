@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container animated fadeInUp">
        @include('admin.send_money.send_form')
        <div class="mt-3">
            @include('admin.transactions.all_transactions')
        </div>
    </div>
    @push('js')
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="/js/admin/send_money/jquery.ccpicker.js"></script>
    @endpush
    @push('css')
        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/style/countrypicker.css">
    @endpush
@endsection


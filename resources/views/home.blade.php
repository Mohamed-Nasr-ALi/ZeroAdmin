@extends('layouts.app')
@include('layouts.aside')
@section('content')
<div class="container mb-2 animated zoomIn">
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-12">
                    <canvas id="labelChart"></canvas>
                </div>
                <div class="col-sm-12">
                    @include('admin.analytics.topClients',['topUsers'=>$topUsers])
                    @include('admin.analytics.topAgents',['topAgents'=>$topAgents])
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="col-sm-12">
        <canvas id="horizontalBar"></canvas>
    </div>
</div>
@push('js')
    <!-- Scripts -->
    <script src="/js/admin/analytics/transaction-analytics.js"></script>
    <script src="/js/admin/analytics/all-analytics-chart.js"></script>
    <script src="/js/admin/analytics/total-analytics.js"></script>
@endpush
@endsection


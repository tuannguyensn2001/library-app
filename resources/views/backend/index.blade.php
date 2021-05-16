@extends('backend.master')

@push('css')
    <style>

    </style>
    @endpush

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $data['order_not_done']}}</h3>

                    <p>{{trans('index.order_not_done')}}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="{{route('statistic',['type' => 'order_not_done'])}}" class="small-box-footer">
                    {{trans('action.more')}} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $data['books']}}</h3>

                    <p>{{trans('index.books')}}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('statistic',['type' => 'books'])}}" class="small-box-footer">
                    {{trans('action.more')}}<i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $data['reader_ordering']}}</h3>

                    <p>{{trans('index.reader_ordering')}}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="{{route('statistic',['type' => 'reader_ordering'])}}" class="small-box-footer">
                    {{trans('action.more')}} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$data['reader_order_late']}}</h3>

                    <p>{{trans('index.reader_order_late')}}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <a href="{{route('statistic',['type' => 'reader_order_late'])}}" class="small-box-footer">
                    {{trans('action.more')}} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
    </div>
@endsection

@push('scripts')
    <script src="{{asset('assets/dist/js/pages/dashboard.js')}}"></script>
    <script>

    </script>
@endpush

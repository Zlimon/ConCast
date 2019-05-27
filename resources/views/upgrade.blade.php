@extends('layouts.layout')

@section('title')
    | {{ __('title.upgrade') }}
@endsection

@section('content')
    <div class="col-md-12">
        <h1 class="modal-header">{{ __('title.upgrade') }}</h1>

        <div class="card-deck">
            <div class="card">
                <div class="card-header">Low-tier plan</div>
                
                <div class="card-body">
                    <ul>
                        <li>Remove banner ads</li>
                    </ul>
                </div>

                <div class="card-footer text-center"><i class="fab fa-bitcoin"></i>1 BTC</div>
            </div>

            <div class="card">
                <div class="card-header">Medium-tier plan</div>
                
                <div class="card-body">
                    <ul>
                        <li>Remove all ads</li>
                    </ul>
                </div>

                <div class="card-footer text-center"><i class="fab fa-bitcoin"></i>5 BTC</div>
            </div>

            <div class="card">
                <div class="card-header">High-tier plan</div>
                
                <div class="card-body">
                    <ul>
                        <li>Ascended</li>
                    </ul>
                </div>

                <div class="card-footer text-center"><i class="fab fa-bitcoin"></i>10 BTC</div>
            </div>
        </div>
    </div>
@endsection
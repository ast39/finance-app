@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Новая транзакция'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить транзакцию') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('wallet.payment.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="walletTitle" class="form-label">{{ __('Кошелек') }}</label>
                                <div class="input-group">
                                    <input type="text" readonly disabled class="form-control" id="walletTitle" name="walletTitle" placeholder="Мой кошелек" value="{{ old('title') ?? $wallet->title }}" aria-describedby="walletTitleHelp">
                                    <span class="input-group-text">{{ $wallet->currency['abbr'] }}</span>
                                </div>
                                <div id="walletTitleHelp" class="form-text mb-3">{{ __('Название Вашего кошелька') }}</div>
                                @error('wallet_id')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label">{!! Icons::get(Icons::NOTE) !!} {{ __('Описание') }}</label>
                                <textarea class="form-control" id="note" name="note" placeholder="Описание транзакции" rows="5" aria-describedby="noteHelp">{{ old('note') }}</textarea>
                                <div id="noteHelp" class="form-text">Заметка о назначении транзакции</div>
                                @error('note')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">{{ __('Сумма') }}</label>
                                <div class="input-group">
                                    <input type="hidden" readonly name="wallet_id" value="{{ old('wallet_id') ?? $wallet->wallet_id }}">
                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="1234.56" value="{{ old('amount') ?? '' }}" aria-describedby="amountHelp">
                                    <span class="input-group-text">{{ $wallet->currency['abbr'] }}</span>
                                </div>
                                <div id="amountHelp" class="form-text mb-3">{{ __('Укажите сумму пополнения или снятия (с минусом)') }}</div>
                                @error('amount')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-md-2">{{ __('Назад') }}</a>
                                    <button type="submit" class="btn btn-primary">{{ __('Добавить') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Новый кошелек'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить кошелек') }}</div>

                    <div class="card-body">

                        {{--Форма добавления кошелька --}}
                        <form method="post" action="{{ route('wallet.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="currency_id" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Валюта') }}</label>
                                <select name="currency_id" id="currency_id" class="form-select form-control" aria-describedby="currency_idHelp">
                                    @forelse($currencies as $currency)
                                        <option title="{{ $currency->title }}" value="{{ $currency->currency_id }}">{{ $currency->abbr }}</option>
                                    @empty
                                        <option value="1">{{ __('RUB') }}</option>
                                    @endforelse
                                </select>
                                <div id="currency_idHelp" class="form-text">{{ __('Валюта кошелька') }}</div>
                                @error('currency_idHelp')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="{{ __('Мой новый кошелек') }}" value="{{ old('title') }}" aria-describedby="titleHelp">
                                <div id="titleHelp" class="form-text">{{ __('Лейбл Вашего кошелька для простоты идентификации') }}</div>
                                @error('title')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label">{!! Icons::get(Icons::NOTE) !!} {{ __('Описание') }}</label>
                                <textarea class="form-control" id="note" name="note" placeholder="{{ __('Описание кошелька') }}" rows="5" aria-describedby="noteHelp">{{ old('note') }}</textarea>
                                <div id="noteHelp" class="form-text">{{ __('Заметка о назначении кошелька') }}</div>
                                @error('note')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="250000" value="{{ old('amount') }}" aria-describedby="amountHelp">
                                    <span class="input-group-text">{{ __('руб.') }}</span>
                                </div>
                                <div id="amountHelp" class="form-text mb-3">{{ __('Начальная сумма в кошельке') }}</div>
                                @error('amount')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('wallet.index') }}" class="btn btn-secondary me-md-2">{{ __('Назад') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Добавить') }}</button>
                            </div>
                        </form>

                        {{-- Ошибки если есть --}}
                        @if(count($errors) > 0)
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

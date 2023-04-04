@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Обновление кошелька : ' . $wallet->title))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Изменить кошелек') }}</div>

                    <div class="card-body">

                        {{-- Форма редактирования кошелька --}}
                        <form method="post" action="{{ route('wallet.update', $wallet->wallet_id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $wallet->title }}" aria-describedby="titleHelp">
                                <div id="titleHelp" class="form-text">{{ __('Лейбл Вашего кошелька для простоты идентификации') }}</div>
                                @error('title')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label">{!! Icons::get(Icons::NOTE) !!} {{ __('Описание') }}</label>
                                <textarea class="form-control" id="note" name="note" placeholder="{{ __('Назначение кошелька') }}" rows="5" aria-describedby="noteHelp">{{ $wallet->note }}</textarea>
                                <div id="safeNoteHelp" class="form-text">{{ __('Заметка о назначении кошелька') }}</div>
                                @error('note')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">{!! Icons::get(Icons::BALANCE) !!} {{ __('Баланс') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="250000" value="{{ $wallet->amount }}" aria-describedby="amountHelp">
                                    <span class="input-group-text">руб.</span>
                                </div>
                                <div id="amountHelp" class="form-text mb-3">{{ __('Начальная сумма в кошельке') }}</div>
                                @error('amount')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('wallet.index') }}" class="btn btn-secondary me-md-2">{{ __('Назад') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Сохранить') }}</button>
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

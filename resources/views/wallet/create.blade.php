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
                        <form method="post" action="{{ route('wallet.list.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="safeTitle" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" class="form-control" id="safeTitle" name="title" placeholder="{{ __('Мой новый кошелек') }}" value="{{ old('title') }}" aria-describedby="safeTitleHelp">
                                <div id="safeTitleHelp" class="form-text">{{ __('Лейбл Вашего кошелька для простоты идентификации') }}</div>
                                @error('title')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="safeNote" class="form-label">{!! Icons::get(Icons::NOTE) !!} {{ __('Описание') }}</label>
                                <textarea class="form-control" id="safeNote" name="note" placeholder="{{ __('Описание кошелька') }}" rows="5" aria-describedby="safeNoteHelp">{{ old('note') }}</textarea>
                                <div id="safeNoteHelp" class="form-text">{{ __('Заметка о назначении кошелька') }}</div>
                                @error('title')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="safeAmount" class="form-label">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="safeAmount" name="amount" placeholder="250000" value="{{ old('amount') }}" aria-describedby="safeAmountHelp">
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                            <div id="safeAmountHelp" class="form-text mb-3">{{ __('Начальная сумма в кошельке') }}</div>
                            @error('amount')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('wallet.list.index') }}" class="btn btn-secondary me-md-2">{{ __('Назад') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Добавить') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

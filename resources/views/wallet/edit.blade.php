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

                        {{-- ФОрма редактирования кошелька --}}
                        <form method="post" action="{{ route('wallet.list.update', $wallet->wallet_id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="safeTitle" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" class="form-control" id="safeTitle" name="title" placeholder="{{ __('Мой новый сейф') }}" value="{{ $wallet->title }}" aria-describedby="safeTitleHelp">
                                <div id="safeTitleHelp" class="form-text">{{ __('Лейбл Вашего кошелька для простоты идентификации') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="safeNote" class="form-label">{!! Icons::get(Icons::NOTE) !!} {{ __('Описание') }}</label>
                                <textarea class="form-control" id="safeNote" name="note" placeholder="{{ __('Назначение кошелька') }}" rows="5" aria-describedby="safeNoteHelp">{{ $wallet->note }}</textarea>
                                <div id="safeNoteHelp" class="form-text">{{ __('Заметка о назначении кошелька') }}</div>
                            </div>

                            <label for="safeAmount" class="form-label">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="safeAmount" name="amount" placeholder="250000" value="{{ $wallet->amount }}" aria-describedby="safeTitleHelp">
                                <span class="input-group-text">руб.</span>
                            </div>
                            <div id="safeAmountHelp" class="form-text mb-3">{{ __('Начальная сумма в кошельке') }}</div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('wallet.list.index') }}" class="btn btn-secondary me-md-2">{{ __('Назад') }}</a>
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

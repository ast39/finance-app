@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Новый расход'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить расход') }}</div>
                    <div class="card-body">

                        {{--Форма добавления расхода --}}
                        <form method="post" action="{{ route('spend.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="wallet_id" class="form-label">{!! Icons::get(Icons::WALLET) !!} {{ __('Кошелек') }}</label>
                                <select name="wallet_id" id="wallet_id" class="form-select form-control" aria-describedby="wallet_idHelp">
                                    @forelse($wallets as $wallet)
                                        <option value="{{ $wallet['wallet_id'] }}">{{ $wallet['title'] }} ({{ number_format($wallet['balance'], 2, '.', ' ') }} {{ $wallet['currency']['abbr'] }})</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div id="wallet_idHelp" class="form-text">{{ __('С какого кошелька платим') }}</div>
                                @error('wallet_id')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">{!! Icons::get(Icons::CATEGORY) !!} {{ __('Категория') }}</label>
                                <div class="input-group mb-3">
                                    <select name="category_id" id="category_id" class="form-select form-control" aria-describedby="category_idHelp">
                                        @forelse($categories as $category)
                                            <option value="{{ $category->category_id }}">{{ $category->title }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <a href="{{ route('spend.category.create') }}" class="btn btn-outline-secondary" type="button" id="button-addon2">{!! Icons::get(Icons::PLUS) !!}</a>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label">{!! Icons::get(Icons::NOTE) !!} {{ __('Описание') }}</label>
                                <textarea class="form-control" id="note" name="note" placeholder="{{ __('Описание кошелька') }}" rows="5" aria-describedby="noteHelp">{{ old('note') }}</textarea>
                                <div id="noteHelp" class="form-text">{{ __('Заметка о назначении платежа') }}</div>
                                @error('note')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">{!! Icons::get(Icons::BALANCE) !!} {{ __('Сумма') }}</label>
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="1000" value="{{ old('amount') }}" aria-describedby="amountHelp">
                                <div id="amountHelp" class="form-text mb-3">{{ __('Сумма платежа') }}</div>
                                @error('amount')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <a href="{{ route('spend.index') }}" class="btn btn-secondary me-md-2">{!! Icons::get(Icons::RETURN) !!} {{ __('Назад') }}</a>
                                    <button type="submit" class="btn btn-primary">{!! Icons::get(Icons::CREATE) !!} {{ __('Добавить') }}</button>
                                </div>
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

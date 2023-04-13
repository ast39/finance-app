@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Новый кредит'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить кредит') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('credit.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="creditTitle" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" class="form-control" id="creditTitle" name="title" placeholder="{{ __('Мой новый кредит') }}" value="{{ old('title') }}" aria-describedby="creditTitleHelp">
                                <div id="creditTitleHelp" class="form-text">{{ __('Лейбл Вашего кредита для простоты идентификации') }}</div>
                                @error('title')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="currency" class="form-label">{!! Icons::get(Icons::CURRENCY) !!} {{ __('Валюта') }}</label>
                                <select class="form-select" id="currency" name="currency" aria-describedby="currencyHelp">
                                    @forelse($currencies as $currency)
                                        <option {{ old('currency') == $currency->abbr ? 'selected': '' }} value="{{ $currency->abbr }}">{{ $currency->abbr }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div id="currencyHelp" class="form-text">{{ __('В какой валюте вклад') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="creditCreditor" class="form-label">{!! Icons::get(Icons::BANK) !!} {{ __('Кредитор') }}</label>
                                <input type="text" class="form-control" id="creditCreditor" name="creditor" placeholder="{{ __('Новый банк') }}" value="{{ old('creditor') }}" aria-describedby="creditCreditorHelp">
                                <div id="creditCreditorHelp" class="form-text">{{ __('Кто выдает кредит / займ') }}</div>
                                @error('creditor')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="creditStart" class="form-label">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('Дата взятия кредита') }}</label>
                                <input type="date" class="form-control" id="creditStart" name="start_date" value="{{ old('start_date') }}" />
                                @error('start_date')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="creditPayDay" class="form-label">{!! Icons::get(Icons::CALENDAR) !!} {{ __('Дата первого платежа') }}</label>
                                <input type="date" class="form-control" id="creditPayDay" name="payment_date" value="{{ old('payment_date') }}" />
                                @error('payment_date')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="creditAmount" class="form-label">{!! Icons::get(Icons::BALANCE) !!} {{ __('Сумма') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="creditAmount" name="amount" placeholder="250000" value="{{ old('amount') }}">
                                    <span class="input-group-text currency">{{ __('RUB') }}</span>
                                </div>
                                @error('amount')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="creditPercent" class="form-label">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="creditPercent" name="percent" placeholder="14.9" value="{{ old('percent') }}">
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('percent')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="creditPeriod" class="form-label">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="creditPeriod" name="period" placeholder="36" value="{{ old('period') }}">
                                    <span class="input-group-text">{{ __('месяцев') }}</span>
                                </div>
                                @error('period')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="creditPayment" class="form-label">{!! Icons::get(Icons::BALANCE_START) !!} {{ __('Платеж') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="creditPayment" name="payment" placeholder="8654.09" value="{{ old('payment') }}" aria-describedby="creditPaymentHelp">
                                    <span class="input-group-text currency">{{ __('RUB') }}</span>
                                </div>
                                <div id="creditPaymentHelp" class="form-text mb-3">{{ __('Ваш ежемесячный платеж по кредиту') }}</div>
                                @error('payment')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <a href="{{ route('credit.index') }}" class="btn btn-secondary me-md-2">{!! Icons::get(Icons::RETURN) !!} {{ __('Назад') }}</a>
                                    <button type="submit" class="btn btn-primary">{!! Icons::get(Icons::CREATE) !!} {{ __('Добавить') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script type="module">
            $(document).ready(function() {
                $('#currency').change(function() {
                    $('.currency').html($(this).val());
                });
            });
        </script>
    @endpush
@endsection

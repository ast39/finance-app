@php
    use App\Libs\PlowBack;
    use App\Libs\Helper;
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Изменить вклад ' . $credit->title))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Изменить кредит') }}</div>

                    <div class="card-body">

                        <form action="{{ route('credit.update', $credit->credit_id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="creditTitle" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" class="form-control" id="creditTitle" name="title" value="{{ $credit->title ?? '' }}" placeholder="Мой новый кредит" aria-describedby="creditTitleHelp">
                                <div id="creditTitleHelp" class="form-text">{{ __('Лейбл Вашего кредита для простоты идентификации') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="currency" class="form-label">{!! Icons::get(Icons::CURRENCY) !!} {{ __('Валюта') }}</label>
                                <select class="form-select" id="currency" name="currency" aria-describedby="currencyHelp">
                                    @forelse($currencies as $currency)
                                        <option {{ $credit->currency == $currency->abbr ? 'selected': '' }} value="{{ $currency->abbr }}">{{ $currency->abbr }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div id="currencyHelp" class="form-text">{{ __('В какой валюте кредит') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="creditCreditor" class="form-label">{!! Icons::get(Icons::BANK) !!} {{ __('Кредитор') }}</label>
                                <input type="text" class="form-control" id="creditCreditor" name="creditor" value="{{ $credit->creditor ?? '' }}" placeholder="Новый банк" aria-describedby="creditCreditorHelp">
                                <div id="creditCreditorHelp" class="form-text">{{ __('Кто выдает кредит / займ') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="creditStart" class="form-label">{!! Icons::get(Icons::CALENDAR_MONTH) !!} {{ __('День взятия кредита') }}</label>
                                <input type="date" class="form-control" id="creditStart" name="start_date" value="{{ date('Y-m-d', $credit->start_date) }}" />
                            </div>

                            <div class="mb-3">
                                <label for="creditPayDay" class="form-label">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('День первого платежа') }}</label>
                                <input type="date" class="form-control" id="creditPayDay" name="payment_date" value="{{ date('Y-m-d', $credit->payment_date) }}" />
                            </div>

                            <label for="creditAmount" class="form-label">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="creditAmount" name="amount" value="{{ $credit->amount ?? '' }}" placeholder="250000">
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>

                            <label for="creditPercent" class="form-label">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="creditPercent" name="percent" value="{{ $credit->percent ?? '' }}" placeholder="14.9">
                                <span class="input-group-text">%</span>
                            </div>

                            <label for="creditPeriod" class="form-label">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="creditPeriod" name="period" value="{{ $credit->period ?? '' }}" placeholder="36">
                                <span class="input-group-text">{{ __('месяцев') }}</span>
                            </div>

                            <label for="creditPayment" class="form-label">{!! Icons::get(Icons::PAYMENT) !!} {{ __('Платеж') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="creditPayment" name="payment" value="{{ $credit->payment ?? '' }}" placeholder="8654.09" aria-describedby="creditPaymentHelp">
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                            <div id="creditPaymentHelp" class="form-text mb-3">{{ __('Ваш ежемесячный платеж по кредиту') }}</div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('credit.index') }}" class="btn btn-secondary me-md-2">{{ __('Назад') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Сохранить') }}</button>
                            </div>

                        </form>

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

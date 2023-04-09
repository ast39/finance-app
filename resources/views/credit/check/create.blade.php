@php
    use App\Libs\CreditSubject;
    use App\Libs\PaymentType;
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Новая проверка кредита'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Проверить кредит') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('credit.check.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" readonly class="form-control" id="title" name="title" value="{{ __('Расчет от') }} {{ date('d-m-Y H:i:s') }}" aria-describedby="amountHelp">
                            </div>

                            <div class="mb-3">
                                <label for="currency" class="form-label">{!! Icons::get(Icons::CURRENCY) !!} {{ __('Валюта') }}</label>
                                <select class="form-select" id="currency" name="currency" aria-describedby="currencyHelp">
                                    @forelse($currencies as $currency)
                                        <option {{ old('currency') == $currency->abbr ? 'selected': '' }} value="{{ $currency->abbr }}">{{ $currency->abbr }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div id="currencyHelp" class="form-text">{{ __('В какой валюте кредит') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="250000" value="{{ old('amount') }}" aria-describedby="amountHelp">
                                    <span class="input-group-text currency">{{ __('RUB') }}</span>
                                </div>
                                <div id="amountHelp" class="form-text mb-3">{{ __('Сумма кредита') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="percent" class="form-label">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="percent" name="percent" placeholder="14.9" value="{{ old('percent') }}" aria-describedby="percentHelp">
                                    <span class="input-group-text">%</span>
                                </div>
                                <div id="percentHelp" class="form-text mb-3">{{ __('Процент по кредиту') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="period" class="form-label">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="period" name="period" placeholder="36" value="{{ old('period') }}" aria-describedby="periodHelp">
                                    <span class="input-group-text">{{ __('месяцев') }}</span>
                                </div>
                                <div id="periodHelp" class="form-text mb-3">{{ __('Срок кредита в месяцах') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="payment" class="form-label">{!! Icons::get(Icons::PAYMENT) !!} {{ __('Платеж') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="payment" name="payment" placeholder="8654.09" value="{{ old('payment') }}" aria-describedby="creditPaymentHelp">
                                    <span class="input-group-text currency">{{ __('RUB') }}</span>
                                </div>
                                <div id="creditPaymentHelp" class="form-text mb-3">{{ __('Ваш ежемесячный платеж по кредиту') }}</div>
                            </div>

                            <div class="mb-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <button type="submit" class="btn btn-primary">{{ __('Проверить') }}</button>
                                </div>
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

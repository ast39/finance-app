@php
    use App\Libs\CreditSubject;
    use App\Libs\PlowBack;
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Новый расчет вклада'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Рассчитать вклад') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('deposit.calc.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="depositTitle" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" readonly class="form-control" id="depositTitle" name="title" placeholder="Мой новый кредит" value="Расчет от {{ date('d-m-Y H:i:s') }}">
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
                                <label for="start_date" class="form-label">{!! Icons::get(Icons::CALENDAR_MONTH) !!} {{ __('День открытия вклада') }}</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" aria-describedby="start_dateHelp" />
                                <div id="start_dateHelp" class="form-text mb-3">{{ __('Когда открыли вклад') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control subjects" id="amount" name="amount" placeholder="250000" value="{{ old('amount') }}" aria-describedby="amountHelp" />
                                    <span class="input-group-text currency">{{ __('RUB') }}</span>
                                </div>
                                <div id="amountHelp" class="form-text mb-3">{{ __('Сумма кредита') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="percent" class="form-label">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control subjects" id="percent" name="percent" placeholder="5.9" value="{{ old('percent') }}" aria-describedby="percentHelp" />
                                    <span class="input-group-text">%</span>
                                </div>
                                <div id="percentHelp" class="form-text mb-3">{{ __('Процент по кредиту') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="period" class="form-label">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control subjects" id="period" name="period" placeholder="24" value="{{ old('period') }}" aria-describedby="periodHelp" />
                                    <span class="input-group-text">месяцев</span>
                                </div>
                                <div id="periodHelp" class="form-text mb-3">{{ __('Срок кредита в месяцах') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="refill" class="form-label">{!! Icons::get(Icons::PAYMENT) !!} {{ __('Пополнение') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="refill" name="refill" placeholder="10000" value="{{ old('refill') }}" aria-describedby="refillHelp">
                                    <span class="input-group-text currency">{{ __('RUB') }}</span>
                                </div>
                                <div id="refillHelp" class="form-text mb-3">{{ __('Сумма ежемесячного пополнения вклада') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="capitalization" class="form-label">{!! Icons::get(Icons::CAPITALIZATION) !!} {{ __('Капитализация') }}</label>
                                <select class="form-select" id="capitalization" name="capitalization" aria-label="Default select example" aria-describedby="capitalizationHelp">
                                    <option {{ old('capitalization') == PlowBack::WITHOUT ? 'selected': '' }} value="{{ PlowBack::WITHOUT }}">{{ __('При закрытии кредита') }}</option>
                                    <option {{ old('capitalization') == PlowBack::DAILY   ? 'selected': '' }} value="{{ PlowBack::DAILY }}">{{ __('Ежедневно') }}</option>
                                    <option {{ old('capitalization') == PlowBack::WEEKLY  ? 'selected': '' }} value="{{ PlowBack::WEEKLY }}">{{ __('Еженедельно') }}</option>
                                    <option {{ old('capitalization') == PlowBack::MONTHLY ? 'selected': '' }} value="{{ PlowBack::MONTHLY }}">{{ __('Раз в месяц') }}</option>
                                    <option {{ old('capitalization') == PlowBack::YEARLY  ? 'selected': '' }} value="{{ PlowBack::YEARLY }}">{{ __('Раз в год') }}</option>
                                </select>
                                <div id="capitalizationHelp" class="form-text">{{ __('Период капитализации процентов') }}</div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" {{ old('withdrawal') > 0 ? 'checked' : '' }} class="form-check-input" id="withdrawal" name="withdrawal" aria-describedby="withdrawalHelp">
                                <label class="form-check-label" for="withdrawal">{!! Icons::get(Icons::WITHDRAWAL) !!} {{ __('Снимать проценты') }}</label>
                                <div id="withdrawalHelp" class="form-text">{{ __('Снимать ежемесячно проценты или капитализировать во вклад') }}</div>
                            </div>

                            <div class="mb-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <button type="submit" class="btn btn-primary">{{ __('Рассчитать') }}</button>
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

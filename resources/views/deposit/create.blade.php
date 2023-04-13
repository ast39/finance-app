@php
    use App\Libs\PlowBack;
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Новый вклад'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить вклад') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('deposit.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="title" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Мой новый вклад" value="{{ old('title') }}" aria-describedby="titleHelp">
                                <div id="titleHelp" class="form-text">Лэйбл Вашего вклада для простоты идентификации</div>
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
                                <label for="depositor" class="form-label">{!! Icons::get(Icons::BANK) !!} {{ __('Объект инвестиции') }}</label>
                                <input type="text" class="form-control" id="depositor" name="depositor" placeholder="Новый банк" value="{{ old('depositor') }}" aria-describedby="depositorHelp">
                                <div id="depositorHelp" class="form-text">Куда вы вложил средства</div>
                                @error('depositor')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start_date" class="form-label">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('День открытия') }}</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" aria-describedby="start_dateHelp" />
                                <div id="start_dateHelp" class="form-text">День открытия вклада</div>
                                @error('start_date')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">{!! Icons::get(Icons::BALANCE) !!} {{ __('Сумма') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="250000" value="{{ old('amount') }}">
                                    <span class="input-group-text currency">{{ __('RUB') }}</span>
                                </div>
                                @error('amount')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="percent" class="form-label">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="percent" name="percent" placeholder="14.9" value="{{ old('percent') }}">
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('percent')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="period" class="form-label">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="period" name="period" placeholder="36" value="{{ old('period') }}">
                                    <span class="input-group-text">месяцев</span>
                                </div>
                                @error('period')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="refill" class="form-label">{!! Icons::get(Icons::BALANCE_START) !!} {{ __('Пополнение') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="refill" name="refill" placeholder="10000" value="{{ old('refill') }}" aria-describedby="refillHelp">
                                    <span class="input-group-text currency">{{ __('RUB') }}</span>
                                </div>
                                <div id="refillHelp" class="form-text mb-3">{{ __('Сумма ежемесячного пополнения вклада') }}</div>
                                @error('refill')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="capitalization" class="form-label">{!! Icons::get(Icons::BALANCE_CASH) !!} {{ __('Капитализация') }}</label>
                                <select class="form-select" id="capitalization" name="capitalization" aria-label="Default select example" aria-describedby="capitalizationHelp">
                                    <option {{ old('capitalization') == PlowBack::WITHOUT ? 'selected': '' }} value="{{ PlowBack::WITHOUT }}">{{ __('При закрытии кредита') }}</option>
                                    <option {{ old('capitalization') == PlowBack::DAILY   ? 'selected': '' }} value="{{ PlowBack::DAILY }}">{{ __('Ежедневно') }}</option>
                                    <option {{ old('capitalization') == PlowBack::WEEKLY  ? 'selected': '' }} value="{{ PlowBack::WEEKLY }}">{{ __('Еженедельно') }}</option>
                                    <option {{ old('capitalization') == PlowBack::MONTHLY ? 'selected': '' }} value="{{ PlowBack::MONTHLY }}">{{ __('Раз в месяц') }}</option>
                                    <option {{ old('capitalization') == PlowBack::YEARLY  ? 'selected': '' }} value="{{ PlowBack::YEARLY }}">{{ __('Раз в год') }}</option>
                                </select>
                                <div id="depositPlowBackHelp" class="form-text">{{ __('Период капитализации процентов') }}</div>
                                @error('capitalization')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" {{ old('withdrawal') > 0 ? 'checked' : '' }} class="form-check-input" id="withdrawal" name="withdrawal" aria-describedby="withdrawalHelp">
                                <label class="form-check-label" for="withdrawal">{!! Icons::get(Icons::RESET) !!} {{ __('Снимать проценты') }}</label>
                                <div id="withdrawalHelp" class="form-text">{{ __('Снимать ежемесячно проценты или капитализировать во вклад') }}</div>
                                @error('withdrawal')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <a href="{{ route('deposit.index') }}" class="btn btn-secondary me-md-2">{!! Icons::get(Icons::RETURN) !!} {{ __('Назад') }}</a>
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

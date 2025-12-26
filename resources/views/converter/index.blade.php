<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Currency Converter') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .currency-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .currency-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem 2rem 1.5rem;
            text-align: center;
        }

        .currency-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        .btn-convert {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 10px;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-convert:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }

        .btn-convert:active {
            transform: translateY(0);
        }

        .btn-convert:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .swap-button {
            background: var(--light-color);
            border: 2px solid #e0e0e0;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            top: -10px;
            z-index: 1;
        }

        .swap-button:hover {
            background: var(--primary-color);
            color: white;
            transform: rotate(180deg);
        }

        .result-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
            display: none;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }

        .conversion-result {
            font-size: 2.0rem;
            font-weight: 700;
            color: var(--primary-color);
            text-align: center;
            margin: 1rem 0;
        }

        .rate-info {
            background: rgba(67, 97, 238, 0.1);
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            font-size: 0.9rem;
            color: var(--dark-color);
            margin-top: 1rem;
        }

        .currency-flag {
            width: 24px;
            height: 16px;
            border-radius: 2px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .currency-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }

        .loader {
            display: none;
            text-align: center;
            margin: 1rem 0;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-alert {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .recent-conversions {
            margin-top: 2rem;
            max-height: 300px;
            overflow-y: auto;
        }

        .recent-item {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .recent-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .currency-chip {
            background: rgba(67, 97, 238, 0.1);
            border: 1px solid rgba(67, 97, 238, 0.2);
            border-radius: 20px;
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .currency-chip:hover {
            background: var(--primary-color);
            color: white;
        }

        @media (max-width: 768px) {
            .currency-card {
                margin: 1rem;
            }

            .currency-body {
                padding: 1.5rem;
            }

            .conversion-result {
                font-size: 2rem;
            }
        }

        .conversion-history {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
            max-height: 400px;
            overflow-y: auto;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #eee;
            transition: background-color 0.3s ease;
        }

        .history-item:hover {
            background-color: #f8f9fa;
        }

        .history-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <!-- Основная карточка конвертера -->
            <div class="currency-card">
                <!-- Заголовок -->
                <div class="currency-header">
                    <h1 class="h2 mb-3">
                        <i class="fas fa-exchange-alt me-2"></i>Currency Converter
                    </h1>
                    <p class="mb-0 opacity-75">Real-time exchange rates with instant conversion</p>
                </div>

                <!-- Тело формы -->
                <div class="currency-body">
                    <!-- Форма конвертации -->
                    <form id="currencyConverterForm">
                        @csrf

                        <!-- Поле суммы -->
                        <div class="form-group">
                            <label for="amount" class="form-label">
                                <i class="fas fa-money-bill-wave"></i> Amount
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       id="amount"
                                       name="amount"
                                       class="form-control form-control-lg"
                                       placeholder="Enter amount"
                                       min="0"
                                       step="0.01"
                                       value="100"
                                       required>
                                <span class="input-group-text bg-light">$</span>
                            </div>
                            <small class="form-text text-muted mt-1">Enter the amount you want to convert</small>
                        </div>

                        <!-- Контейнер для валют -->
                        <div class="row">
                            <!-- Исходная валюта -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fromCurrency" class="form-label">
                                        <i class="fas fa-arrow-right"></i> From
                                    </label>
                                    <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-flag-usa"></i>
                                            </span>
                                        <select id="fromCurrency" name="from" class="form-select" required>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->code }}">{{ $currency->code }} - {{ $currency->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Кнопка обмена -->
                            <div class="col-md-12 my-3">
                                <div class="swap-button" id="swapCurrencies">
                                    <i class="fas fa-exchange-alt fa-lg"></i>
                                </div>
                            </div>

                            <!-- Целевая валюта -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="toCurrency" class="form-label">
                                        <i class="fas fa-arrow-left"></i> To
                                    </label>
                                    <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-flag"></i>
                                            </span>
                                        <select id="toCurrency" name="to" class="form-select" required>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->code }}">{{ $currency->code }} - {{ $currency->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Кнопка конвертации -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn-convert" id="convertButton">
                                <i class="fas fa-sync-alt"></i> Convert Currency
                            </button>
                        </div>

                        <!-- Лоадер -->
                        <div class="loader" id="loader">
                            <div class="spinner"></div>
                            <p class="mt-2 text-muted">Converting...</p>
                        </div>

                        <!-- Сообщение об ошибке -->
                        <div class="alert alert-danger error-alert" id="errorAlert" role="alert"></div>
                    </form>

                    <!-- Результат конвертации -->
                    <div class="result-card" id="resultCard">
                        <div class="result-header">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-line me-2"></i>Conversion Result
                            </h5>
                            <button class="btn btn-sm btn-outline-secondary" id="copyResult">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>

                        <div class="conversion-result" id="conversionResult">
                            <!-- Результат появится здесь -->
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="currency-info">
                                <div id="fromCurrencyInfo"></div>
                            </div>
                            <div class="currency-info">
                                <div id="toCurrencyInfo"></div>
                            </div>
                        </div>

                        <div class="rate-info" id="rateInfo">
                            <!-- Информация о курсе появится здесь -->
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> Updated: <span id="updateTime">Just now</span>
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-database"></i> Source: FreeCurrencyAPI
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- История конвертаций -->
            <div class="conversion-history mt-4" id="historySection">
                <h5 class="mb-3">
                    <i class="fas fa-history me-2"></i>Recent Conversions
                </h5>
                <div id="conversionHistory">
                    <!-- История появится здесь -->
                    <div class="text-center text-muted py-3" id="emptyHistory">
                        <i class="fas fa-exchange-alt fa-2x mb-2"></i>
                        <p>No conversions yet</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('currencyConverterForm');
        const convertButton = document.getElementById('convertButton');
        const loader = document.getElementById('loader');
        const resultCard = document.getElementById('resultCard');
        const conversionResult = document.getElementById('conversionResult');
        const errorAlert = document.getElementById('errorAlert');
        const fromCurrencySelect = document.getElementById('fromCurrency');
        const toCurrencySelect = document.getElementById('toCurrency');
        const amountInput = document.getElementById('amount');
        const swapButton = document.getElementById('swapCurrencies');
        const copyButton = document.getElementById('copyResult');
        const fromCurrencyInfo = document.getElementById('fromCurrencyInfo');
        const toCurrencyInfo = document.getElementById('toCurrencyInfo');
        const rateInfo = document.getElementById('rateInfo');
        const updateTime = document.getElementById('updateTime');
        const conversionHistory = document.getElementById('conversionHistory');
        const emptyHistory = document.getElementById('emptyHistory');
        const currencyChips = document.querySelectorAll('.currency-chip');

        // Загружаем историю из localStorage
        loadHistory();

        // Обработка быстрого выбора валют
        currencyChips.forEach(chip => {
            chip.addEventListener('click', function() {
                const currency = this.getAttribute('data-currency');
                // Определяем, в какое поле установить валюту
                const fromOptions = Array.from(fromCurrencySelect.options).map(opt => opt.value);

                if (fromOptions.includes(currency)) {
                    fromCurrencySelect.value = currency;
                } else {
                    toCurrencySelect.value = currency;
                }
            });
        });

        // Обмен валютами
        swapButton.addEventListener('click', function() {
            const fromValue = fromCurrencySelect.value;
            const toValue = toCurrencySelect.value;

            fromCurrencySelect.value = toValue;
            toCurrencySelect.value = fromValue;
        });

        // Копирование результата
        copyButton.addEventListener('click', function() {
            const resultText = conversionResult.textContent;
            navigator.clipboard.writeText(resultText).then(() => {
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check"></i> Copied!';
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-success');

                setTimeout(() => {
                    this.innerHTML = originalHtml;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-secondary');
                }, 2000);
            });
        });

        // Обработка отправки формы
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Скрываем предыдущие результаты и ошибки
            resultCard.style.display = 'none';
            errorAlert.style.display = 'none';

            // Показываем лоадер
            loader.style.display = 'block';
            convertButton.disabled = true;

            // Подготавливаем данные
            const formData = {
                amount: amountInput.value,
                from: fromCurrencySelect.value,
                to: toCurrencySelect.value,
                _token: document.querySelector('input[name="_token"]').value
            };

            // Отправляем запрос
            fetch('/api/converter/convert', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': formData._token
                },
                body: JSON.stringify(formData)
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Скрываем лоадер
                    loader.style.display = 'none';
                    convertButton.disabled = false;

                    if (data.success) {
                        // Обновляем информацию о валютах
                        fromCurrencyInfo.innerHTML = `<strong>${data.from}</strong> - ${data.from_name}`;
                        toCurrencyInfo.innerHTML = `<strong>${data.to}</strong> - ${data.to_name}`;

                        // Форматируем результат
                        const formattedAmount = formatCurrency(data.amount, data.from);
                        const formattedResult = formatCurrency(data.result, data.to);

                        // Отображаем результат
                        conversionResult.innerHTML = `
                            ${formattedAmount}  =  <span class="text-primary">${formattedResult}</span>
                        `;

                        // Отображаем информацию о курсе
                        rateInfo.innerHTML = `
                            <strong>Exchange Rate:</strong> 1 ${data.from} = ${data.rate.toFixed(6)} ${data.to}
                            <br>
                            <small>Inverse Rate: 1 ${data.to} = ${(1 / data.rate).toFixed(6)} ${data.from}</small>
                        `;

                        // Обновляем время
                        updateTime.textContent = new Date().toLocaleTimeString();

                        // Показываем результат
                        resultCard.style.display = 'block';

                        // Сохраняем в историю
                        saveToHistory(data);

                        // Прокручиваем к результату
                        resultCard.scrollIntoView({ behavior: 'smooth' });
                    } else {
                        // Показываем ошибку
                        showError(data.error || 'An error occurred during conversion');
                    }
                })
                .catch(error => {
                    // Скрываем лоадер
                    loader.style.display = 'none';
                    convertButton.disabled = false;

                    // Показываем ошибку
                    showError('Connection error. Please check your internet connection.');
                    console.error('Error:', error);
                });
        });

        // Функция для отображения ошибки
        function showError(message) {
            errorAlert.textContent = message;
            errorAlert.style.display = 'block';
            errorAlert.scrollIntoView({ behavior: 'smooth' });
        }

        // Функция для форматирования валюты
        function formatCurrency(amount, currency) {
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: currency,
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            return formatter.format(amount);
        }

        // Функция для сохранения в историю
        function saveToHistory(data) {
            const history = JSON.parse(localStorage.getItem('currencyConversionHistory')) || [];

            const historyItem = {
                id: Date.now(),
                amount: data.amount,
                from: data.from,
                to: data.to,
                result: data.result,
                rate: data.rate,
                timestamp: new Date().toISOString()
            };

            // Добавляем в начало массива
            history.unshift(historyItem);

            // Ограничиваем историю 10 записями
            if (history.length > 10) {
                history.pop();
            }

            // Сохраняем в localStorage
            localStorage.setItem('currencyConversionHistory', JSON.stringify(history));

            // Обновляем отображение истории
            loadHistory();
        }

        // Функция для загрузки истории
        function loadHistory() {
            const history = JSON.parse(localStorage.getItem('currencyConversionHistory')) || [];

            if (history.length === 0) {
                emptyHistory.style.display = 'block';
                return;
            }

            emptyHistory.style.display = 'none';

            let historyHTML = '';

            history.forEach(item => {
                const date = new Date(item.timestamp);
                const formattedDate = date.toLocaleDateString();
                const formattedTime = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                historyHTML += `
                        <div class="history-item">
                            <div>
                                <strong>${item.amount} ${item.from}</strong>
                                <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                <strong class="text-primary">${item.result.toFixed(2)} ${item.to}</strong>
                                <div class="text-muted small">
                                    <i class="fas fa-clock"></i> ${formattedDate} ${formattedTime}
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="text-muted small">Rate: ${item.rate.toFixed(6)}</div>
                                <button class="btn btn-sm btn-outline-primary mt-1" onclick="repeatConversion('${item.amount}', '${item.from}', '${item.to}')">
                                    <i class="fas fa-redo"></i>
                                </button>
                            </div>
                        </div>
                    `;
            });

            conversionHistory.innerHTML = historyHTML;
        }

        // Функция для повторения конвертации
        window.repeatConversion = function(amount, from, to) {
            amountInput.value = amount;
            fromCurrencySelect.value = from;
            toCurrencySelect.value = to;

            // Прокручиваем к форме
            form.scrollIntoView({ behavior: 'smooth' });

            // Запускаем конвертацию
            setTimeout(() => {
                form.dispatchEvent(new Event('submit'));
            }, 500);
        };

        // Автоматическое обновление курсов каждые 5 минут
        setInterval(() => {
            // Можно добавить логику для проверки свежести курсов
            console.log('Checking for rate updates...');
        }, 300000); // 5 минут

        // Инициализация с первой конвертацией
        // setTimeout(() => {
        //     if (!localStorage.getItem('currencyConversionHistory')) {
        //         form.dispatchEvent(new Event('submit'));
        //     }
        // }, 1000);
    });
</script>
</body>
</html>

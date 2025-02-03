@props([
    'chartId' => 'reputationChart',
    'chartTitle' => 'Reputation History (24h)',
    'chartDescription' => 'Reputation changes over time',
])

<div class="mt-6 rounded-xl bg-white p-6 shadow-md dark:bg-gray-800">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $chartTitle }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $chartDescription }}</p>
    </div>
    <div class="relative h-[400px] w-full">
        <div id="{{ $chartId }}-loading"
            class="absolute inset-0 z-10 hidden items-center justify-center bg-white/50 dark:bg-gray-800/50">
            <div class="text-center">
                <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-orange-500 border-r-transparent align-[-0.125em]"
                    role="status">
                    <span
                        class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">
                        Loading...
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Loading chart data...</p>
            </div>
        </div>
        <canvas id="{{ $chartId }}" class="w-full"></canvas>
    </div>
</div>

@push('scripts')
    <script>
        const initChart = (elementId) => {
            const ctx = document.getElementById(elementId).getContext('2d');
            const isDarkMode = document.documentElement.classList.contains('dark');

            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'REP per hour',
                        data: [],
                        borderColor: 'rgb(255, 159, 64)',
                        backgroundColor: 'rgba(255, 159, 64, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: {
                        x: {
                            grid: {
                                color: function(context) {
                                    const label = context.tick.label;
                                    if (!label) return 'rgba(0, 0, 0, 0)';
                                    const hour = parseInt(label.split(' ')[1].split(':')[0]);
                                    const minute = parseInt(label.split(' ')[1].split(':')[1]);
                                    return (hour % 3 === 0 && minute === 0) ?
                                        (isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)') :
                                        'rgba(0, 0, 0, 0)';
                                },
                                drawBorder: false
                            },
                            ticks: {
                                color: isDarkMode ? '#9ca3af' : '#6b7280',
                                maxRotation: 45,
                                minRotation: 45,
                                callback: function(val, index, labels) {
                                    const label = labels[index];
                                    if (!label) return '';
                                    const hour = parseInt(label.split(' ')[1].split(':')[0]);
                                    const minute = parseInt(label.split(' ')[1].split(':')[1]);
                                    return (hour % 3 === 0 && minute === 0) ? label : '';
                                },
                                font: {
                                    size: 11
                                }
                            }
                        },
                        y: {
                            min: 0,
                            grid: {
                                color: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                                drawBorder: false
                            },
                            ticks: {
                                color: isDarkMode ? '#9ca3af' : '#6b7280',
                                callback: function(value) {
                                    return value.toLocaleString();
                                },
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            backgroundColor: isDarkMode ? 'rgba(17, 24, 39, 0.8)' : 'rgba(255, 255, 255, 0.8)',
                            titleColor: isDarkMode ? '#fff' : '#000',
                            bodyColor: isDarkMode ? '#fff' : '#000',
                            bodyFont: {
                                size: 13
                            },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                title: function(context) {
                                    return context[0].label;
                                },
                                label: function(context) {
                                    return 'Reputation: ' + context.parsed.y.toLocaleString();
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    }
                }
            });
        };

        let reputationChart = null;

        window.handleReputationChart = async (address) => {
            const loadingElement = document.getElementById(`${chart.canvas.id}-loading`);
            loadingElement.classList.remove('hidden');
            loadingElement.classList.add('flex');

            if (!reputationChart) {
                reputationChart = initChart('{{ $chartId }}');
            }

            try {
                const response = await fetch(`/api/exorde-history?user_address=${address}`);
                const data = await response.json();

                const chartData = data.history.map(item => ({
                    x: new Date(item.timestamp).toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }),
                    y: item.reputation
                }));

                reputationChart.data.labels = chartData.map(d => d.x);
                reputationChart.data.datasets[0].data = chartData.map(d => d.y);
                reputationChart.update('none');
            } catch (error) {
                console.error('Error updating chart:', error);
            } finally {
                loadingElement.classList.add('hidden');
                loadingElement.classList.remove('flex');
            }
        };

        window.addEventListener('beforeunload', () => {
            if (reputationChart) {
                reputationChart.destroy();
                reputationChart = null;
            }
        });
    </script>
@endpush

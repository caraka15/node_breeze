<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Service | {{ $chaind->name }}</title>
    <link rel="icon" type="image/x-icon" href="component/images/favicon.ico">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.css" />
    <link rel="stylesheet" href="component/css/style.css" />

    <style>
    /* Gaya tambahan untuk menyesuaikan dengan tampilan ChatGPT */
    body {
        padding-top: 80px;
        background-color: #f5f5f5;
        font-family: Arial, sans-serif;
    }

    .chart-container,
    .container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .chart-container {
        height: 360px;
    }

    @media (max-width: 480px) {
        .container {
            max-width: 100%;
            padding: 10px;
        }
    }

    .info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .info img {
        border-radius: 50px;
        border: 1px black solid;
    }

    .info .name {
        text-transform: uppercase;
    }

    .title {
        font-size: 24px;
        font-weight: bold;
        margin: 0 20px;
    }

    .name {
        font-size: 18px;
    }

    .markdown-body {
        font-size: 16px;
        line-height: 1.6;
        margin: 10px;
    }

    .markdown-body img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 20px auto;
    }

    pre {
        position: relative;
        padding: 10px;
        background-color: #f8f8f8;
        border-radius: 3px;
        margin-bottom: 20px;
        overflow: auto;
    }

    .copy-button {
        position: absolute;
        top: 5px;
        right: 5px;
        padding: 5px;
        background-color: #f8f8f8;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.2s ease-in-out;
    }

    .copy-button:hover {
        opacity: 0.8;
    }

    .copy-icon {
        width: 16px;
        height: 16px;
        color: #000;
        transition: transform 0.2s ease-in-out;
    }

    .copy-button.copied .copy-icon {
        transform: rotate(180deg);
    }

    @keyframes showCopiedText {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .copied-text {
        position: absolute;
        top: 5px;
        right: 40px;
        font-size: 14px;
        color: #555;
        opacity: 0;
        animation: showCopiedText 0.3s ease-in-out forwards;
    }
    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QPBYJDLTQE"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-QPBYJDLTQE');
    </script>
</head>
<body>
    <div class="info">
            <img src="{{ asset('storage/' . $chaind->logo) }}" alt="Logo" width="40" height="40">
            <div class="title">Installation</div>
            <div class="name">{{ $chaind->name }}</div>
    </div>

    <div class="widget">
        <div class="chart-container">
            <canvas id="chart"></canvas>
        </div>
    </div>

    <div class="container">
        <article id="markdownContent" class="markdown-body"></article>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.2.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.1/showdown.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        @if ($chaind)
            const coinId = "{{ $chaind->name }}";
            const days = 1;
            const interval = "hour";

            const chartContainer = document.querySelector(".chart-container");

            getMarketChart(coinId, days, interval)
                .then((data) => {
                    const prices = data.prices;
                    const labels = prices.map((price) =>
                        new Date(price[0]).toLocaleDateString()
                    );
                    const values = prices.map((price) => price[1]);

                    const chartCanvas = document.getElementById("chart");
                    const chart = new Chart(chartCanvas, {
                        type: "line",
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Price",
                                data: values,
                                backgroundColor: "rgba(255, 87, 34, 0.2)",
                                borderColor: "rgba(255, 87, 34, 1)",
                                borderWidth: 2,
                                pointRadius: 0,
                                tension: 0.4,
                            }, ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false,
                                    },
                                    ticks: {
                                        color: "#888",
                                        font: {
                                            size: 10,
                                        },
                                    },
                                },
                                y: {
                                    grid: {
                                        color: "#ddd",
                                        borderDash: [3, 3],
                                        lineWidth: 2,
                                    },
                                    ticks: {
                                        color: "#888",
                                        font: {
                                            size: 10,
                                        },
                                        callback: function(value) {
                                            return "$" + value.toFixed(2);
                                        },
                                    },
                                },
                            },
                        },
                    });
                })
                .catch((error) => {
                    console.log(error);
                    chartContainer.style.display = "none";
                });
        @endif
    });

    function getMarketChart(coinId, days, interval) {
        const url =
            `https://api.coingecko.com/api/v3/coins/${coinId}/market_chart?vs_currency=usd&days=${days}&interval=${interval}`;
        return fetch(url).then((response) => {
            if (!response.ok) {
                throw new Error("Failed to fetch data from API");
            }
            return response.json();
        });
    }
    </script>
    <script>
    // Ubah urlFile menjadi URL file Markdown yang ingin Anda tampilkan
    const urlFile = "{{ $chaind ? asset('storage/' . $chaind->guide_link) : '' }}";

    if (urlFile) {
        // Ambil konten file Markdown menggunakan XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open("GET", urlFile, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const markdownContent = xhr.responseText;

                // Konversi Markdown menjadi HTML menggunakan Showdown
                const converter = new showdown.Converter();
                const htmlContent = converter.makeHtml(markdownContent);
                document.getElementById("markdownContent").innerHTML = htmlContent;

                // Terapkan highlight syntax pada blok kode menggunakan Highlight.js
                document.querySelectorAll("pre code").forEach((block) => {
                    hljs.highlightBlock(block);

                    // Buat tombol salin
                    const copyButton = document.createElement("button");
                    copyButton.classList.add("copy-button");
                    copyButton.innerHTML = `
                            <i class="far fa-copy copy-icon" style="color: #000;"></i>`;

                    // Tambahkan event listener pada tombol salin
                    copyButton.addEventListener("click", () => {
                        const codeText = block.textContent;
                        navigator.clipboard
                            .writeText(codeText)
                            .then(() => {
                                copyButton.classList.add("copied");
                                setTimeout(() => {
                                    copyButton.classList.remove("copied");
                                }, 1500);
                            })
                            .catch((error) => {
                                console.error("Gagal menyalin teks:", error);
                            });
                    });

                    // Tambahkan tombol salin pada blok kode
                    block.parentNode.insertBefore(copyButton, block);
                });
            }
        };
        xhr.send();
    }
    </script>
</body>
</html>

<x-app-layout>
    @section('title', $title)
    @section('description', $chaind->name . ' Node Service, Validator guide')
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center justify-between bg-slate-300 p-4 rounded-md shadow-md">
                    <img src="{{ asset('storage/' . $chaind->logo) }}" alt="Logo" width="40" height="40">
                    <div class="text-xl">Installation</div>
                    <div class="name">{{ $chaind->name }}</div>
                </div>

                <div class="p-5 prose max-w-full">
                    <article id="markdownContent" class="markdown-body"></article>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.2.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.1/showdown.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                            <i class="far fa-copy copy-icon" style="color: white;"></i>`;

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
</x-app-layout>

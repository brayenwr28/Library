<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baca Buku | {{ $book->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { display: none; }
        }

        #pdf-container,
        #pdf-container canvas {
            user-select: none;
        }

        #viewer-frame {
            position: relative;
            padding: 2rem;
            background: #f8fafc;
        }

        #pdf-container {
            position: relative;
            overflow-y: auto;
            max-height: 85vh;
            scroll-behavior: smooth;
            padding: 2rem 0;
        }

        #pdf-pages {
            display: flex;
            flex-direction: column;
            gap: 3rem;
            align-items: center;
        }

        .pdf-page canvas {
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.25);
            border-radius: 12px;
            background: white;
        }

        button[disabled] {
            opacity: 0.4;
            cursor: not-allowed;
        }

        #loading-overlay {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.92);
            color: #171b1f;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            z-index: 9999;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        #loading-overlay.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen p-6">
    <div id="loading-overlay"><span id="loading-text">Loading buku...</span></div>
    <div class="max-w-6xl mx-auto">
        <div class="mb-6 flex flex-w    rap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Pembaca: {{ $member->name }}</p>
                <h1 class="text-3xl font-bold text-slate-800">{{ $book->title }}</h1>
                <p class="text-slate-600 text-sm">{{ $book->author }} · {{ $book->publication_year }} @if($book->publisher) | {{ $book->publisher }} @endif</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('peminjaman.riwayat') }}" class="inline-flex items-center gap-2 rounded-lg bg-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-300">
                    ← Riwayat Peminjaman
                </a>
                <a href="{{ route('katalog') }}" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">
                    ← Kembali ke Katalog
                </a>
            </div>
        </div>

        <div class="mb-4 rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-600">
            <p>Buku ditampilkan dalam mode baca-only. Unduh, cetak, klik kanan, dan sorotan teks dinonaktifkan.</p>
        </div>

        <div class="rounded-2xl border border-slate-300 bg-white shadow-lg" id="viewer-frame">
            <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-3 text-sm text-slate-600">
                <div class="flex items-center gap-3">
                    <button id="prev-page" type="button" class="rounded-lg bg-slate-200 px-3 py-2 font-semibold text-slate-700 transition hover:bg-slate-300" aria-label="Halaman sebelumnya">←</button>
                    <button id="next-page" type="button" class="rounded-lg bg-slate-200 px-3 py-2 font-semibold text-slate-700 transition hover:bg-slate-300" aria-label="Halaman berikutnya">→</button>
                </div>
                <div id="page-indicator" class="font-semibold text-slate-700">Halaman 0 / 0</div>
                <div class="flex items-center gap-3">
                    <button id="zoom-out" type="button" class="rounded-lg bg-slate-200 px-3 py-2 font-semibold text-slate-700 transition hover:bg-slate-300" aria-label="Perkecil">−</button>
                    <button id="zoom-in" type="button" class="rounded-lg bg-slate-200 px-3 py-2 font-semibold text-slate-700 transition hover:bg-slate-300" aria-label="Perbesar">+</button>
                </div>
            </div>
            <div class="overflow-auto bg-slate-50" id="pdf-container">
                <div id="pdf-pages"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('contextmenu', function (event) {
            event.preventDefault();
        });

        document.addEventListener('dragstart', function (event) {
            event.preventDefault();
        });

        document.addEventListener('keydown', function (event) {
            const blockedKeys = ['s', 'p', 'u', 'i', 'j'];
            if ((event.ctrlKey || event.metaKey) && blockedKeys.includes(event.key.toLowerCase())) {
                event.preventDefault();
            }
            if (event.key === 'PrintScreen' || event.key === 'F12') {
                event.preventDefault();
            }
        });

        const pdfUrl = @json($pdfUrl);
        const pageIndicator = document.getElementById('page-indicator');
        const pdfContainer = document.getElementById('pdf-container');
        const pagesWrapper = document.getElementById('pdf-pages');
        const prevBtn = document.getElementById('prev-page');
        const nextBtn = document.getElementById('next-page');
        const zoomInBtn = document.getElementById('zoom-in');
        const zoomOutBtn = document.getElementById('zoom-out');
        const loadingOverlay = document.getElementById('loading-overlay');
        const loadingText = document.getElementById('loading-text');

        let pdfDoc = null;
        let currentPage = 1;
        let scale = 1;
        const minScale = 1;
        const maxScale = 2.4;
        const pageRecords = [];
        let scrollAnimationFrame = null;

        const showOverlay = (message) => {
            if (message) {
                loadingText.textContent = message;
            }
            loadingOverlay.classList.remove('hidden');
        };

        const hideOverlay = () => {
            loadingOverlay.classList.add('hidden');
        };

        const loadScript = (src) => new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = src;
            script.async = true;
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });

        const cdnConfigs = [
            {
                script: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js',
                worker: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js',
            },
            {
                script: 'https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.min.js',
                worker: 'https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.worker.min.js',
            },
        ];

        (async () => {
            let pdfConfig = null;

            for (const config of cdnConfigs) {
                try {
                    await loadScript(config.script);
                    pdfConfig = config;
                    break;
                } catch (error) {
                    console.warn('Gagal memuat pdf.js dari', config.script, error);
                }
            }

            if (!pdfConfig || !window.pdfjsLib) {
                pageIndicator.textContent = 'Viewer gagal dimuat.';
                console.error('pdf.js tidak tersedia setelah mencoba semua CDN.');
                showOverlay('Gagal memuat buku');
                return;
            }

            pdfjsLib.GlobalWorkerOptions.workerSrc = pdfConfig.worker;

            const updateControls = () => {
                if (!pdfDoc) {
                    prevBtn.disabled = true;
                    nextBtn.disabled = true;
                    zoomInBtn.disabled = true;
                    zoomOutBtn.disabled = true;
                    return;
                }

                pageIndicator.textContent = `Halaman ${currentPage} / ${pdfDoc.numPages}`;
                prevBtn.disabled = currentPage <= 1;
                nextBtn.disabled = currentPage >= pdfDoc.numPages;
                zoomOutBtn.disabled = scale <= minScale;
                zoomInBtn.disabled = scale >= maxScale;
            };

            const ensurePageRecords = () => {
                if (pageRecords.length === pdfDoc.numPages) {
                    return;
                }

                pagesWrapper.innerHTML = '';
                pageRecords.length = 0;

                for (let i = 1; i <= pdfDoc.numPages; i += 1) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'pdf-page w-full flex justify-center';
                    wrapper.dataset.pageNumber = String(i);

                    const canvas = document.createElement('canvas');
                    canvas.className = 'mx-auto block select-none';

                    wrapper.appendChild(canvas);
                    pagesWrapper.appendChild(wrapper);

                    pageRecords.push({
                        wrapper,
                        canvas,
                        ctx: canvas.getContext('2d'),
                    });
                }
            };

            const renderPage = (pageNumber) => {
                return pdfDoc.getPage(pageNumber).then((page) => {
                    const record = pageRecords[pageNumber - 1];
                    if (!record) {
                        return;
                    }

                    const baseViewport = page.getViewport({ scale: 1 });
                    const cssWidth = 210; // mm
                    const cssHeight = 297; // mm
                    const dpi = 96;
                    const widthPx = cssWidth * 0.0393701 * dpi;
                    const calculatedScale = widthPx / baseViewport.width;
                    const targetScale = calculatedScale * scale;
                    const viewport = page.getViewport({ scale: targetScale });

                    record.canvas.width = viewport.width;
                    record.canvas.height = viewport.height;
                    record.canvas.style.width = `${cssWidth}mm`;
                    record.canvas.style.height = `${cssHeight}mm`;

                    const renderContext = {
                        canvasContext: record.ctx,
                        viewport,
                    };

                    return page.render(renderContext).promise;
                });
            };

            const renderAllPages = () => {
                const tasks = [];
                for (let i = 1; i <= pdfDoc.numPages; i += 1) {
                    tasks.push(renderPage(i));
                }
                return Promise.all(tasks).then(() => {
                    updateControls();
                });
            };

            const changeScale = (delta) => {
                const newScale = Number((scale + delta).toFixed(2));
                if (newScale < minScale || newScale > maxScale) {
                    return;
                }
                const maxScrollable = Math.max(pdfContainer.scrollHeight - pdfContainer.clientHeight, 1);
                const scrollRatio = pdfContainer.scrollTop / maxScrollable;

                scale = newScale;

                renderAllPages().then(() => {
                    const newMaxScrollable = Math.max(pdfContainer.scrollHeight - pdfContainer.clientHeight, 1);
                    pdfContainer.scrollTop = scrollRatio * newMaxScrollable;
                    handleScroll();
                });
            };

            updateControls();

            pdfjsLib.getDocument({
                url: pdfUrl,
                withCredentials: true,
                disableStream: true,
                disableAutoFetch: true,
            }).promise
                .then((doc) => {
                    pdfDoc = doc;
                    ensurePageRecords();
                    renderAllPages().then(() => {
                        currentPage = 1;
                        pdfContainer.scrollTop = 0;
                        handleScroll();
                        updateControls();
                        hideOverlay();
                    });
                })
                .catch((error) => {
                    console.error(error);
                    pageIndicator.textContent = 'Gagal memuat PDF.';
                    showOverlay('Gagal memuat buku');
                });

            prevBtn.addEventListener('click', () => {
                if (currentPage <= 1) {
                    return;
                }
                scrollToPage(currentPage - 1);
            });

            nextBtn.addEventListener('click', () => {
                if (!pdfDoc || currentPage >= pdfDoc.numPages) {
                    return;
                }
                scrollToPage(currentPage + 1);
            });

            zoomInBtn.addEventListener('click', () => {
                changeScale(0.2);
            });

            zoomOutBtn.addEventListener('click', () => {
                changeScale(-0.2);
            });

            const scrollToPage = (pageNumber) => {
                const record = pageRecords[pageNumber - 1];
                if (!record) {
                    return;
                }
                currentPage = pageNumber;
                updateControls();
                record.wrapper.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                });
            };

            const handleScroll = () => {
                if (!pageRecords.length) {
                    return;
                }

                if (scrollAnimationFrame) {
                    cancelAnimationFrame(scrollAnimationFrame);
                }

                scrollAnimationFrame = requestAnimationFrame(() => {
                    scrollAnimationFrame = null;

                    const containerRect = pdfContainer.getBoundingClientRect();
                    const containerCenter = pdfContainer.scrollTop + (pdfContainer.clientHeight / 2);
                    let closestPage = 1;
                    let closestDistance = Number.POSITIVE_INFINITY;

                    pageRecords.forEach((record, index) => {
                        const rect = record.wrapper.getBoundingClientRect();
                        const top = rect.top - containerRect.top + pdfContainer.scrollTop;
                        const height = rect.height;
                        const pageCenter = top + (height / 2);
                        const distance = Math.abs(pageCenter - containerCenter);

                        if (distance < closestDistance) {
                            closestDistance = distance;
                            closestPage = index + 1;
                        }
                    });

                    if (closestPage !== currentPage) {
                        currentPage = closestPage;
                        updateControls();
                    }
                });
            };

            pdfContainer.addEventListener('scroll', handleScroll);
        })();
    </script>
</body>
</html>

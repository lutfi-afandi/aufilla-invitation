<script>
    // Tab Navigation
    function switchSettingTab(tabName) {
        $('.setting-tab-btn').removeClass('bg-white text-indigo-600 shadow-2xs font-bold').addClass('text-slate-600 hover:text-slate-900 font-medium');
        $('#tab-btn-' + tabName).removeClass('text-slate-600 hover:text-slate-900 font-medium').addClass('bg-white text-indigo-600 shadow-2xs font-bold');

        $('.setting-tab-content').addClass('hidden');
        $('#tab-' + tabName + '-content').removeClass('hidden');

        if (tabName === 'faq') {
            initFaqSortable();
        }
    }

    // Image Upload Previews
    function setupImagePreview(inputId, imgId) {
        $('#' + inputId).on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + imgId).attr('src', e.target.result).removeClass('opacity-60');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    setupImagePreview('input-logo', 'preview-logo');
    setupImagePreview('input-logo-dark', 'preview-logo-dark');
    setupImagePreview('input-favicon', 'preview-favicon');
    setupImagePreview('input-og', 'preview-og');

    // FAQ Repeater Logic
    let faqSortableInstance = null;

    function initFaqSortable() {
        let el = document.getElementById('faq-repeater-container');
        if (!el || typeof Sortable === 'undefined') return;

        if (faqSortableInstance) {
            faqSortableInstance.destroy();
        }

        faqSortableInstance = new Sortable(el, {
            handle: '.faq-drag-handle',
            animation: 150,
            ghostClass: 'bg-indigo-50/80',
            chosenClass: 'bg-slate-100',
            dragClass: 'shadow-lg',
            onEnd: function() {
                reindexFaqItems();
            }
        });
    }

    function reindexFaqItems() {
        $('#faq-repeater-container .faq-item').each(function(index) {
            $(this).find('.faq-index-badge').text(index + 1);
            $(this).find('input[name*="[pertanyaan]"]').attr('name', 'faqs[' + index + '][pertanyaan]');
            $(this).find('textarea[name*="[jawaban]"]').attr('name', 'faqs[' + index + '][jawaban]');
        });
    }

    function addFaqItem() {
        $('#faq-empty-state').remove();
        let index = $('#faq-repeater-container .faq-item').length;

        let template = `
        <div class="faq-item bg-slate-50/70 border border-slate-200 rounded-2xl p-4 sm:p-5 transition-all relative group hover:border-slate-300">
            <div class="flex items-start gap-3">
                <div class="flex flex-col items-center gap-1.5 shrink-0 pt-1">
                    <div class="faq-drag-handle p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-slate-200/60 rounded-lg cursor-grab active:cursor-grabbing transition-colors" title="Geser untuk mengubah urutan">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="9" cy="6" r="1.5" fill="currentColor"></circle>
                            <circle cx="15" cy="6" r="1.5" fill="currentColor"></circle>
                            <circle cx="9" cy="12" r="1.5" fill="currentColor"></circle>
                            <circle cx="15" cy="12" r="1.5" fill="currentColor"></circle>
                            <circle cx="9" cy="18" r="1.5" fill="currentColor"></circle>
                            <circle cx="15" cy="18" r="1.5" fill="currentColor"></circle>
                        </svg>
                    </div>
                    <span class="faq-index-badge inline-flex items-center justify-center w-6 h-6 rounded-md bg-white font-bold text-[11px] text-slate-600 border border-slate-200">
                        ${index + 1}
                    </span>
                </div>

                <div class="flex-1 space-y-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Pertanyaan</label>
                        <input type="text" name="faqs[${index}][pertanyaan]" required
                               class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-semibold text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                               placeholder="Tuliskan pertanyaan...">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Jawaban</label>
                        <textarea name="faqs[${index}][jawaban]" rows="2" required
                                  class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm text-slate-700 bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                                  placeholder="Tuliskan jawaban..."></textarea>
                    </div>
                </div>

                <button type="button" onclick="removeFaqItem(this)" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors border border-transparent hover:border-rose-100 shrink-0" title="Hapus FAQ">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>`;

        $('#faq-repeater-container').append(template);
        initFaqSortable();
    }

    function removeFaqItem(btn) {
        $(btn).closest('.faq-item').fadeOut(200, function() {
            $(this).remove();
            reindexFaqItems();
            if ($('#faq-repeater-container .faq-item').length === 0) {
                $('#faq-repeater-container').html(`
                    <div id="faq-empty-state" class="py-10 text-center text-slate-400 border-2 border-dashed border-slate-200 rounded-2xl">
                        <p class="text-sm font-medium">Belum ada daftar FAQ. Klik tombol "Tambah FAQ Baru" untuk mulai menambahkan.</p>
                    </div>
                `);
            }
        });
    }

    // Generic AJAX Form Submission for Settings
    $('#form-setting-general, #form-setting-contact, #form-setting-seo, #form-setting-faq').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let formData = new FormData(this);
        let btn = form.find('.btn-save-setting');
        let originalText = btn.html();

        btn.prop('disabled', true).html(
            '<svg class="animate-spin h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...'
        );

        $.ajax({
            url: "{{ route('admin.settings.update') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (typeof Swal !== 'undefined') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: response.message || 'Pengaturan berhasil disimpan!'
                    });
                }
            },
            error: function(xhr) {
                let msg = 'Terjadi kesalahan saat menyimpan pengaturan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg,
                        confirmButtonColor: '#4f46e5'
                    });
                }
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

    $(document).ready(function() {
        initFaqSortable();
    });
</script>

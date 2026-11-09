// Lentera Baca — interaksi ringan untuk modal dan pratinjau buku
document.addEventListener('click', (event) => {
    const opener = event.target.closest('[data-open-modal]');

    if (opener) {
        const modal = document.getElementById(opener.dataset.openModal);

        if (modal) {
            modal.hidden = false;
            document.body.style.overflow = 'hidden';
            modal.querySelector('input, textarea, select')?.focus();
        }

        return;
    }

    const closer = event.target.closest('[data-close-modal]');

    if (closer) {
        const modal = closer.closest('[data-modal]');

        if (modal) {
            modal.hidden = true;
            document.body.style.overflow = '';
        }
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
        return;
    }

    document.querySelectorAll('[data-modal]:not([hidden])').forEach((modal) => {
        modal.hidden = true;
    });

    document.body.style.overflow = '';
});

// Pratinjau buku terpilih pada formulir pengajuan
const pilihanBuku = document.getElementById('buku_id');

if (pilihanBuku) {
    const judul = document.getElementById('buku-terpilih');
    const detail = document.getElementById('buku-detail');

    pilihanBuku.addEventListener('change', () => {
        const opsi = pilihanBuku.selectedOptions[0];

        if (!opsi) {
            return;
        }

        judul.textContent = opsi.textContent.trim();
        detail.textContent = opsi.dataset.detail ?? '';
    });
}

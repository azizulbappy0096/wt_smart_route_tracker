// Modal
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('dialog-overlay--active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('dialog-overlay--active');
        document.body.style.overflow = 'auto';
    }
}

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('dialog-overlay')) {
        e.target.classList.remove('dialog-overlay--active');
        document.body.style.overflow = 'auto';
    }
});

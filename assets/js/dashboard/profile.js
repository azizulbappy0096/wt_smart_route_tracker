const tabTriggers = document.querySelectorAll('.tabs__trigger');
const tabContents = document.querySelectorAll('.tabs__content');

// Tab switching
tabTriggers.forEach((trigger) => {
    trigger.addEventListener('click', () => {
        const tabName = trigger.getAttribute('data-tab');
        tabTriggers.forEach((trigger) => {
            trigger.classList.remove('tabs__trigger--active');
        });

        tabContents.forEach((content) => {
            content.classList.remove('tabs__content--active');
        });

        document.querySelector(`[data-tab="${tabName}"]`).classList.add('tabs__trigger--active');
        document.getElementById(`${tabName}-tab`).classList.add('tabs__content--active');
    });
});

// Profile form submission
document.getElementById('profileForm').addEventListener('submit', (e) => {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;

    console.log({ name, email, phone });
    showToast('Profile updated successfully', 'success');
});

// Password form submission
document.getElementById('passwordForm').addEventListener('submit', (e) => {
    e.preventDefault();

    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmNewPassword = document.getElementById('confirmNewPassword').value;

    console.log({ currentPassword, newPassword, confirmNewPassword });
    showToast('Password updated successfully', 'success');
});

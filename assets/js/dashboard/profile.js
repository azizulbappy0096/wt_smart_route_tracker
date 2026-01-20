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

const nameError = document.getElementById('nameError');
const emailError = document.getElementById('emailError');
const phoneError = document.getElementById('phoneError');

// Profile form submission
document.getElementById('profileForm').addEventListener('submit', (e) => {
    e.preventDefault();

    const full_name = document.getElementById('full_name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;

    let errors = {
        full_name: false,
        email: false,
        phone: false,
    };

    if (full_name.trim() === '') {
        errors.full_name = 'Full name is required.';
        nameError.textContent = errors.full_name;
    }
    if (email.trim() === '' || !/^\S+@\S+\.\S+$/.test(email)) {
        errors.email = 'Valid email is required.';
        emailError.textContent = errors.email;
    }
    if (phone.trim() === '') {
        errors.phone = 'Phone number is required.';
        phoneError.textContent = errors.phone;
    }

    if (errors.full_name || errors.email || errors.phone) {
        return;
    }
    e.target.submit();
});

const currentPasswordError = document.getElementById('currentPasswordError');
const newPasswordError = document.getElementById('newPasswordError');
const confirmNewPasswordError = document.getElementById('confirmNewPasswordError');

// Password form submission
document.getElementById('passwordForm').addEventListener('submit', (e) => {
    e.preventDefault();

    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmNewPassword = document.getElementById('confirmNewPassword').value;

    let errors = {
        currentPassword: false,
        newPassword: false,
        confirmNewPassword: false,
    };

    if (currentPassword.trim() === '') {
        errors.currentPassword = 'Current password is required.';
        currentPasswordError.textContent = errors.currentPassword;
    }

    if (newPassword.length < 6) {
        errors.newPassword = 'New password must be at least 6 characters long.';
        newPasswordError.textContent = errors.newPassword;
    }

    if (confirmNewPassword.trim() === '' || newPassword !== confirmNewPassword) {
        errors.confirmNewPassword = 'Passwords do not match.';
        confirmNewPasswordError.textContent = errors.confirmNewPassword;
    }

    if (errors.currentPassword || errors.newPassword || errors.confirmNewPassword) {
        return;
    }

    e.target.submit();
});

// profile picture preview
const profileForm = document.getElementById('profilePictureForm');
const profilePictureInput = document.getElementById('profile_picture');
const profilePictureCircle = document.getElementById('profileAvatar');

profilePictureCircle.addEventListener('click', () => {
    profilePictureInput.click();
});

profilePictureInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            profilePictureCircle.innerHTML = `<img src="${e.target.result}" alt="Profile Picture" >`;
        };
        reader.readAsDataURL(file);

        if(!document.getElementById("profilePictureActions")) {
        const container = document.createElement('div');
        container.setAttribute("id", "profilePictureActions")
        container.style.gap = '1rem';
        container.style.marginTop = '1rem';
        container.className = 'flex items-center';

        const btnRemove = document.createElement('button');
        btnRemove.type = 'button';
        btnRemove.textContent = 'Remove';
        btnRemove.className = 'btn btn--danger btn--full';
        container.appendChild(btnRemove);

        const btnSave = document.createElement('button');
        btnSave.type = 'submit';
        btnSave.textContent = 'Save';
        btnSave.className = 'btn btn--default btn--full';
        container.appendChild(btnSave);

        profileForm.appendChild(container);

        btnRemove.addEventListener('click', () => {
            profilePictureInput.value = '';
            profilePictureCircle.innerHTML = user.profile_picture
                ? `<img src="${user.profile_picture}" alt="Profile Picture" />`
                : user.full_name
                      .split(' ')
                      .map((n) => n[0])
                      .join('')
                      .toUpperCase();
            profileForm.removeChild(container);
        });
    }
    }
});

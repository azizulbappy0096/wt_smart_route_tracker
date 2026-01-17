const userMenuTrigger = document.getElementById('userMenuTrigger');

userMenuTrigger.addEventListener('click', () => {
    const dropdown = document.getElementById('userDropdown');
    if (dropdown) {
        dropdown.classList.toggle('dropdown--active');
    }

    // Close when clicking outside
    document.addEventListener(
        'click',
        function closeOnClickOutside(e) {
            if (
                dropdown &&
                !dropdown.contains(e.target) &&
                !e.target.closest(`[data-dropdown="userDropdown"]`)
            ) {
                dropdown.classList.remove('dropdown--active');
                document.removeEventListener('click', closeOnClickOutside);
            }
        },
        true,
    );
});

function toggleDropdown(dropdownId) {}

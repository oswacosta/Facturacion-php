document.addEventListener('DOMContentLoaded', () => {
    const searchInputs = document.querySelectorAll('.search-input');

    searchInputs.forEach(input => {
        input.addEventListener('input', function () {
            const filter = this.value.toLowerCase().trim();
            const section = this.closest('section');
            const rows = section.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = Array.from(row.querySelectorAll('td'))
                                  .map(td => td.textContent.toLowerCase())
                                  .join(' ');
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    });
});



    // 🔒 Botón de logout
    const logoutBtn = document.querySelector(".logout");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function (e) {
            e.preventDefault();
            if (confirm("¿Estás seguro de que deseas salir?")) {
                window.location.href = "login.php";
            }
        });
    }


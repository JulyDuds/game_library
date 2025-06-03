</div>
<footer class="footer bg-card text-light text-center py-3 mt-auto fixed-bottom border-top border-accent">
    <span>&copy; 2025 Locadora de Jogos</span>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Utilitário para cookies
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days*24*60*60*1000));
    document.cookie = name + "=" + value + ";expires=" + d.toUTCString() + ";path=/";
}
function getCookie(name) {
    let v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return v ? v[2] : null;
}
// Alternância de modo
function setMode(mode) {
    document.body.classList.remove('light-mode', 'dark-mode');
    document.body.classList.add(mode + '-mode');
    setCookie('theme', mode, 365);
    
    // Atualiza ícone e texto
    const modeIcon = document.getElementById('modeIcon');
    const modeText = document.getElementById('modeText');
    
    if (mode === 'dark') {
        modeIcon.className = 'fas fa-moon';
        modeText.textContent = 'Modo Escuro';
    } else {
        modeIcon.className = 'fas fa-sun';
        modeText.textContent = 'Modo Claro';
    }
    
    // Força redesenho da tabela (resolve problemas de renderização)
    document.querySelectorAll('.table-custom').forEach(table => {
        table.style.display = 'none';
        table.offsetHeight; // Trigger reflow
        table.style.display = 'table';
    });
}
document.addEventListener('DOMContentLoaded', function() {
    // Define o modo salvo no cookie ou padrão (dark)
    let mode = getCookie('theme') || 'dark';
    setMode(mode);
    // Botão de alternância
    const btn = document.getElementById('modeToggle');
    if (btn) {
        btn.addEventListener('click', function() {
            let current = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
            let next = current === 'dark' ? 'light' : 'dark';
            setMode(next);
        });
    }
});
</script>
</body>
</html>

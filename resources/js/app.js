import './bootstrap';


// Punto de entrada general — aquí van imports globales si se necesitan

// Auto-cerrar alertas después de 4 segundos
document.addEventListener('DOMContentLoaded', () => {
    const alerts = document.querySelectorAll('.alert-auto-dismiss');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 300);
        }, 4000);
    });
});

// Seleccionamos el contenedor de elementos
const palette = document.querySelector('.djs-palette');
if (palette) {
    // Creamos la línea
    const indicator = document.createElement('div');
    indicator.classList.add('scroll-indicator');
    palette.appendChild(indicator);

    // Función para actualizar posición y tamaño de la línea
    function updateIndicator() {
        const scrollWidth = palette.scrollWidth;
        const clientWidth = palette.clientWidth;
        const scrollLeft = palette.scrollLeft;

        const indicatorWidth = (clientWidth / scrollWidth) * clientWidth;
        const leftPos = (scrollLeft / scrollWidth) * clientWidth;

        indicator.style.width = `${indicatorWidth}px`;
        indicator.style.left = `${leftPos}px`;
    }

    // Eventos
    palette.addEventListener('scroll', updateIndicator);
    window.addEventListener('resize', updateIndicator);

    // Inicializar
    updateIndicator();
}


//Metod para confirmar eliminación con modal 
document.addEventListener('DOMContentLoaded', function() {
    let formToSubmit = null;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const confirmBtn = document.getElementById('confirmDeleteBtn');

    // Al hacer click en cualquier botón de basura
    document.querySelectorAll('.btn-delete-trigger').forEach(button => {
        button.addEventListener('click', function() {
            // Guardamos la referencia al formulario que queremos enviar
            formToSubmit = document.getElementById(this.getAttribute('data-form-id'));
            // Abrimos el modal
            deleteModal.show();
        });
    });

    // Al confirmar en el botón rojo del modal
    confirmBtn.addEventListener('click', function() {
        if (formToSubmit) {
            formToSubmit.submit();
        }
    });
});

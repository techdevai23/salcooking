// Script para manejar los filtros automáticamente
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Inicializando sistema de filtros con checkboxes...');

        // Función para obtener valores de checkboxes
        function getCheckboxValues(name) {
            const checkboxes = document.querySelectorAll(`input[name="${name}[]"]:checked`);
            return Array.from(checkboxes).map(cb => cb.value);
        }

        // Función para aplicar filtros
        function aplicarFiltros() {
            console.log('Aplicando filtros...');

            const params = new URLSearchParams(window.location.search);

            // Mantener el término de búsqueda si existe
            const termino = params.get('q') || '';

            // Construir nueva URL con filtros
            const nuevosParams = new URLSearchParams();
            if (termino) nuevosParams.set('q', termino);
            nuevosParams.set('page', 'buscar');

            // Obtener valores de los filtros
            const ordenar = document.getElementById('ordenar')?.value;
            const tiposPlato = getCheckboxValues('tipo-plato');
            const alergenos = getCheckboxValues('alergenos');
            const porciones = getCheckboxValues('porciones');
            const enfermedades = getCheckboxValues('enfermedades');
            const tiempos = getCheckboxValues('tiempo');
            const ingrediente = document.getElementById('ingrediente')?.value;
            const aplicarPerfilSalud = document.getElementById('aplicar_perfil_salud')?.checked;

            // Debug PARA CONTROL DE FILTROS APLICADOS
            console.log('Filtros activos:', {
                ordenar,
                tiposPlato,
                alergenos,
                porciones,
                enfermedades,
                tiempos,
                ingrediente,
                aplicarPerfilSalud
            });

            // Agregar filtros a la URL
            if (ordenar) {
                nuevosParams.set('orden', ordenar);
            }

            if (tiposPlato.length > 0) {
                nuevosParams.set('tipo_plato', tiposPlato.join(','));
            }

            if (alergenos.length > 0) {
                nuevosParams.set('alergeno', alergenos.join(','));
            }

            if (porciones.length > 0) {
                nuevosParams.set('porciones', porciones.join(','));
            }

            // Filtros premium (solo si están habilitados y tienen valor)
            const ingredienteElement = document.getElementById('ingrediente');
            const perfilElement = document.getElementById('perfil');

            if (enfermedades.length > 0 && !document.querySelector('input[name="enfermedades[]"]').disabled) {
                nuevosParams.set('enfermedad', enfermedades.join(','));
            }

            if (tiempos.length > 0 && !document.querySelector('input[name="tiempo[]"]').disabled) {
                nuevosParams.set('tiempo', tiempos.join(','));
            }

            if (ingredienteElement && ingredienteElement.value.trim() !== '' && !ingredienteElement.disabled) {
                nuevosParams.set('ingrediente', ingredienteElement.value.trim());
            }

            if (perfilElement && perfilElement.checked && !perfilElement.disabled) {
                nuevosParams.set('perfil', '1');
            }

            // Agregar el filtro de perfil de salud usando nuevosParams
            const perfilSalud = document.getElementById('aplicar_perfil_salud');
            if (perfilSalud && perfilSalud.checked && !perfilSalud.disabled) {
                nuevosParams.set('aplicar_perfil_salud', '1');
                console.log('Aplicando filtro de perfil de salud');
            } else {
                // Asegurarse de eliminar el parámetro si no está marcado
                nuevosParams.delete('aplicar_perfil_salud');
            }

            const urlFinal = 'index.php?' + nuevosParams.toString();
            console.log('URL final:', urlFinal);

            // Redirigir con los nuevos parámetros
            window.location.href = urlFinal;
        }

        // Agregar eventos a todos los filtros
        // Selector de ordenar
        const selectorOrdenar = document.getElementById('ordenar');
        if (selectorOrdenar) {
            selectorOrdenar.addEventListener('change', aplicarFiltros);
        }

        // Checkboxes
        const todosCheckboxes = document.querySelectorAll('input[type="checkbox"][name$="[]"]');
        todosCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', aplicarFiltros);
        });

        // Checkbox de perfil
        const checkboxPerfil = document.getElementById('perfil');
        if (checkboxPerfil) {
            checkboxPerfil.addEventListener('change', aplicarFiltros);
        }

        // Campo de ingrediente
        const campoIngrediente = document.getElementById('ingrediente');
        if (campoIngrediente) {
            campoIngrediente.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    aplicarFiltros();
                }
            });

            campoIngrediente.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    aplicarFiltros();
                }
            });
        }

        // Restaurar valores de filtros desde la URL
        console.log('Restaurando valores desde URL...');
        const params = new URLSearchParams(window.location.search);

        // Restaurar orden
        if (params.get('orden') && selectorOrdenar) {
            selectorOrdenar.value = params.get('orden');
        }

        // Restaurar checkboxes
        if (params.get('tipo_plato')) {
            const tipos = params.get('tipo_plato').split(',');
            tipos.forEach(tipo => {
                const checkbox = document.querySelector(`input[name="tipo-plato[]"][value="${tipo}"]`);
                if (checkbox) checkbox.checked = true;
            });
        }

        if (params.get('alergeno')) {
            const alergenos = params.get('alergeno').split(',');
            alergenos.forEach(alergeno => {
                const checkbox = document.querySelector(`input[name="alergenos[]"][value="${alergeno}"]`);
                if (checkbox) checkbox.checked = true;
            });
        }

        if (params.get('porciones')) {
            const porciones = params.get('porciones').split(',');
            porciones.forEach(porcion => {
                const checkbox = document.querySelector(`input[name="porciones[]"][value="${porcion}"]`);
                if (checkbox) checkbox.checked = true;
            });
        }

        /**********  Restaurar filtros premium *****************/
        // Filtros de enfermedades
        if (params.get('enfermedad')) {
            const enfermedades = params.get('enfermedad').split(',');
            enfermedades.forEach(enfermedad => {
                const checkbox = document.querySelector(`input[name="enfermedades[]"][value="${enfermedad}"]`);
                if (checkbox && !checkbox.disabled) checkbox.checked = true;
            });
        }
        // Filtros de tiempo
        if (params.get('tiempo')) {
            const tiempos = params.get('tiempo').split(',');
            tiempos.forEach(tiempo => {
                const checkbox = document.querySelector(`input[name="tiempo[]"][value="${tiempo}"]`);
                if (checkbox && !checkbox.disabled) checkbox.checked = true;
            });
        }
        // Filtros de ingrediente
        if (params.get('ingrediente') && campoIngrediente && !campoIngrediente.disabled) {
            campoIngrediente.value = params.get('ingrediente');
        }
        // Filtros de perfil de salud que tiene el usuario
        if (params.get('perfil') && checkboxPerfil && !checkboxPerfil.disabled) {
            checkboxPerfil.checked = params.get('perfil') === '1';
        }

        // Restaurar estado del checkbox de perfil de salud
        const perfilSaludCheckbox = document.getElementById('aplicar_perfil_salud');
        if (perfilSaludCheckbox) {
            perfilSaludCheckbox.checked = params.get('aplicar_perfil_salud') === '1';
            perfilSaludCheckbox.addEventListener('change', function() {
                console.log('Cambio en el checkbox de perfil de salud');
                aplicarFiltros();
            });
        }

        console.log('Sistema de filtros inicializado correctamente');
    });
    // Script para mostrar y ocultar los filtros premium
    document.addEventListener('DOMContentLoaded', function() {
        const premiumHeader = document.querySelector('.premium-header');
        const premiumOptions = document.querySelector('.premium-options');

        if (premiumHeader && premiumOptions) {
            premiumOptions.style.display = 'none'; // Ocultar inicialmente

            premiumHeader.addEventListener('click', function() {
                if (premiumOptions.style.display === 'none') {
                    premiumOptions.style.display = 'block';
                    premiumOptions.style.maxHeight = premiumOptions.scrollHeight + 'px';
                } else {
                    premiumOptions.style.maxHeight = '0';
                    setTimeout(() => {
                        premiumOptions.style.display = 'none';
                    }, 300); // Tiempo de la animación
                }
            });
        }
    });

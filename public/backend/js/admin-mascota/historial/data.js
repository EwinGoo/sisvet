export function anamnesisChange(element, data) {
    // console.log(data);
    
    const form = element.modalContent.find('form');
    
    if (!form.length) {
        console.error('Formulario no encontrado');
        return;
    }

    Object.entries(data.data.anamnesis).forEach(([key, value]) => {
        const input = form.find(`#${key}`);
        if (input.length) {
            if (input.is(':checkbox')) {
                input.prop('checked', value);
            } else if (input.is('select')) {
                input.val(value).trigger('change');
            } else if (input.is('textarea')) {
                input.val(value).trigger('input');
            } else {
                input.val(value);
            }

            // Activar cualquier evento o plugin de validación si es necesario
            input.trigger('input').trigger('change');

            // Si estás usando algún plugin de formularios como Select2 o Chosen
            if (input.hasClass('select2-hidden-accessible')) {
                input.trigger('select2:select');
            }
        } else {
            console.warn(`Campo '${key}' no encontrado en el formulario`);
        }
    });

    // Actualizar cualquier UI adicional si es necesario
    // form.find('input, select, textarea').each(function() {
    //     const $this = $(this);
    //     if ($this.val()) {
    //         $this.closest('.form-group').addClass('is-filled');
    //     }
    // });

    console.log('Formulario actualizado con los datos de anamnesis');
}
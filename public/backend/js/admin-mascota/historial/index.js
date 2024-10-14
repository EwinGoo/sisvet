import {
    anamnesisForm,
    examenForm,
    genericForm,
    evolucionForm,
} from "./forms.js";
import {anamnesisChange} from "./data.js";
import {listData} from "./table.js";

$(document).ready(function () {
    const MascotaManager = {
        elements: {
            currentOption:'',
            modalEl: $("#modal-main"),
            modalSize: $("#modal-size"),
            modalContent: $("#modal-content"),
            modalTitle: $("#modal-title"),
            currentId: $('#profile'),
            btnNew: $("#btn-new"),
            btnSubmit: $("#btn-submit"),
            dataTable: $("#datatable"), // Asumiendo que tienes una tabla
            tables:{
                examen: $('#table-examen'),
                sintomas: $('#table-sintomas'),
                diagnostico: $('#table-diagnostico'),
                tratamiento: $('#table-tratamiento'),
                evolucion: $('#table-evolucion')
            },
        },
        data: {
            anamnesis: [],
            examen: [],
            sintomas: [],
            diagnostico: [],
            tratamiento: [],
            evolucion: []
        },

        formOptions: {
            anamnesis: { generator: anamnesisForm, title: "Anamnesis", size: "lg", id:'id_historial' },
            examen: { generator: examenForm, title: "Examen", size: "lg", id:'id_examen' },
            sintomas: { generator: genericForm, title: "Síntomas", size: "md", id:'id_sintoma'},
            diagnostico: { generator: genericForm, title: "Diagnóstico", size: "md", id:'id_diagnostico'},
            tratamiento: { generator: genericForm, title: "Tratamiento", size: "md", id:'id_tratamiento' },
            evolucion: { generator: evolucionForm, title: "Evolución", size: "md", id:'id_evolucion' }
        },

        formUrls: {
            anamnesis: "/admin/mascota/anamnesis",
            examen: "/admin/mascota/examen",
            sintomas: "/admin/mascota/sintomas",
            diagnostico: "/admin/mascota/diagnostico",
            tratamiento: "/admin/mascota/tratamiento",
            evolucion: "/admin/mascota/evolucion"
        },

        init() {
            this.bindEvents();
            utilities.ajaxSetup();
            this.loadInitialData();
        },
        loadInitialData() {
            const id_historial = this.elements.currentId.data('id');
            $.ajax({
                url: `/admin/mascota/historial/${id_historial}/data`,
                method: 'GET',
                success: (response) => {
                    this.data = response;
                    console.log(this.data);
                    this.loadAnamnesis(this.data.data);
                    this.loadExamenGeneral(this.data.data);
                    this.loadSintomas(this.data.data);
                    this.loadDiagnostico(this.data.data);
                    this.loadEvolucion(this.data.data);
                    this.loadTratamiento(this.data.data);
                    // this.updateUI();
                },
                error: (xhr, status, error) => {
                    console.error("Error al cargar los datos iniciales:", error);
                    // Mostrar mensaje de error al usuario
                }
            });
        },
        loadAnamnesis(data){
            let anamnesis;
            if (typeof data.anamnesis === 'object') {
                anamnesis = data.anamnesis; 
            }else{
                anamnesis = data.data; 
                this.data.data.anamnesis = data.data;
            }
            $('#ult_des').text(anamnesis.ultima_desparasitacion);
            $('#vac').text(anamnesis.vacunas);
            $('#tra_rec').text(anamnesis.tratamientos_recientes);
            $('#enf_ant').text(anamnesis.enfermedades_anteriores);
        },
        loadExamenGeneral(data){
            console.log(data.examen);
            listData(data.examen,this.elements.tables.examen,1)
        },
        loadSintomas(data){
            // console.log(data.examen);
            listData(data.sintomas,this.elements.tables.sintomas)
        },
        loadDiagnostico(data){
            // console.log(data.examen);
            listData(data.diagnostico,this.elements.tables.diagnostico)
        },
        loadTratamiento(data){
            // console.log(data.examen);
            listData(data.tratamiento,this.elements.tables.tratamiento)
        },
        loadEvolucion(data){
            // console.log(data.examen);
            listData(data.evolucion,this.elements.tables.evolucion)
        },
        updateUI() {
            // Actualizar la interfaz con los datos cargados
            // Por ejemplo, actualizar contadores, listas, etc.
            Object.keys(this.data).forEach(key => {
                const count = this.data[key].length;
                $(`#${key}-count`).text(count); // Asumiendo que tienes elementos para mostrar conteos
            });
        },

        bindEvents() {
            $(document).on("click", ".new", this.handleNew.bind(this));
            this.elements.btnSubmit.on("click", this.handleSubmit.bind(this));
        },
        handleNew(e) {
            let option = $(e.currentTarget).data("action");
            this.elements.modalEl.modal("show");
            this.optionChange(option);
        },
        optionChange(option) {
            this.elements.modalContent.empty();
            if (this.formOptions.hasOwnProperty(option)) {
                const { generator, title, size } = this.formOptions[option];
                const formHtml = generator();
                this.elements.currentOption = option;
                this.elements.modalContent.html(formHtml);
                this.elements.modalTitle.text(title);
                this.elements.modalSize.removeClass("modal-lg modal-md").addClass(`modal-${size}`);
                this.initializeForm(option);
            } else {
                console.log("Opción no reconocida:", option);
            }
        },

        initializeForm(formType) {
            switch(formType) {
                case 'anamnesis':
                    // console.log('yes');
                    anamnesisChange(this.elements,this.data);
                    break;
                case 'examen':
                    // Inicialización específica para examen
                    break;
                case 'sintomas':
                    // Inicialización específica para examen
                    this.
                    break;
                // ... otros casos según sea necesario
            }
            if (this.data[formType] && this.data[formType].length > 0) {
                // Ejemplo: pre-llenar el último registro
                const lastRecord = this.data[formType][this.data[formType].length - 1];
                Object.keys(lastRecord).forEach(key => {
                    $(`#${key}`).val(lastRecord[key]);
                });
            }        
        },
        handleSubmit(e) {
            e.preventDefault();
            let formData = this.elements.modalContent.find('form').serialize();
            formData += '&id_historial=' + this.elements.currentId.data('id');
            formData += '&option=' + this.elements.currentOption;
            // console.log("Datos a enviar:", formData);
            
            $.ajax({
                url: this.formUrls[this.elements.currentOption],
                type: 'POST',
                data: formData,
                success: (response) => {
                    console.log(response);
                    
                    console.log("Formulario enviado con éxito:", this.currentFormType);
                    this.elements.modalEl.modal("hide");
                    // this.reloadTable();

                    this.updateLocalData(this.elements.currentOption, response.data);

                    // this.loadAnamnesis(response);
                    this.loadSintomas(response);
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Éxito',
                    //     text: 'Datos guardados correctamente'
                    // });
                },
                error: (xhr, status, error) => {
                    console.error("Error al enviar el formulario:", this.currentFormType, error);
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: 'Error',
                    //     text: 'Error al guardar los datos. Por favor, intente de nuevo.'
                    // });
                }
            });
        },

        reloadTable() {
            if (this.elements.dataTable.DataTable) {
                this.elements.dataTable.DataTable().ajax.reload();
            }
        },
        updateLocalData(dataType, newData) {
            const validTypes = ['anamnesis', 'examen', 'sintomas', 'diagnostico', 'tratamiento', 'evolucion'];

            if (validTypes.includes(dataType)) {
                if (dataType === 'anamnesis') {
                    // Anamnesis es un objeto, no un array
                    this.data[dataType] = newData;
                } else {
                    // Para los demás tipos, que son arrays
                    // if (!Array.isArray(this.data[dataType])) {  
                    //     this.data[dataType] = [];
                    // }
                    
                    // Verificar si el nuevo dato ya existe en el array
                    const existingIndex = this.data.data[dataType].findIndex(item => item[this.formOptions[this.elements.currentOption].id] === newData[this.formOptions[this.elements.currentOption].id]);
                    
                    if (existingIndex !== -1) {
                        // Actualizar el elemento existente
                        this.data.data[dataType][existingIndex] = newData;
                    } else {
                        // Agregar el nuevo elemento
                        this.data.data[dataType].push(newData);
                    }
                }
                console.log(this.data);
                
                this.loadSintomas(this.data.data);
                this.loadDiagnostico(this.data.data);
                this.loadTratamiento(this.data.data);
                this.loadEvolucion(this.data.data);
                
                console.log(`Datos de ${dataType} actualizados:`, this.data[dataType]);
            } else {
                console.error(`Tipo de dato '${dataType}' no válido`);
            }
        }
    };

    MascotaManager.init();
});
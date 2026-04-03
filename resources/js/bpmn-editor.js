import BpmnModeler from 'bpmn-js/lib/Modeler';
import 'bpmn-js/dist/assets/diagram-js.css';
import 'bpmn-js/dist/assets/bpmn-font/css/bpmn.css';


// XML vacío por defecto para diagramas nuevos
const EMPTY_BPMN = `<?xml version="1.0" encoding="UTF-8"?>
<definitions xmlns="http://www.omg.org/spec/BPMN/20100524/MODEL"
             xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
             xmlns:activiti="http://activiti.org/bpmn"
             xmlns:bpmndi="http://www.omg.org/spec/BPMN/20100524/DI"
             xmlns:omgdc="http://www.omg.org/spec/DD/20100524/DC"
             xmlns:omgdi="http://www.omg.org/spec/DD/20100524/DI"
             typeLanguage="http://www.w3.org/2001/XMLSchema"
             expressionLanguage="http://www.w3.org/1999/XPath"
             targetNamespace="http://www.activiti.org/test">
  <process id="process_1" name="Nuevo Proceso" isExecutable="true">
    <startEvent id="start_1" name="Inicio"/>
  </process>
  <bpmndi:BPMNDiagram id="BPMNDiagram_1">
    <bpmndi:BPMNPlane id="BPMNPlane_1" bpmnElement="process_1">
      <bpmndi:BPMNShape id="start_1_di" bpmnElement="start_1">
        <omgdc:Bounds x="152" y="82" width="36" height="36"/>
      </bpmndi:BPMNShape>
    </bpmndi:BPMNPlane>
  </bpmndi:BPMNDiagram>
</definitions>`;

// Inicializar el modeler
const modeler = new BpmnModeler({
    container: '#bpmn-container',
});

// Cargar XML existente (edición) o vacío (creación)
async function initDiagram() {
    // El blade pasa el XML via un elemento hidden o data attribute
    const xmlInput  = document.getElementById('bpmn_xml');
    const xmlToLoad = (xmlInput && xmlInput.value.trim()) ? xmlInput.value : EMPTY_BPMN;

    try {
        await modeler.importXML(xmlToLoad);
        modeler.get('canvas').zoom('fit-viewport');
    } catch (err) {
        console.error('Error al cargar el diagrama:', err);
        // Si el XML guardado está corrupto, cargamos el vacío
        await modeler.importXML(EMPTY_BPMN);
        modeler.get('canvas').zoom('fit-viewport');
    }
}

// Antes de enviar el formulario, extraemos el XML actualizado
async function syncXmlToForm() {
    try {
        const { xml } = await modeler.saveXML({ format: true });
        document.getElementById('bpmn_xml').value = xml;
        return true;
    } catch (err) {
        console.error('Error al exportar el XML:', err);
        alert('No se pudo guardar el diagrama. Por favor intenta de nuevo.');
        return false;
    }
}

// Escuchar el submit del formulario
document.addEventListener('DOMContentLoaded', () => {
    initDiagram();

    const form = document.getElementById('process-form');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const ok = await syncXmlToForm();
            if (ok) form.submit();
        });
    }

    // Botón "Centrar diagrama"
    const btnFit = document.getElementById('btn-fit-viewport');
    if (btnFit) {
        btnFit.addEventListener('click', () => {
            modeler.get('canvas').zoom('fit-viewport');
        });
    }

    // Botón "Deshacer"
    const btnUndo = document.getElementById('btn-undo');
    if (btnUndo) {
        btnUndo.addEventListener('click', () => {
            modeler.get('commandStack').undo();
        });
    }

    // Botón "Rehacer"
    const btnRedo = document.getElementById('btn-redo');
    if (btnRedo) {
        btnRedo.addEventListener('click', () => {
            modeler.get('commandStack').redo();
        });
    }
});
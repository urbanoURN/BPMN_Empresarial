import BpmnViewer from 'bpmn-js/lib/NavigatedViewer';
import 'bpmn-js/dist/assets/diagram-js.css';
import 'bpmn-js/dist/assets/bpmn-font/css/bpmn.css';


document.addEventListener('DOMContentLoaded', async () => {
    const container  = document.getElementById('bpmn-viewer-container');
    const xmlElement = document.getElementById('bpmn-xml-data');

    if (!container || !xmlElement) return;

    const viewer = new BpmnViewer({ container });

    try {
        await viewer.importXML(xmlElement.textContent.trim());
        viewer.get('canvas').zoom('fit-viewport');
    } catch (err) {
        console.error('Error al visualizar el diagrama:', err);
        container.innerHTML = `
            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                <div class="text-center">
                    <i class="bi bi-exclamation-triangle fs-1"></i>
                    <p class="mt-2">No se pudo cargar el diagrama.</p>
                </div>
            </div>`;
    }
});

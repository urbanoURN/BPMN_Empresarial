<?php

namespace Database\Seeders;

use App\Models\Process;
use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    /**
     * Poblar la base de datos con procesos BPMN de ejemplo.
     * Permite al evaluador ver el sistema funcionando sin crear datos manualmente.
     */
    public function run(): void
    {
        $processes = [
            [
                'name'        => 'Proceso de Ventas',
                'description' => 'Flujo completo del proceso comercial: desde la recepción del lead hasta el cierre de la venta y la entrega del producto al cliente.',
                'bpmn_xml'    => $this->ventasXml(),
            ],
            [
                'name'        => 'Onboarding de Empleados',
                'description' => 'Proceso de incorporación de nuevos colaboradores: documentación, accesos al sistema, inducción y asignación de equipo de trabajo.',
                'bpmn_xml'    => $this->onboardingXml(),
            ],
            [
                'name'        => 'Aprobación de Solicitudes',
                'description' => 'Flujo de aprobación de solicitudes internas con revisión de jefatura, validación de presupuesto y notificación al solicitante.',
                'bpmn_xml'    => $this->aprobacionXml(),
            ],
        ];

        foreach ($processes as $data) {
            Process::create($data);
        }
    }

    // -------------------------------------------------------------------------
    // XMLs de ejemplo — diagramas BPMN válidos listos para visualizar
    // -------------------------------------------------------------------------

    private function ventasXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
<definitions xmlns="http://www.omg.org/spec/BPMN/20100524/MODEL"
             xmlns:bpmndi="http://www.omg.org/spec/BPMN/20100524/DI"
             xmlns:omgdc="http://www.omg.org/spec/DD/20100524/DC"
             xmlns:omgdi="http://www.omg.org/spec/DD/20100524/DI"
             xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
             targetNamespace="http://bpmn.io/schema/bpmn"
             id="definitions_ventas">

  <process id="ventas_process" name="Proceso de Ventas" isExecutable="true">

    <startEvent id="start" name="Lead recibido">
      <outgoing>flow1</outgoing>
    </startEvent>

    <task id="task_contacto" name="Contactar al cliente">
      <incoming>flow1</incoming>
      <outgoing>flow2</outgoing>
    </task>

    <task id="task_propuesta" name="Enviar propuesta comercial">
      <incoming>flow2</incoming>
      <outgoing>flow3</outgoing>
    </task>

    <exclusiveGateway id="gw_decision" name="¿Acepta propuesta?">
      <incoming>flow3</incoming>
      <outgoing>flow4</outgoing>
      <outgoing>flow5</outgoing>
    </exclusiveGateway>

    <task id="task_cierre" name="Cerrar venta y facturar">
      <incoming>flow4</incoming>
      <outgoing>flow6</outgoing>
    </task>

    <task id="task_rechazo" name="Registrar rechazo y hacer seguimiento">
      <incoming>flow5</incoming>
      <outgoing>flow7</outgoing>
    </task>

    <task id="task_entrega" name="Coordinar entrega del producto">
      <incoming>flow6</incoming>
      <outgoing>flow8</outgoing>
    </task>

    <endEvent id="end_exitoso" name="Venta completada">
      <incoming>flow8</incoming>
    </endEvent>

    <endEvent id="end_rechazado" name="Lead descartado">
      <incoming>flow7</incoming>
    </endEvent>

    <sequenceFlow id="flow1" sourceRef="start" targetRef="task_contacto"/>
    <sequenceFlow id="flow2" sourceRef="task_contacto" targetRef="task_propuesta"/>
    <sequenceFlow id="flow3" sourceRef="task_propuesta" targetRef="gw_decision"/>
    <sequenceFlow id="flow4" sourceRef="gw_decision" targetRef="task_cierre" name="Sí"/>
    <sequenceFlow id="flow5" sourceRef="gw_decision" targetRef="task_rechazo" name="No"/>
    <sequenceFlow id="flow6" sourceRef="task_cierre" targetRef="task_entrega"/>
    <sequenceFlow id="flow7" sourceRef="task_rechazo" targetRef="end_rechazado"/>
    <sequenceFlow id="flow8" sourceRef="task_entrega" targetRef="end_exitoso"/>
  </process>

  <bpmndi:BPMNDiagram id="BPMNDiagram_ventas">
    <bpmndi:BPMNPlane id="BPMNPlane_ventas" bpmnElement="ventas_process">

      <bpmndi:BPMNShape id="start_di" bpmnElement="start">
        <omgdc:Bounds x="152" y="102" width="36" height="36"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="130" y="145" width="80" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>

      <bpmndi:BPMNShape id="task_contacto_di" bpmnElement="task_contacto">
        <omgdc:Bounds x="240" y="80" width="120" height="80"/>
      </bpmndi:BPMNShape>

      <bpmndi:BPMNShape id="task_propuesta_di" bpmnElement="task_propuesta">
        <omgdc:Bounds x="420" y="80" width="120" height="80"/>
      </bpmndi:BPMNShape>

      <bpmndi:BPMNShape id="gw_decision_di" bpmnElement="gw_decision" isMarkerVisible="true">
        <omgdc:Bounds x="600" y="95" width="50" height="50"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="570" y="152" width="110" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>

      <bpmndi:BPMNShape id="task_cierre_di" bpmnElement="task_cierre">
        <omgdc:Bounds x="710" y="80" width="120" height="80"/>
      </bpmndi:BPMNShape>

      <bpmndi:BPMNShape id="task_rechazo_di" bpmnElement="task_rechazo">
        <omgdc:Bounds x="580" y="230" width="140" height="80"/>
      </bpmndi:BPMNShape>

      <bpmndi:BPMNShape id="task_entrega_di" bpmnElement="task_entrega">
        <omgdc:Bounds x="890" y="80" width="120" height="80"/>
      </bpmndi:BPMNShape>

      <bpmndi:BPMNShape id="end_exitoso_di" bpmnElement="end_exitoso">
        <omgdc:Bounds x="1072" y="102" width="36" height="36"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="1048" y="145" width="84" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>

      <bpmndi:BPMNShape id="end_rechazado_di" bpmnElement="end_rechazado">
        <omgdc:Bounds x="780" y="252" width="36" height="36"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="752" y="295" width="92" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>

      <bpmndi:BPMNEdge id="flow1_di" bpmnElement="flow1">
        <omgdi:waypoint x="188" y="120"/><omgdi:waypoint x="240" y="120"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="flow2_di" bpmnElement="flow2">
        <omgdi:waypoint x="360" y="120"/><omgdi:waypoint x="420" y="120"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="flow3_di" bpmnElement="flow3">
        <omgdi:waypoint x="540" y="120"/><omgdi:waypoint x="600" y="120"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="flow4_di" bpmnElement="flow4">
        <omgdi:waypoint x="650" y="120"/><omgdi:waypoint x="710" y="120"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="flow5_di" bpmnElement="flow5">
        <omgdi:waypoint x="625" y="145"/><omgdi:waypoint x="625" y="270"/><omgdi:waypoint x="580" y="270"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="flow6_di" bpmnElement="flow6">
        <omgdi:waypoint x="830" y="120"/><omgdi:waypoint x="890" y="120"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="flow7_di" bpmnElement="flow7">
        <omgdi:waypoint x="720" y="270"/><omgdi:waypoint x="780" y="270"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="flow8_di" bpmnElement="flow8">
        <omgdi:waypoint x="1010" y="120"/><omgdi:waypoint x="1072" y="120"/>
      </bpmndi:BPMNEdge>

    </bpmndi:BPMNPlane>
  </bpmndi:BPMNDiagram>
</definitions>';
    }

    private function onboardingXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
<definitions xmlns="http://www.omg.org/spec/BPMN/20100524/MODEL"
             xmlns:bpmndi="http://www.omg.org/spec/BPMN/20100524/DI"
             xmlns:omgdc="http://www.omg.org/spec/DD/20100524/DC"
             xmlns:omgdi="http://www.omg.org/spec/DD/20100524/DI"
             targetNamespace="http://bpmn.io/schema/bpmn"
             id="definitions_onboarding">

  <process id="onboarding_process" name="Onboarding de Empleados" isExecutable="true">

    <startEvent id="start" name="Empleado contratado">
      <outgoing>f1</outgoing>
    </startEvent>

    <task id="t_documentos" name="Recopilar documentación">
      <incoming>f1</incoming>
      <outgoing>f2</outgoing>
    </task>

    <task id="t_accesos" name="Crear accesos al sistema">
      <incoming>f2</incoming>
      <outgoing>f3</outgoing>
    </task>

    <task id="t_equipo" name="Asignar equipo de trabajo">
      <incoming>f3</incoming>
      <outgoing>f4</outgoing>
    </task>

    <task id="t_induccion" name="Sesión de inducción">
      <incoming>f4</incoming>
      <outgoing>f5</outgoing>
    </task>

    <task id="t_asignacion" name="Asignar a equipo y proyecto">
      <incoming>f5</incoming>
      <outgoing>f6</outgoing>
    </task>

    <endEvent id="end" name="Onboarding completado">
      <incoming>f6</incoming>
    </endEvent>

    <sequenceFlow id="f1" sourceRef="start" targetRef="t_documentos"/>
    <sequenceFlow id="f2" sourceRef="t_documentos" targetRef="t_accesos"/>
    <sequenceFlow id="f3" sourceRef="t_accesos" targetRef="t_equipo"/>
    <sequenceFlow id="f4" sourceRef="t_equipo" targetRef="t_induccion"/>
    <sequenceFlow id="f5" sourceRef="t_induccion" targetRef="t_asignacion"/>
    <sequenceFlow id="f6" sourceRef="t_asignacion" targetRef="end"/>
  </process>

  <bpmndi:BPMNDiagram id="BPMNDiagram_onboarding">
    <bpmndi:BPMNPlane id="BPMNPlane_onboarding" bpmnElement="onboarding_process">

      <bpmndi:BPMNShape id="start_di" bpmnElement="start">
        <omgdc:Bounds x="152" y="102" width="36" height="36"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="125" y="145" width="90" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="t_documentos_di" bpmnElement="t_documentos">
        <omgdc:Bounds x="240" y="80" width="120" height="80"/>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="t_accesos_di" bpmnElement="t_accesos">
        <omgdc:Bounds x="420" y="80" width="120" height="80"/>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="t_equipo_di" bpmnElement="t_equipo">
        <omgdc:Bounds x="600" y="80" width="120" height="80"/>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="t_induccion_di" bpmnElement="t_induccion">
        <omgdc:Bounds x="780" y="80" width="120" height="80"/>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="t_asignacion_di" bpmnElement="t_asignacion">
        <omgdc:Bounds x="960" y="80" width="120" height="80"/>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="end_di" bpmnElement="end">
        <omgdc:Bounds x="1142" y="102" width="36" height="36"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="1115" y="145" width="90" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>

      <bpmndi:BPMNEdge id="f1_di" bpmnElement="f1">
        <omgdi:waypoint x="188" y="120"/><omgdi:waypoint x="240" y="120"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f2_di" bpmnElement="f2">
        <omgdi:waypoint x="360" y="120"/><omgdi:waypoint x="420" y="120"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f3_di" bpmnElement="f3">
        <omgdi:waypoint x="540" y="120"/><omgdi:waypoint x="600" y="120"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f4_di" bpmnElement="f4">
        <omgdi:waypoint x="720" y="120"/><omgdi:waypoint x="780" y="120"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f5_di" bpmnElement="f5">
        <omgdi:waypoint x="900" y="120"/><omgdi:waypoint x="960" y="120"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f6_di" bpmnElement="f6">
        <omgdi:waypoint x="1080" y="120"/><omgdi:waypoint x="1142" y="120"/>
      </bpmndi:BPMNEdge>

    </bpmndi:BPMNPlane>
  </bpmndi:BPMNDiagram>
</definitions>';
    }

    private function aprobacionXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
<definitions xmlns="http://www.omg.org/spec/BPMN/20100524/MODEL"
             xmlns:bpmndi="http://www.omg.org/spec/BPMN/20100524/DI"
             xmlns:omgdc="http://www.omg.org/spec/DD/20100524/DC"
             xmlns:omgdi="http://www.omg.org/spec/DD/20100524/DI"
             targetNamespace="http://bpmn.io/schema/bpmn"
             id="definitions_aprobacion">

  <process id="aprobacion_process" name="Aprobación de Solicitudes" isExecutable="true">

    <startEvent id="start" name="Solicitud recibida">
      <outgoing>f1</outgoing>
    </startEvent>

    <task id="t_revision" name="Revisar solicitud">
      <incoming>f1</incoming>
      <outgoing>f2</outgoing>
    </task>

    <exclusiveGateway id="gw_completa" name="¿Solicitud completa?">
      <incoming>f2</incoming>
      <outgoing>f3</outgoing>
      <outgoing>f4</outgoing>
    </exclusiveGateway>

    <task id="t_subsanar" name="Solicitar información adicional">
      <incoming>f4</incoming>
      <outgoing>f5</outgoing>
    </task>

    <task id="t_presupuesto" name="Validar presupuesto">
      <incoming>f3</incoming>
      <outgoing>f6</outgoing>
    </task>

    <exclusiveGateway id="gw_presupuesto" name="¿Presupuesto disponible?">
      <incoming>f6</incoming>
      <outgoing>f7</outgoing>
      <outgoing>f8</outgoing>
    </exclusiveGateway>

    <task id="t_aprobar" name="Aprobar y notificar al solicitante">
      <incoming>f7</incoming>
      <outgoing>f9</outgoing>
    </task>

    <task id="t_rechazar" name="Rechazar y notificar motivo">
      <incoming>f8</incoming>
      <outgoing>f10</outgoing>
    </task>

    <endEvent id="end_aprobado" name="Solicitud aprobada">
      <incoming>f9</incoming>
    </endEvent>

    <endEvent id="end_rechazado" name="Solicitud rechazada">
      <incoming>f10</incoming>
    </endEvent>

    <endEvent id="end_pendiente" name="Esperando información">
      <incoming>f5</incoming>
    </endEvent>

    <sequenceFlow id="f1" sourceRef="start" targetRef="t_revision"/>
    <sequenceFlow id="f2" sourceRef="t_revision" targetRef="gw_completa"/>
    <sequenceFlow id="f3" sourceRef="gw_completa" targetRef="t_presupuesto" name="Sí"/>
    <sequenceFlow id="f4" sourceRef="gw_completa" targetRef="t_subsanar" name="No"/>
    <sequenceFlow id="f5" sourceRef="t_subsanar" targetRef="end_pendiente"/>
    <sequenceFlow id="f6" sourceRef="t_presupuesto" targetRef="gw_presupuesto"/>
    <sequenceFlow id="f7" sourceRef="gw_presupuesto" targetRef="t_aprobar" name="Sí"/>
    <sequenceFlow id="f8" sourceRef="gw_presupuesto" targetRef="t_rechazar" name="No"/>
    <sequenceFlow id="f9" sourceRef="t_aprobar" targetRef="end_aprobado"/>
    <sequenceFlow id="f10" sourceRef="t_rechazar" targetRef="end_rechazado"/>
  </process>

  <bpmndi:BPMNDiagram id="BPMNDiagram_aprobacion">
    <bpmndi:BPMNPlane id="BPMNPlane_aprobacion" bpmnElement="aprobacion_process">

      <bpmndi:BPMNShape id="start_di" bpmnElement="start">
        <omgdc:Bounds x="152" y="192" width="36" height="36"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="125" y="235" width="90" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="t_revision_di" bpmnElement="t_revision">
        <omgdc:Bounds x="240" y="170" width="120" height="80"/>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="gw_completa_di" bpmnElement="gw_completa" isMarkerVisible="true">
        <omgdc:Bounds x="420" y="185" width="50" height="50"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="390" y="242" width="110" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="t_subsanar_di" bpmnElement="t_subsanar">
        <omgdc:Bounds x="400" y="330" width="140" height="80"/>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="t_presupuesto_di" bpmnElement="t_presupuesto">
        <omgdc:Bounds x="530" y="170" width="130" height="80"/>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="gw_presupuesto_di" bpmnElement="gw_presupuesto" isMarkerVisible="true">
        <omgdc:Bounds x="720" y="185" width="50" height="50"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="688" y="242" width="114" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="t_aprobar_di" bpmnElement="t_aprobar">
        <omgdc:Bounds x="830" y="170" width="130" height="80"/>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="t_rechazar_di" bpmnElement="t_rechazar">
        <omgdc:Bounds x="700" y="330" width="130" height="80"/>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="end_aprobado_di" bpmnElement="end_aprobado">
        <omgdc:Bounds x="1022" y="192" width="36" height="36"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="998" y="235" width="84" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="end_rechazado_di" bpmnElement="end_rechazado">
        <omgdc:Bounds x="892" y="352" width="36" height="36"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="865" y="395" width="90" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="end_pendiente_di" bpmnElement="end_pendiente">
        <omgdc:Bounds x="600" y="352" width="36" height="36"/>
        <bpmndi:BPMNLabel><omgdc:Bounds x="573" y="395" width="90" height="14"/></bpmndi:BPMNLabel>
      </bpmndi:BPMNShape>

      <bpmndi:BPMNEdge id="f1_di" bpmnElement="f1">
        <omgdi:waypoint x="188" y="210"/><omgdi:waypoint x="240" y="210"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f2_di" bpmnElement="f2">
        <omgdi:waypoint x="360" y="210"/><omgdi:waypoint x="420" y="210"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f3_di" bpmnElement="f3">
        <omgdi:waypoint x="470" y="210"/><omgdi:waypoint x="530" y="210"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f4_di" bpmnElement="f4">
        <omgdi:waypoint x="445" y="235"/><omgdi:waypoint x="445" y="370"/><omgdi:waypoint x="400" y="370"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f5_di" bpmnElement="f5">
        <omgdi:waypoint x="540" y="370"/><omgdi:waypoint x="600" y="370"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f6_di" bpmnElement="f6">
        <omgdi:waypoint x="660" y="210"/><omgdi:waypoint x="720" y="210"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f7_di" bpmnElement="f7">
        <omgdi:waypoint x="770" y="210"/><omgdi:waypoint x="830" y="210"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f8_di" bpmnElement="f8">
        <omgdi:waypoint x="745" y="235"/><omgdi:waypoint x="745" y="370"/><omgdi:waypoint x="700" y="370"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f9_di" bpmnElement="f9">
        <omgdi:waypoint x="960" y="210"/><omgdi:waypoint x="1022" y="210"/>
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="f10_di" bpmnElement="f10">
        <omgdi:waypoint x="830" y="370"/><omgdi:waypoint x="892" y="370"/>
      </bpmndi:BPMNEdge>

    </bpmndi:BPMNPlane>
  </bpmndi:BPMNDiagram>
</definitions>';
    }
}
<?php
class PdfGenerator
{

    // Generar reporte de clientes
    public static function generarReporteClientes($clientes)
    {
        $html = self::generarHtmlClientes($clientes);
        self::enviarPdf($html, "reporte_clientes.pdf");
    }

    // Generar reporte de proyectos
    public static function generarReporteProyectos($proyectos)
    {
        $html = self::generarHtmlProyectos($proyectos);
        self::enviarPdf($html, "reporte_proyectos.pdf");
    }

    // Generar reporte de programadores
    public static function generarReporteProgramadores($programadores)
    {
        $html = self::generarHtmlProgramadores($programadores);
        self::enviarPdf($html, "reporte_programadores.pdf");
    }

    private static function generarHtmlClientes($clientes)
    {
        $rows = '';
        foreach ($clientes as $c) {
            $rows .= '<tr><td>' . htmlspecialchars($c['id']) . '</td><td>' . htmlspecialchars($c['nombre']) .
                '</td><td>' . htmlspecialchars($c['empresa']) . '</td><td>' . htmlspecialchars($c['email']) .
                '</td><td>' . htmlspecialchars($c['telefono']) . '</td></tr>';
        }
        return self::generarHtmlBase('Reporte de Clientes', [
            '<th>ID</th><th>Nombre</th><th>Empresa</th><th>Email</th><th>Teléfono</th>'
        ], $rows, '#4CAF50');
    }

    private static function generarHtmlProyectos($proyectos)
    {
        $rows = '';
        foreach ($proyectos as $p) {
            $estadoClass = str_replace(' ', '_', $p['estado'] ?? 'pendiente');
            $fechaInicio = !empty($p['fecha_inicio']) ? date('d/m/Y', strtotime($p['fecha_inicio'])) : 'N/A';
            $fechaFin = !empty($p['fecha_fin']) ? date('d/m/Y', strtotime($p['fecha_fin'])) : 'N/A';
            $presupuesto = isset($p['presupuesto']) ? number_format($p['presupuesto'], 2) : '0.00';
            $estado = ucfirst(str_replace('_', ' ', $p['estado'] ?? 'pendiente'));
            $rows .= '<tr><td>' . htmlspecialchars($p['id']) . '</td><td>' . htmlspecialchars($p['nombre']) .
                '</td><td>' . htmlspecialchars($p['cliente_nombre'] ?? 'N/A') . '</td><td>' . $fechaInicio .
                '</td><td>' . $fechaFin . '</td><td><span class="estado ' . $estadoClass . '">' . $estado .
                '</span></td><td>S/. ' . $presupuesto . '</td></tr>';
        }
        $html = self::generarHtmlBase('Reporte de Proyectos', [
            '<th>ID</th><th>Proyecto</th><th>Cliente</th><th>Inicio</th><th>Fin</th><th>Estado</th><th>Presupuesto</th>'
        ], $rows, '#2196F3');
        $html = str_replace('table {', 'table { font-size: 12px;', $html);
        $html = str_replace('</style>', '.estado { padding: 3px 8px; border-radius: 3px; font-weight: bold; }
                .pendiente { background-color: #FFC107; }
                .en_proceso { background-color: #2196F3; color: white; }
                .completado { background-color: #4CAF50; color: white; }
                .cancelado { background-color: #f44336; color: white; }</style>', $html);
        return $html;
    }

    private static function generarHtmlProgramadores($programadores)
    {
        $rows = '';
        foreach ($programadores as $prog) {
            $estadoClass = $prog['estado'] === 'disponible' ? 'disponible' : 'ocupado';
            $estado = ucfirst($prog['estado']);
            $rows .= '<tr><td>' . htmlspecialchars($prog['id']) . '</td><td>' . htmlspecialchars($prog['nombre']) .
                '</td><td>' . htmlspecialchars($prog['email']) . '</td><td>' . htmlspecialchars($prog['telefono']) .
                '</td><td>' . htmlspecialchars($prog['especialidad']) . '</td><td><span class="estado ' . $estadoClass . '">' . $estado .
                '</span></td></tr>';
        }
        $html = self::generarHtmlBase('Reporte de Programadores', [
            '<th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Especialidad</th><th>Estado</th>'
        ], $rows, '#9C27B0');
        $html = str_replace('table {', 'table { font-size: 12px;', $html);
        $html = str_replace('</style>', '.estado { padding: 3px 8px; border-radius: 3px; font-weight: bold; }
                .disponible { background-color: #4CAF50; color: white; }
                .ocupado { background-color: #FFC107; }</style>', $html);
        return $html;
    }

    private static function generarHtmlBase($titulo, $headers, $rows, $colorHeader)
    {
        return '<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { color: #333; text-align: center; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background-color: ' . $colorHeader . '; color: white; padding: 10px; text-align: left; }
                td { border: 1px solid #ddd; padding: 8px; }
                tr:nth-child(even) { background-color: #f2f2f2; }
                .fecha { text-align: center; margin-top: 30px; color: #666; }
            </style></head><body>
            <h1>' . $titulo . '</h1>
            <p><strong>Fecha:</strong> ' . date('d/m/Y H:i') . '</p>
            <table><thead><tr>' . implode('', $headers) . '</tr></thead><tbody>' . $rows .
            '</tbody></table>
            <div class="fecha"><p>TecnoSoluciones S.A. - Sistema de Gestión de Proyectos</p></div>
        </body></html>';
    }

    // Enviar HTML como PDF usando headers
    private static function enviarPdf($html, $nombreArchivo)
    {
        // Limpiar cualquier output previo
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Iniciar buffer de salida
        ob_start();

        // Configurar headers para HTML (no PDF, ya que estamos usando window.print)
        header('Content-Type: text/html; charset=UTF-8');

        // Extraer solo el contenido del body del HTML generado
        $bodyContent = '';
        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $matches)) {
            $bodyContent = $matches[1];
        } else {
            $bodyContent = $html;
        }

        // Extraer estilos del head
        $styles = '';
        if (preg_match('/<style[^>]*>(.*?)<\/style>/is', $html, $matches)) {
            $styles = $matches[1];
        }

        // Generar página HTML completa con estilos de impresión
        echo '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . htmlspecialchars($nombreArchivo) . '</title>
            <style>
                ' . $styles . '
                @media print {
                    body { margin: 0; padding: 20px; }
                    .no-print { display: none !important; }
                    @page { margin: 1cm; }
                }
                @media screen {
                    body { margin: 20px; }
                    .no-print {
                        margin-bottom: 20px;
                        padding: 10px;
                        background-color: #f0f0f0;
                        border-radius: 5px;
                    }
                }
                .btn-print {
                    background-color: #4CAF50;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 16px;
                    margin-right: 10px;
                }
                .btn-print:hover {
                    background-color: #45a049;
                }
                .btn-back {
                    background-color: #2196F3;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 16px;
                    text-decoration: none;
                    display: inline-block;
                }
                .btn-back:hover {
                    background-color: #0b7dda;
                }
            </style>
            <script>
                function imprimirReporte() {
                    window.print();
                }
            </script>
        </head>
        <body>
            <div class="no-print" style="text-align: center; margin-bottom: 20px;">
                <button onclick="imprimirReporte()" class="btn-print">Imprimir / Guardar como PDF</button>
            </div>
            ' . $bodyContent . '
        </body>
        </html>';

        exit();
    }
}

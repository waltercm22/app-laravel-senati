<!DOCTYPE html>
<style>
/* Page / PDF settings */
@page { margin: 40px 50px; }
html, body { height: 100%; margin: 0; padding: 0; }

/* Base */
body {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: #222;
    font-size: 12px;
    line-height: 1.4;
    background: #fff;
}

/* Header / Title */
section:first-of-type {
    border-bottom: 1px solid #e6e9ee;
    padding-bottom: 12px;
    margin-bottom: 12px;
}
.report-header {
    display: flex;
    align-items: center;
    gap: 12px;
}
.report-header .logo {
    width: 60px;
    height: auto;
}
.report-title {
    color: #0b5ed7;
    font-size: 18px;
    font-weight: 700;
    margin: 0;
}
.report-subtitle {
    color: #7a0d0d;
    font-size: 12px;
    margin-top: 4px;
}

/* Main content sections */
.section {
    margin: 12px 0;
}
h2 {
    font-size: 14px;
    margin: 6px 0 10px 0;
    color: #1f2d3d;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    word-wrap: break-word;
}
thead th {
    text-align: left;
    background: #28b6ee;
    color: #0f1724;
    font-weight: 600;
    padding: 10px 12px;
    border-bottom: 2px solid #e1e7ef;
    font-size: 12px;
}
tbody td {
    padding: 10px 12px;
    border-bottom: 1px solid #eef2f6;
    vertical-align: top;
    font-size: 12px;
    color: #333;
}
tbody tr:nth-child(even) {
    background: #fbfdff;
}
td[colspan] {
    text-align: center;
    color: #6c757d;
    padding: 18px;
}

/* Small helper classes */
.small { font-size: 11px; color: #bd0505; }
.text-right { text-align: right; }
.bold { font-weight: 700; }

/* Footer (for PDF engines that support fixed positioning) */
footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 36px;
    border-top: 1px solid #e6e9ee;
    text-align: center;
    font-size: 11px;
    color: #70797f;
    padding-top: 8px;
}

/* Print-friendly adjustments */
@media print {
    .report-header .logo { width: 48px; }
    body { -webkit-print-color-adjust: exact; }
}
</style>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
    <main>
        <section> </section>

        <main style="color: blue; font-size: 20px;">

            Walter Molina - Reporte de Categorias
        </main>

        <section>
            <h2>Reporte Categorias</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre </th>
                        <th>Descripcion </th>
                        <th>Estado </th>
                        <th>Fecha Creacion </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse ( $categorias as $item )
                    <tr>
                        <td>{{ $item->nombre_categoria }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->estado }}</td>
                        <td>{{ $item->created_at }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4">No hay Datos </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <section>  </section>
        
    </main>
</body>
</html>
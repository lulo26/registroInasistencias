<?php header_admin($data); ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1><?= $data['page_title'] ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>/home">Home</a></li>
                <li class="breadcrumb-item"><?= $data['page_title'] ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row mt-3">
        <div class="col-3 text-right">
            <h5>Aprendiz</h5>
            <input type="text" id="inputAprendiz" class="form-control" placeholder="Seleccione el aprendiz"
                list="listAprendices">
            <datalist id="listAprendices"></datalist>
        </div>
        <div class="col-3 text-right">
            <h5>Mes</h5>
            <select class="form-select" id="selectMes" aria-label="Default select example" required>
                <option value="" selected>Seleccione el mes</option>
                <option value=01>Enero</option>
                <option value=02>Febrero</option>
                <option value=03>Marzo</option>
                <option value=04>Abril</option>
                <option value=05>Mayo</option>
                <option value=06>Junio</option>
                <option value=07>Julio</option>
                <option value=08>Agosto</option>
                <option value=09>Septiembre</option>
                <option value=10>Octubre</option>
                <option value=11>Noviembre</option>
                <option value=12>Diciembre</option>
            </select>
        </div>
        <div class="col-3 text-right">
            <h5>Ficha</h5>
            <select class="form-select" id="selectFicha2" aria-label="Default select example" required>
                <option value="" selected>Seleccione la ficha</option>
                <div class="selectFicha" id="selectFicha"></div>

            </select>
        </div>
        <div class="col-3 text-right">
            <button type="button" id="btnBuscar" class="btn btn-primary"><i class="bi bi-search"></i></button>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="reportePdf">
                    <h5 class="card-title">Lista de Aprendices</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tablaReportes">
                            <thead class="thead-light">
                                <tr id="cabeceraTabla">
                                </tr>
                            </thead>
                            <tbody id="tablaReportesBody">

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-info" onclick="generarPDF()">Descargar PDF</button>
    <script>
        async function generarPDF() {
            const elemento = document.getElementById("reportePdf");

            if (!elemento) {
                alert("No se encontró el contenido para generar el PDF.");
                return;
            }

            // Obtener los valores de los inputs
            const aprendiz = document.getElementById("inputAprendiz").value || "Todos los aprendices";
            const ficha = document.getElementById("selectFicha2").value || "Todas las fichas";
            const mesSelect = document.getElementById("selectMes");
            const mes = mesSelect.options[mesSelect.selectedIndex]?.text || "Mes no seleccionado";

            // Capturar contenido como imagen
            const canvas = await html2canvas(elemento, {
                scale: 2,
                useCORS: true,
            });

            const imgData = canvas.toDataURL("image/png");

            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF("p", "mm", "a4");

            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();

            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pageWidth - 20; // Margen lateral
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

            let y = 10; // posición inicial

            // Encabezado personalizado
            pdf.setFontSize(12);
            pdf.text(`Reporte de Asistencia`, pageWidth / 2, y, { align: "center" });
            y += 7;
            pdf.setFontSize(10);
            pdf.text(`Aprendiz: ${aprendiz}`, 10, y);
            y += 5;
            pdf.text(`Ficha: ${ficha}`, 10, y);
            y += 5;
            pdf.text(`Mes: ${mes}`, 10, y);
            y += 10;

            // Agregar la imagen debajo del encabezado
            if (pdfHeight + y <= pageHeight) {
                pdf.addImage(imgData, "PNG", 10, y, pdfWidth, pdfHeight);
            } else {
                let position = y;
                let heightLeft = pdfHeight;

                while (heightLeft > 0) {
                    pdf.addImage(imgData, "PNG", 10, position, pdfWidth, pdfHeight);
                    heightLeft -= (pageHeight - y);
                    position -= (pageHeight - y);

                    if (heightLeft > 0) {
                        pdf.addPage();
                        y = 10;
                        position = y;
                    }
                }
            }

            pdf.save("reporte_aprendices.pdf");
        }


    </script>

</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<?php footer_admin($data) ?>
<script src="<?= media() ?>/js/reportes/reportes.js"></script>
<div class="form-container">
    <h3>Préstamo de Herramientas</h3>
    <form id="prestamo-form">
        <input type="text" id="solicitante" placeholder="Nombre del solicitante" required>
        <input type="date" id="fecha_prestamo" required>
        <input type="date" id="fecha_entrega" required>
        <input type="text" id="herramienta" placeholder="Nombre de la herramienta" required>
        <div id="sugerencias" class="autocomplete-items"></div>
        <button type="button" id="guardar">Guardar</button>
        <button type="button" id="generar-pdf">Generar PDF</button>
    </form>
</div>

<style>
    .form-container {
        width: 50%;
        margin: auto;
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
    }
    .form-container input {
        display: block;
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border-radius: 5px;
    }
    .form-container button {
        background: green;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
    }
    .autocomplete-items {
        position: absolute;
        border: 1px solid #ddd;
        max-height: 150px;
        overflow-y: auto;
        background: white;
    }
    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
    }
    .autocomplete-items div:hover {
        background: #f1f1f1;
    }
</style>

<script>
    document.getElementById("herramienta").addEventListener("input", function() {
        let input = this.value;
        if (input.length < 2) return;
        fetch("buscar_herramientas.php?query=" + input)
            .then(response => response.json())
            .then(data => {
                let sugerencias = document.getElementById("sugerencias");
                sugerencias.innerHTML = "";
                data.forEach(herramienta => {
                    let item = document.createElement("div");
                    item.textContent = herramienta;
                    item.onclick = function() {
                        document.getElementById("herramienta").value = herramienta;
                        sugerencias.innerHTML = "";
                    };
                    sugerencias.appendChild(item);
                });
            });
    });

    document.getElementById("guardar").addEventListener("click", function() {
        let formData = new FormData(document.getElementById("prestamo-form"));
        fetch("guardar_prestamo.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => alert(data));
    });

    document.getElementById("generar-pdf").addEventListener("click", function() {
        let formData = new FormData(document.getElementById("prestamo-form"));
        fetch("generar_pdf.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.blob())
        .then(blob => {
            let url = window.URL.createObjectURL(blob);
            let a = document.createElement("a");
            a.href = url;
            a.download = "prestamo.pdf";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });
    });
</script>

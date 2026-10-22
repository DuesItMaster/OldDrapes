var inputArea = document.getElementById("autocomplete1")
inputArea.addEventListener("input", function (event) {
    validarTextoArea(this, "[0-9 a-z]")
});

function validarTextoArea(input, patron) {
    var texto = input.value
    var letras = texto.split("")
    for (var x in letras) {
        var letra = letras[x]
        if (!(new RegExp(patron, "i")).test(letra)) {
            letras[x] = ""
        }
    }
    input.value = letras.join("")
};
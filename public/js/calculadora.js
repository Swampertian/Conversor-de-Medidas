document.addEventListener('DOMContentLoaded', () => {
    var optSelect = document.getElementById("tipo");
    var numBGroup = document.getElementById("numB-group");
    var labelA = document.getElementById("labelA");
    var labelB = document.getElementById("labelB");

    function updateLabelsAndVisibility() {
        var value = optSelect.value;
        
        if (value === "retangulo") {
            labelA.textContent = "Lado A:";
            labelB.textContent = "Lado B:";
            numBGroup.style.display = "block";
        } else if (value === "triangulo") {
            labelA.textContent = "Altura:";
            labelB.textContent = "Base:";
            numBGroup.style.display = "block";
        } else if (value === "circulo") {
            labelA.textContent = "Raio:";
            numBGroup.style.display = "none";
        }
        console.log(labelA);
        console.log(labelB);

    }

    
    optSelect.addEventListener('change', updateLabelsAndVisibility);

    updateLabelsAndVisibility();
});

fetch('datos_huella_carbono.json')
  .then(response => response.json())
  .then(data => {
    const potencia_pc = data.potencia_pc;
    const tiempo_uso_diario = data.tiempo_uso_diario;
    const factor_emision = data.factor_emision;
    const huella_carbono = data.huella_carbono;

    // Actualizar los elementos en el HTML
    document.getElementById('potencia-pc').innerText = `Potencia PC: ${potencia_pc}`;
    document.getElementById('tiempo-uso').innerText = `Tiempo de uso diario: ${tiempo_uso_diario}`;
    document.getElementById('factor-emision').innerText = `Factor de emisión: ${factor_emision}`;
    document.getElementById('huella-carbono').innerText = `Huella de carbono: ${huella_carbono}`;
  })
  .catch(error => console.error('Error al cargar el archivo JSON:', error));





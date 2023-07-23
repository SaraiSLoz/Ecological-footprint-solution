const psutil = require('psutil');

function calcularHuellaCarbono() {
  const usoCPU = psutil.cpu_percent();
  const potenciaPC = usoCPU / 100 * psutil.cpu_freq().current / 1000;

  const tiempoUsoDiario = 8; // Supongamos 8 horas de uso diario

  const factorEmision = 0.5; // Factor de emisión de CO2

  const consumoDiario = potenciaPC * tiempoUsoDiario;
  const emisionesDiarias = consumoDiario * factorEmision;
  const emisionesAnuales = emisionesDiarias * 365;

  return {
    potenciaPC,
    tiempoUsoDiario,
    factorEmision,
    emisionesDiarias,
    emisionesAnuales
  };
}

module.exports = calcularHuellaCarbono;

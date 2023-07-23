import psutil

def calcular_huella_carbono(potencia_pc, tiempo_uso_diario, factor_emision):
    consumo_diario = potencia_pc * tiempo_uso_diario / 1000

    emisiones_diarias = consumo_diario * factor_emision

    emisiones_anuales = emisiones_diarias * 365

    return emisiones_anuales

uso_cpu = psutil.cpu_percent(interval=1)
potencia_pc = uso_cpu / 100 * psutil.cpu_freq().current / 1000

tiempo_uso_diario = psutil.boot_time() / 3600

factor_emision = 0.5  
huella_carbono = calcular_huella_carbono(potencia_pc, tiempo_uso_diario, factor_emision)

print("La huella de carbono anual de su PC es de aproximadamente", huella_carbono, "kg CO2.")


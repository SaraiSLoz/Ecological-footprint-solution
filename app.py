from flask import Flask, render_template
import psutil

app = Flask(__name__)

@app.route('/')
def obtener_datos_huella_carbono():
    uso_cpu = psutil.cpu_percent(interval=1)
    potencia_pc = uso_cpu / 100 * psutil.cpu_freq().current / 1000

    tiempo_uso_diario = psutil.boot_time() / 3600

    factor_emision = 0.5
    huella_carbono = calcular_huella_carbono(potencia_pc, tiempo_uso_diario, factor_emision)

    return render_template('index.html', potencia_pc=potencia_pc, tiempo_uso_diario=tiempo_uso_diario, factor_emision=factor_emision, huella_carbono=huella_carbono)

def calcular_huella_carbono(potencia_pc, tiempo_uso_diario, factor_emision):
    consumo_diario = potencia_pc * tiempo_uso_diario / 1000
    emisiones_diarias = consumo_diario * factor_emision
    emisiones_anuales = emisiones_diarias * 365
    return emisiones_anuales

if __name__ == '__main__':
    app.run()




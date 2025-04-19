import pandas as pd
from datetime import datetime, timedelta
from fpdf import FPDF
import matplotlib.pyplot as plt
from io import BytesIO
import os

# Datos proporcionados
data = [
    [1, "2025-04-17", "13:00", "REAL MADRID", "REAL MICAYA"],
    [2, "2025-04-17", "13:40", "CATRUMA JUNIORS", "CENTRAL AROMA"],
    [3, "2025-04-17", "14:20", "SANTA FE", "JUVENTUS PRIMOS"],
    [4, "2025-04-17", "15:00", "CLUB AQUISE", "UNIÓN PRIMOS"],
    [5, "2025-04-17", "15:40", "INTERNACIONAL", "ATLÉTICO SACACHO"],
    [6, "2025-04-17", "16:20", "REAL MADRID", "JUVENTUS PRIMOS"],
    [7, "2025-04-18", "08:00", "REAL MADRID", "CENTRAL AROMA"],
    [8, "2025-04-18", "08:40", "CATRUMA JUNIORS", "REAL MICAYA"],
    [9, "2025-04-18", "09:20", "SANTA FE", "UNIÓN PRIMOS"],
    [10, "2025-04-18", "10:00", "ATLÉTICO SACACHO", "REAL MADRID"],
    [11, "2025-04-18", "10:40", "INTERNACIONAL", "CLUB AQUISE"],
    [12, "2025-04-18", "11:20", "CENTRAL AROMA", "REAL MICAYA"],
    [13, "2025-04-18", "12:00", "REAL MADRID", "CATRUMA JUNIORS"],
    [14, "2025-04-18", "12:40", "SANTA FE", "CLUB CUSSI"],
    [15, "2025-04-18", "13:20", "JUVENTUS PRIMOS", "UNIÓN PRIMOS"],
    [16, "2025-04-18", "14:00", "REAL MICAYA", "CLUB AQUISE"],
    [17, "2025-04-18", "14:40", "INTERNACIONAL", "JUVENTUS PRIMOS"],
    [18, "2025-04-18", "15:20", "CATRUMA JUNIORS", "CLUB CUSSI"],
    [19, "2025-04-18", "16:00", "SANTA FE", "ATLÉTICO SACACHO"],
    [20, "2025-04-18", "16:40", "CENTRAL AROMA", "JUVENTUS PRIMOS"],
    [21, "2025-04-18", "17:20", "REAL MICAYA", "INTERNACIONAL"],
    [22, "2025-04-18", "18:00", "UNIÓN PRIMOS", "CENTRAL AROMA"],
    [23, "2025-04-19", "08:00", "REAL MADRID", "CLUB AQUISE"],
    [24, "2025-04-19", "08:40", "CATRUMA JUNIORS", "SANTA FE"],
    [25, "2025-04-19", "09:00", "JUVENTUS PRIMOS", "ATLÉTICO SACACHO"],
    [26, "2025-04-19", "09:40", "UNIÓN PRIMOS", "INTERNACIONAL"],
    [27, "2025-04-19", "10:00", "CENTRAL AROMA", "CLUB AQUISE"],
    [28, "2025-04-19", "10:40", "CLUB CUSSI", "SANTA FE"],
    [29, "2025-04-19", "11:00", "REAL MICAYA", "JUVENTUS PRIMOS"],
    [30, "2025-04-19", "11:40", "CATRUMA JUNIORS", "ATLÉTICO SACACHO"],
    [31, "2025-04-19", "12:00", "REAL MADRID", "INTERNACIONAL"],
    [32, "2025-04-19", "12:40", "CLUB AQUISE", "JUVENTUS PRIMOS"],
    [33, "2025-04-19", "13:00", "CENTRAL AROMA", "CLUB CUSSI"],
    [34, "2025-04-19", "13:40", "UNIÓN PRIMOS", "REAL MADRID"],
    [35, "2025-04-19", "14:00", "CLUB CUSSI", "REAL MICAYA"],
    [36, "2025-04-19", "14:40", "SANTA FE", "CENTRAL AROMA"],
    [37, "2025-04-19", "15:00", "CATRUMA JUNIORS", "INTERNACIONAL"],
    [38, "2025-04-19", "15:40", "SANTA FE", "REAL MADRID"],
    [39, "2025-04-19", "16:00", "REAL MICAYA", "ATLÉTICO SACACHO"],
    [40, "2025-04-19", "16:40", "JUVENTUS PRIMOS", "CATRUMA JUNIORS"],
    [41, "2025-04-19", "17:00", "SANTA FE", "INTERNACIONAL"],
    [42, "2025-04-19", "17:40", "ATLÉTICO SACACHO", "UNIÓN PRIMOS"],
    [43, "2025-04-19", "18:00", "UNIÓN PRIMOS", "REAL MICAYA"],
    [44, "2025-04-20", "08:00", "CLUB AQUISE", "ATLÉTICO SACACHO"],
    [45, "2025-04-20", "08:40", "SANTA FE", "REAL MICAYA"],
    [46, "2025-04-20", "09:00", "CLUB AQUISE", "CLUB CUSSI"],
    [47, "2025-04-20", "09:40", "CLUB AQUISE", "CENTRAL AROMA"],
    [48, "2025-04-20", "10:00", "REAL MADRID", "UNIÓN PRIMOS"],
    [49, "2025-04-20", "10:40", "CLUB AQUISE", "CATRUMA JUNIORS"],
    [50, "2025-04-20", "11:00", "ATLÉTICO SACACHO", "CENTRAL AROMA"],
    [51, "2025-04-20", "11:40", "CLUB CUSSI", "INTERNACIONAL"],
    [52, "2025-04-20", "12:00", "INTERNACIONAL", "CATRUMA JUNIORS"],
    [53, "2025-04-20", "12:40", "UNIÓN PRIMOS", "CLUB CUSSI"],
    [54, "2025-04-20", "13:00", "CLUB CUSSI", "JUVENTUS PRIMOS"],
    [55, "2025-04-20", "13:40", "ATLÉTICO SACACHO", "CLUB CUSSI"],
]

# Crear DataFrame
df = pd.DataFrame(data, columns=["Nro", "Fecha", "Hora", "Equipo Local", "Equipo Visitante"])

# Convertir fecha y hora a datetime
df['Fecha_Hora'] = pd.to_datetime(df['Fecha'] + ' ' + df['Hora'])

# Función para calcular tiempo de descanso
def calcular_descansos(equipo):
    partidos = df[(df['Equipo Local'] == equipo) | (df['Equipo Visitante'] == equipo)]
    partidos = partidos.sort_values('Fecha_Hora')

    descansos = []
    for i in range(1, len(partidos)):
        tiempo_descanso = partidos.iloc[i]['Fecha_Hora'] - partidos.iloc[i-1]['Fecha_Hora']

        # Formatear el tiempo de descanso
        total_segundos = tiempo_descanso.total_seconds()
        horas = int(total_segundos // 3600)
        minutos = int((total_segundos % 3600) // 60)

        if horas > 0 and minutos > 0:
            tiempo_formateado = f"{horas} horas y {minutos} minutos"
        elif horas > 0:
            tiempo_formateado = f"{horas} horas"
        else:
            tiempo_formateado = f"{minutos} minutos"

        descansos.append({
            'Fecha_anterior': partidos.iloc[i-1]['Fecha'],
            'Hora_anterior': partidos.iloc[i-1]['Hora'],
            'Nro_anterior': partidos.iloc[i-1]['Nro'],
            'Fecha_siguiente': partidos.iloc[i]['Fecha'],
            'Hora_siguiente': partidos.iloc[i]['Hora'],
            'Nro_siguiente': partidos.iloc[i]['Nro'],
            'Tiempo_descanso': tiempo_formateado,
            'Tiempo_descanso_original': str(tiempo_descanso)
        })
    return descansos

# Estadísticas por equipo
equipos = set(df['Equipo Local'].unique()).union(set(df['Equipo Visitante'].unique()))
estadisticas = []

for equipo in equipos:
    partidos_local = len(df[df['Equipo Local'] == equipo])
    partidos_visitante = len(df[df['Equipo Visitante'] == equipo])
    total_partidos = partidos_local + partidos_visitante
    descansos = calcular_descansos(equipo)

    estadisticas.append({
        'Equipo': equipo,
        'Partidos_Local': partidos_local,
        'Partidos_Visitante': partidos_visitante,
        'Total_Partidos': total_partidos,
        'Descansos': descansos
    })

# Crear PDF
class PDF(FPDF):
    def __init__(self):
        super().__init__()
        self.equipos_por_pagina = 0

    def header(self):
        self.set_font('Arial', 'B', 12)
        self.cell(0, 10, 'Reporte de Partidos de Fútbol', 0, 1, 'C')
        self.ln(5)

    def footer(self):
        self.set_y(-15)
        self.set_font('Arial', 'I', 8)
        self.cell(0, 10, f'Página {self.page_no()}', 0, 0, 'C')

    def add_equipo(self, estad):
        self.set_font('Arial', 'B', 12)
        self.cell(0, 10, f"Equipo: {estad['Equipo']}", 0, 1)
        self.set_font('Arial', '', 10)
        self.cell(0, 6, f"Partidos como Local: {estad['Partidos_Local']}", 0, 1)
        self.cell(0, 6, f"Partidos como Visitante: {estad['Partidos_Visitante']}", 0, 1)
        self.cell(0, 6, f"Total de Partidos: {estad['Total_Partidos']}", 0, 1)

        if estad['Descansos']:
            self.cell(0, 6, "Tiempos de descanso entre partidos:", 0, 1)
            for desc in estad['Descansos']:
                self.cell(50, 6, f"Partido {desc['Nro_anterior']}: {desc['Fecha_anterior']} {desc['Hora_anterior']}", 0, 0)
                self.cell(10, 6, "->", 0, 0, 'C')
                self.cell(50, 6, f"Partido {desc['Nro_siguiente']}: {desc['Fecha_siguiente']} {desc['Hora_siguiente']}", 0, 0)
                self.cell(0, 6, f"Descanso: {desc['Tiempo_descanso']}", 0, 1)
        else:
            self.cell(0, 6, "Este equipo solo juega un partido", 0, 1)

        self.ln(8)
        self.equipos_por_pagina += 1

# Crear gráfico de partidos por equipo
plt.figure(figsize=(10, 6))
df_equipos = pd.DataFrame(estadisticas)
df_equipos.sort_values('Total_Partidos', ascending=False).plot(
    x='Equipo', y=['Partidos_Local', 'Partidos_Visitante'],
    kind='bar', stacked=True
)
plt.title('Partidos por Equipo (Local vs Visitante)')
plt.ylabel('Cantidad de Partidos')
plt.tight_layout()

# Guardar gráfico en memoria
img_data = BytesIO()
plt.savefig(img_data, format='png', bbox_inches='tight', dpi=100)
plt.close()

# Guardar temporalmente en archivo
temp_img = "temp_chart.png"
with open(temp_img, 'wb') as f:
    f.write(img_data.getbuffer())

# Generar PDF
pdf = PDF()
pdf.add_page()

# Agregar gráfico
pdf.set_font('Arial', 'B', 14)
pdf.cell(0, 10, 'Distribución de Partidos por Equipo', 0, 1)
pdf.ln(5)
pdf.image(temp_img, x=10, y=40, w=190)

# Eliminar archivo temporal
os.remove(temp_img)

# Agregar estadísticas por equipo (2 por página)
pdf.add_page()
pdf.set_font('Arial', 'B', 14)
# pdf.cell(0, 10, 'Estadísticas por Equipo', 0, 1)
pdf.ln(5)

for i, estad in enumerate(estadisticas):
    pdf.add_equipo(estad)

    # Si hemos mostrado 2 equipos, agregar nueva página
    if pdf.equipos_por_pagina >= 2 and i < len(estadisticas) - 1:
        pdf.add_page()
        pdf.equipos_por_pagina = 0
        pdf.set_font('Arial', 'B', 14)
        # pdf.cell(0, 10, 'Estadísticas por Equipo (cont.)', 0, 1)
        pdf.ln(5)

# Guardar PDF
pdf_output = "reporte_partidos.pdf"
pdf.output(pdf_output)

print(f"Reporte generado exitosamente: {pdf_output}")

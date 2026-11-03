import pandas as pd
import numpy as np
from faker import Faker
from sqlalchemy import create_engine
import random
from datetime import datetime, timedelta

# 1. Configuración inicial
fake = Faker('es_MX')
num_alumnos = 1000
num_empleados = 20


def generar_rfc():
    letras = ''.join(random.choices('ABCDEFGHIJKLMNOPQRSTUVWXYZ', k=4))
    numeros = ''.join(random.choices('0123456789', k=6))
    homoclave = ''.join(random.choices(
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', k=3))
    return f"{letras}{numeros}{homoclave}"


SUPABASE_URI = "postgresql+psycopg2://postgres:postgres@localhost:5432/escuela"
motor_db = create_engine(SUPABASE_URI)

print("Iniciando inyección masiva respetando seeders de Laravel...")

# 2. Catálogos extraídos del ContratacionSeeder
# Se omite la inserción a la BD porque ya existen. Solo se usan para la lógica.
tipos_contratacion = ['BÁSICO', 'INTERMEDIO', 'INTENSIVO', 'PREMIUM']
precios = {'BÁSICO': 2000, 'INTERMEDIO': 3500,
           'INTENSIVO': 4000, 'PREMIUM': 5000}
formas_pago = ['EFECTIVO', 'DEBITO', 'CRÉDITO', 'TRANSFERENCIA']

# 3. Generación de Empleados (Instructores adicionales a los del seeder)
empleados_data = []
for _ in range(num_empleados):
    empleados_data.append({
        'rfc': generar_rfc(),
        'nombre': fake.first_name()[:30].upper(),
        'apellido_p': fake.last_name()[:30].upper(),
        'apellido_m': fake.last_name()[:30].upper(),
        'puesto': 'INSTRUCTOR',
        'turno': random.choice(['Matutino', 'Vespertino']),
        'descansos': 'DOMINGO',
        'sexo': random.choice(['Masculino', 'Femenino']),
        'fecha_nac': fake.date_of_birth(minimum_age=25, maximum_age=55),
        'tel_personal': fake.random_number(digits=10, fix_len=True),
        'calle': fake.street_name()[:30].upper(),
        'numero': random.randint(1, 999),
        'colonia': fake.city_prefix()[:30].upper(),
        'alcaldia': fake.city()[:30].upper(),
        'created_at': datetime.now(),
        'updated_at': datetime.now()
    })
empleados = pd.DataFrame(empleados_data)
empleados.to_sql('empleados', motor_db, if_exists='append', index=False)
print("Nuevos empleados inyectados.")

# 4. Generación de Alumnos masivos
alcaldias = ['Benito Juárez', 'Miguel Hidalgo',
             'Coyoacán', 'Iztapalapa', 'Tlalpan', 'GAM']
prob_alcaldias = [0.25, 0.20, 0.15, 0.15, 0.15, 0.10]

alumnos_data = []
paquetes_asignados = []

for _ in range(num_alumnos):
    alcaldia = np.random.choice(alcaldias, p=prob_alcaldias)
    rfc_alumno = generar_rfc()

    alumnos_data.append({
        'rfc': rfc_alumno,
        'nombre': fake.first_name()[:255].upper(),
        'apellido_p': fake.last_name()[:255].upper(),
        'apellido_m': fake.last_name()[:255].upper(),
        'fecha_nac': fake.date_of_birth(minimum_age=16, maximum_age=50),
        'calle': fake.street_name()[:255].upper(),
        'numero': str(random.randint(1, 9999)),
        'colonia': fake.city_prefix()[:255].upper(),
        'alcaldia': alcaldia.upper(),
        'permiso': 'SI' if random.choice([True, False]) else 'EN TRÁMITE',
        'observaciones': 'Generado por Python',
        'correo': fake.email()[:255],
        'created_at': datetime.now(),
        'updated_at': datetime.now()
    })

    # Asignación de paquete para clustering
    if alcaldia in ['Benito Juárez', 'Miguel Hidalgo']:
        tipo = np.random.choice(tipos_contratacion, p=[0.1, 0.2, 0.3, 0.4])
    else:
        tipo = np.random.choice(tipos_contratacion, p=[0.4, 0.3, 0.2, 0.1])

    paquetes_asignados.append({'rfc': rfc_alumno, 'tipo': tipo})

alumnos = pd.DataFrame(alumnos_data)
alumnos.to_sql('alumnos', motor_db, if_exists='append',
               index=False, chunksize=1000)
print("Nuevos alumnos inyectados.")

# 5. Generación de Pagos
pagos_data = []
for p in paquetes_asignados:
    fecha_pago = fake.date_between(start_date='-1y', end_date='today')

    pagos_data.append({
        'rfc_cliente': p['rfc'],
        'fecha_pago': fecha_pago,
        'tipo_contratacion': p['tipo'],
        'total_pago': precios[p['tipo']],
        'forma_pago': random.choice(formas_pago),
        'reembolso': True if random.random() > 0.95 else False,
        'created_at': datetime.now(),
        'updated_at': datetime.now()
    })

pagos = pd.DataFrame(pagos_data)
pagos.to_sql('pagos', motor_db, if_exists='append',
             index=False, chunksize=1000)
print("Pagos inyectados.")

# 6. Generación de Agenda (Con prevención de colisiones)
print("Generando Agenda...")
agenda_data = []
rfcs_instructores = empleados['rfc'].tolist()

config_clases = {
    'BÁSICO': {'num': 7, 'km': 10},
    'INTERMEDIO': {'num': 12, 'km': 12},
    'INTENSIVO': {'num': 15, 'km': 15},
    'PREMIUM': {'num': 20, 'km': 18}
}

# Memoria temporal para evitar el UniqueViolation
horarios_ocupados = set()

for _, pago in pagos.iterrows():
    tipo = pago['tipo_contratacion']
    num_clases = config_clases[tipo]['num']
    km_totales = 0

    for i in range(num_clases - 1):
        km = max(1, round(config_clases[tipo]['km'] + np.random.normal(0, 2)))
        km_totales += km
        fecha_clase = (pd.to_datetime(
            pago['fecha_pago']) + timedelta(days=i*2)).date()

        # Bucle: Buscar hasta encontrar un horario/instructor disponible
        while True:
            rfc_emp = random.choice(rfcs_instructores)
            hora_str = f"{random.randint(8, 18):02d}:00:00"
            slot = (fecha_clase, hora_str, rfc_emp)

            if slot not in horarios_ocupados:
                horarios_ocupados.add(slot)
                break

        agenda_data.append({
            'rfc_emp': rfc_emp,
            'fecha': fecha_clase,
            'hora': hora_str,
            'rfc_cliente': pago['rfc_cliente'],
            'fecha_pago': pago['fecha_pago'],
            'actividad': 'LECCIÓN',
            'km_recorridos': km,
            'notas': 'Práctica general',
            'exam_teo': None,
            'exam_prac': None,
            'notas_resultado': None,
            'created_at': datetime.now(),
            'updated_at': datetime.now()
        })

    # Último registro: EXAMEN
    calificacion_prac = min(
        100, max(0, round(40 + (km_totales * 0.2) + np.random.normal(0, 5))))
    fecha_examen = (pd.to_datetime(
        pago['fecha_pago']) + timedelta(days=num_clases*2)).date()

    # Bucle: Buscar horario disponible para el examen
    while True:
        rfc_emp = random.choice(rfcs_instructores)
        hora_str = f"{random.randint(8, 18):02d}:00:00"
        slot = (fecha_examen, hora_str, rfc_emp)

        if slot not in horarios_ocupados:
            horarios_ocupados.add(slot)
            break

    agenda_data.append({
        'rfc_emp': rfc_emp,
        'fecha': fecha_examen,
        'hora': hora_str,
        'rfc_cliente': pago['rfc_cliente'],
        'fecha_pago': pago['fecha_pago'],
        'actividad': 'EXAMEN',
        'km_recorridos': 5,
        'notas': 'Evaluación final',
        'exam_teo': random.randint(60, 100),
        'exam_prac': calificacion_prac,
        'notas_resultado': 'Aprobado' if calificacion_prac >= 70 else 'Reprobado',
        'created_at': datetime.now(),
        'updated_at': datetime.now()
    })

agenda = pd.DataFrame(agenda_data)
agenda.to_sql('agenda', motor_db, if_exists='append',
              index=False, chunksize=1000)
print("Agenda inyectada exitosamente sin colisiones.")

# 7. Excel de Costos Operativos
fechas_mes = pd.date_range(start='2025-01-01', end='2026-12-31', freq='MS')
costos_externos = pd.DataFrame({
    'fecha_mes': fechas_mes,
    'precio_gasolina_litro': np.random.uniform(22.0, 25.5, len(fechas_mes)).round(2),
    'costo_mantenimiento_base': np.random.uniform(1500, 3000, len(fechas_mes)).round(2)
})
costos_externos.to_excel('costos_combustible.xlsx', index=False)
print("Generación completada.")

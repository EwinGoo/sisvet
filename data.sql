CREATE TABLE historial_clinico (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_mascota INT,
    id_usuario int,
    anamenesis VARCHAR(1000),
    enfermedades_anteriores VARCHAR(500),
    tratamientos_recientes VARCHAR(500),
    ultima_desparasitacion DATE,
    vacunas VARCHAR(500),
    FOREIGN KEY (id_mascota) REFERENCES mascotas(id_mascota),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE examen_general (
    id_examen INT AUTO_INCREMENT PRIMARY KEY,
    id_historial INT,
    fecha DATE,
    temperatura FLOAT(3,1),
    frecuencia_cardiaca VARCHAR(25),
    frecuencia_respiratoria VARCHAR(25),
    mucosa VARCHAR(50),
    rc VARCHAR(50),
mm VARCHAR(50),
    inspeccion VARCHAR(255),
    palpacion VARCHAR(255),
    FOREIGN KEY (id_historial) REFERENCES historial_clinico(id_historial)
);

CREATE TABLE sintomas (
    id_sintoma INT AUTO_INCREMENT PRIMARY KEY,
    id_historial INT,
    fecha DATE,
    descripcion varchar(500),
    FOREIGN KEY (id_historial) REFERENCES historial_clinico(id_historial)
);

CREATE TABLE metodos_complementarios (
    id_metodo INT AUTO_INCREMENT PRIMARY KEY,
    id_historial INT,
    fecha_orden DATE,
    examen VARCHAR(255),
    resultados varchar(500),
    FOREIGN KEY (id_historial) REFERENCES historial_clinico(id_historial)
);

CREATE TABLE diagnostico (
    id_diagnostico INT AUTO_INCREMENT PRIMARY KEY,
    id_historial INT,
    fecha date,
    diagnostico_presuntivo VARCHAR(100),
    diagnostico_definitivo VARCHAR(100),
    FOREIGN KEY (id_historial) REFERENCES historial_clinico(id_historial)
);

CREATE TABLE tratamiento (
    id_tratamiento INT AUTO_INCREMENT PRIMARY KEY,
    id_historial INT,
    fecha DATE,
    descripcion varchar(500),
    FOREIGN KEY (id_historial) REFERENCES historial_clinico(id_historial)
);

CREATE TABLE evolucion (
    id_evolucion INT AUTO_INCREMENT PRIMARY KEY,
    id_historial INT,
    fecha_hora DATETIME,
    evolucion varchar(500),
    pronostico varchar(500),
    FOREIGN KEY (id_historial) REFERENCES historial_clinico(id_historial)
);
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

CREATE TABLE tipos_examenes (
    id_tipo_examen INT PRIMARY KEY AUTO_INCREMENT,
    nombre_examen VARCHAR(50) NOT NULL,
    descripcion varchar(100)
);

CREATE TABLE metodos_complementarios (
    id_metodo INT AUTO_INCREMENT PRIMARY KEY,
    id_historial INT,
    fecha_hora DATE,
    examen VARCHAR(255),
    resultados varchar(500),
    id_tipo_examen INT,
    id_multimedia INT,
    FOREIGN KEY (id_tipo_examen) REFERENCES tipos_examenes(id_tipo_examen),
    FOREIGN KEY (id_multimedia) REFERENCES multimedia(id_multimedia),
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

CREATE TABLE tipos_vacunas (
    id_tipo_vacuna INT AUTO_INCREMENT PRIMARY KEY,
    nombre_vacuna VARCHAR(55),
    id_animal INT,
    FOREIGN KEY (id_animal) REFERENCES animales(id_animal)
);

CREATE TABLE vacunas (
    id_vacuna INT AUTO_INCREMENT PRIMARY KEY,
    id_historial INT,
    fecha DATE,
    id_tipo_vacuna INT
    FOREIGN KEY (id_historial) REFERENCES historial_clinico(id_historial),
    FOREIGN KEY (id_tipo_vacuna) REFERENCES tipos_vacunas(id_tipo_vacuna)
);




-- inserts

INSERT INTO sisvet.tipos_vacunas (id_tipo_vacuna, nombre_vacuna, id_animal)
VALUES
-- Vacunas para perros
(1, 'parvoCorona', 2),
(2, 'Hexavalente', 2),
(3, 'Octavalente', 2),
(4, 'Antirrabica', 2),

-- Vacunas para gatos
(5, 'Triplefelina', 1),
(6, 'Antirrabica', 1);

INSERT INTO tipos_examenes (nombre_examen, descripcion) VALUES
('Hemograma', 'Análisis de células sanguíneas.'),
('Quimica Sanguinea', 'Análisis de componentes químicos en la sangre.'),
('Perfil hepatico', 'Evaluación de la función hepática.'),
('Perfil renal', 'Evaluación de la función renal.'),
('Perfil pancreatico', 'Evaluación de la función pancreática.'),
('Ecografia', 'Imágenes por ultrasonido.'),
('Radiografia', 'Imágenes por rayos X.');

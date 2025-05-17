-- Crear tabla para clientes
CREATE TABLE clientes (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT(10) UNSIGNED,
    ci VARCHAR(55),
    nombre VARCHAR(55) NOT NULL,
    paterno VARCHAR(55) NOT NULL,
    materno VARCHAR(55),
    direccion VARCHAR(255),
    telefono VARCHAR(15), -- Cambiado a VARCHAR para números de teléfono
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Asigna la fecha y hora actual por defecto
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Actualiza cuando haya cambios
    deleted_at TIMESTAMP DEFAULT NULL, -- Puedes dejarlo nulo para manejar el borrado lógico
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE categorias (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nombre_categoria VARCHAR(55) NOT NULL,
    decripcion varchar(100),
    created_at TIMESTAMP null,
    updated_at TIMESTAMP null,
    deleted_at TIMESTAMP null  
);
CREATE TABLE proveedores (
    id_proveedor INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    id_usuario INT(10) UNSIGNED,
    contacto VARCHAR(100), -- Nombre de contacto del proveedor
    celular int(8),
    correo VARCHAR(100),
    direccion VARCHAR(255),
    created_at TIMESTAMP null,
    updated_at TIMESTAMP null,
    deleted_at TIMESTAMP null,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE productos (
    id_producto INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    descripcion varchar(255),
    id_categoria INT, -- Clave foránea que referencia la categoría
    id_proveedor INT, -- Clave foránea que referencia el proveedor
    id_multimedia INT, -- Clave foránea que referencia el proveedor
    precio DECIMAL(10, 2),
    fecha_vencimiento DATE,
    codigo_barras VARCHAR(50),
    created_at TIMESTAMP null,
    updated_at TIMESTAMP null,
    deleted_at TIMESTAMP null,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria), -- Relación con la tabla de categorías
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor), -- Relación con la tabla de proveedores
    FOREIGN KEY (id_multimedia) REFERENCES multimedia(id_multimedia) -- Relación con la tabla de proveedores
);


-- Crear tabla para citas
create table citas (
  id_cita INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario int(10) UNSIGNED,
  id_propietario int,
  fecha timestamp not null,
  motivo varchar(500),
  id_mascota int,
  created_at TIMESTAMP null,
  updated_at TIMESTAMP null,
  deleted_at TIMESTAMP null,
  FOREIGN KEY (id_mascota) REFERENCES mascotas(id_mascota),
  FOREIGN KEY (id_propietario) REFERENCES propietarios(id_propietario),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Crear tabla para ventas
create table ventas (
  id_venta INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT(10) UNSIGNED,
  id_proveedor INT, -- Clave foránea que referencia al proveedor
  fecha_venta DATE,
  total_venta DECIMAL(10, 2), -- El total de la compra
  created_at TIMESTAMP null,
  updated_at TIMESTAMP null,
  deleted_at TIMESTAMP null,
  FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor), -- Relación con la tabla de proveedores
FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE detalles_venta (
    id_detalle INT PRIMARY KEY AUTO_INCREMENT,
    id_venta INT, -- Clave foránea que referencia la compra
    id_producto INT, -- Clave foránea que referencia el producto
    cantidad INT, -- Cantidad de producto comprado
    precio_unitario DECIMAL(10, 2), -- Precio unitario del producto en esta compra
    subtotal DECIMAL(10, 2), -- subtotal (cantidad * precio_unitario)
    FOREIGN KEY (id_compra) REFERENCES compras(id_compra), -- Relación con la tabla de compras
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) -- Relación con la tabla de productos
);
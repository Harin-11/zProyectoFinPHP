CREATE DATABASE IF NOT EXISTS gestion_proyectos;
USE gestion_proyectos;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    empresa VARCHAR(100),
    email VARCHAR(100),
    telefono VARCHAR(20),
    direccion TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de programadores
CREATE TABLE programadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    especialidad VARCHAR(100),
    estado ENUM('disponible', 'ocupado') DEFAULT 'disponible',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de proyectos
CREATE TABLE proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    cliente_id INT NOT NULL,
    programador_id INT NULL,
    fecha_inicio DATE,
    fecha_fin DATE,
    estado ENUM('pendiente', 'en_proceso', 'completado', 'cancelado') DEFAULT 'pendiente',
    presupuesto DECIMAL(10,2),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (programador_id) REFERENCES programadores(id) ON DELETE SET NULL
);

-- NOTA: Los usuarios se crean mediante el formulario de registro desde el login, ya que las contraseñas deben estar hasheadas con password_hash()
-- para que password_verify() pueda verificarlas correctamente. Insertar contraseñas en texto plano en el SQL no me ha funcionado al menos a mi, supongo se puede de alguna manera pero no se mucho de esto. 


INSERT INTO clientes (nombre, empresa, email, telefono, direccion) VALUES
('Jorge Valdez', 'Gloria S.A.', 'jvaldez@gloria.com.pe', '987654321', 'Av. República de Panamá 4156, Surco, Lima'),
('Lucía Herrera', 'InkaFarma', 'lucia.herrera@inkafarma.pe', '945112233', 'Av. Abancay 233, Cercado de Lima'),
('Mario Cárdenas', 'Plaza Vea', 'mario.cardenas@plazavea.com.pe', '956874123', 'Av. La Marina 1350, San Miguel'),
('Andrea Ponce', 'Interbank', 'andreap@interbank.pe', '912887432', 'Av. Javier Prado 2990, San Isidro'),
('Renzo Gutiérrez', 'Backus', 'renzo.g@backus.com.pe', '943872311', 'Av. Nicolás Ayllón 3986, Ate'),
('Sebastián Leiva', 'Tottus', 'sleiva@tottus.com.pe', '941225778', 'Av. Angamos 1803, Surquillo'),
('Fiorella Salvatierra', 'Banco de Crédito BCP', 'fiorella@bcp.com.pe', '955662331', 'Av. Arequipa 4050, Miraflores'),
('Óscar Rengifo', 'Ransa', 'orengifo@ransa.net', '933781221', 'Av. Argentina 3343, Callao'),
('Isabella Fuentes', 'MiFarma', 'ifuentes@mifarma.com.pe', '912667891', 'Av. Petit Thouars 1440, Lince'),
('Javier Villacorta', 'Real Plaza', 'jvillacorta@realplaza.pe', '944112892', 'Av. Caminos del Inca 1230, Surco');

INSERT INTO programadores (nombre, email, telefono, especialidad, estado) VALUES
('Diego Fernández', 'diego.fernandez@gmail.com', '987111222', 'Backend PHP / Laravel', 'disponible'),
('Sofía Martel', 'sofia.martel@hotmail.com', '964332221', 'Frontend Vue.js / TailwindCSS', 'ocupado'),
('Rodrigo Pezúa', 'rodrigo.pezua@gmail.com', '945998877', 'Full Stack JavaScript (Node + React)', 'disponible'),
('Andrea Salazar', 'andrea.salazar@outlook.com', '956441122', 'Mobile Flutter / Dart', 'disponible'),
('Kevin Torres', 'kevin.torres@yahoo.com', '912334455', 'UI/UX Designer', 'ocupado'),
('Marcos Palomino', 'marcos.palomino@proton.me', '987991233', 'Backend Node.js / Express', 'disponible'),
('Diana Lozano', 'diana.lozano@gmail.com', '945667812', 'Frontend React / Next.js', 'ocupado'),
('Carlos Ugarte', 'carlos.ugarte@outlook.com', '954882311', 'DevOps / Docker / CI-CD', 'disponible'),
('Giselle Torres', 'gisellet@icloud.com', '913447891', 'QA Tester Manual & Automatizado', 'ocupado'),
('Fernando Alarcón', 'falarcon@gmail.com', '998321123', 'Backend Python / Django', 'disponible');

INSERT INTO proyectos (nombre, descripcion, cliente_id, programador_id, fecha_inicio, fecha_fin, estado, presupuesto) VALUES
('Sistema de Control de Producción', 'Sistema interno para planta de leche Gloria.', 1, 1, '2024-01-10', '2024-04-15', 'completado', 18000.00),
('Web Corporativa InkaFarma', 'Renovación completa del sitio web.', 2, 2, '2024-03-01', NULL, 'en_proceso', 12000.00),
('App de Ofertas Plaza Vea', 'Aplicación móvil para promociones y cupones.', 3, 4, '2024-02-15', NULL, 'en_proceso', 23000.00),
('Sistema de Créditos Interbank', 'Módulo interno de evaluación crediticia.', 4, 6, '2024-04-05', NULL, 'pendiente', 35000.00),
('Dashboard Operacional Backus', 'Dashboard de producción y logística.', 5, 8, '2024-03-20', NULL, 'pendiente', 28000.00),
('Sistema de Inventarios Tottus', 'Gestión de stock en tiempo real.', 6, 3, '2024-01-18', '2024-05-30', 'completado', 20000.00),
('Portal de Clientes BCP', 'Portal web para banca personas.', 7, 7, '2024-02-22', NULL, 'en_proceso', 50000.00),
('Módulo de Logística Ransa', 'Optimización de rutas y almacenes.', 8, 9, '2024-03-10', NULL, 'pendiente', 26000.00),
('App de Salud y Recetas', 'Aplicación para MiFarma y salud personal.', 9, 5, '2024-06-01', NULL, 'pendiente', 14000.00),
('Sistema de Gestión Real Plaza', 'Control de tiendas y reportes.', 10, 10, '2024-05-12', NULL, 'pendiente', 31000.00);

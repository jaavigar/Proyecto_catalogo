CREATE TABLE usuario (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nombre    VARCHAR(100) NOT NULL,
    apellido1 VARCHAR(100) NOT NULL,
    apellido2 VARCHAR(100),
    email     VARCHAR(150) NOT NULL UNIQUE,
    login     VARCHAR(50)  NOT NULL UNIQUE,
    password  VARCHAR(255) NOT NULL
);

CREATE TABLE fabricante (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL
);

CREATE TABLE producto (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nombre        VARCHAR(150)  NOT NULL,
    descripcion   TEXT,
    precio        DECIMAL(10,2) NOT NULL,
    imagen        VARCHAR(255),
    id_fabricante INT,
    FOREIGN KEY (id_fabricante) REFERENCES fabricante(id) ON DELETE SET NULL
);


INSERT INTO fabricante (nombre) VALUES
('Yamaha'),
('Honda'),
('Suzuki'),
('Ducati'),
('Kawasaki');

INSERT INTO producto (nombre, descripcion, precio, imagen, id_fabricante) VALUES
('Yamaha MT-07', 'Naked de Yamaha con motor bicilindrico CP2 de 689cc', 7895.00, NULL, 1),
('Honda CBR600RR', 'Deportiva de Honda con motor de 4 cilindros en linea', 11999.00, NULL, 2),
('Suzuki GSX-R750', 'Deportiva de Suzuki con gran equilibrio entre potencia y manejo', 12500.00, NULL, 3),
('Ducati Panigale V4', 'Superdeportiva italiana con motor V4 de altas prestaciones', 24990.00, NULL, 4),
('Kawasaki Ninja ZX-10R', 'Superdeportiva de Kawasaki usada en competicion WorldSBK', 18500.00, NULL, 5);

INSERT INTO usuario (nombre, apellido1, apellido2, email, login, password) VALUES
('Admin', 'Apellido1', 'Apellido2', 'admin@admin.com', 'admin', '1234');
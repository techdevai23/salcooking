
CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre_completo VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  direccion VARCHAR(255),
  ciudad VARCHAR(100),
  pais VARCHAR(100),
  sexo ENUM('Masculino', 'Femenino', 'Otro', 'Prefiero no decirlo'),
  peso_kg DECIMAL(5,2),
  edad INT,
  contrasena_hash VARCHAR(255) NOT NULL,
  es_premium BOOLEAN DEFAULT 0,
  codigo_premium_usado VARCHAR(50),
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  ultima_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE perfiles (
  id_perfil INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  nick VARCHAR(50) NOT NULL,
  enfermedades TEXT,
  alergias TEXT,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE codigos_premium (
  id_codigo INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(50) UNIQUE NOT NULL,
  activo BOOLEAN DEFAULT 1,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  usado_por_usuario_id INT,
  fecha_uso DATETIME NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- Tabla para marcar recetas como favoritas
CREATE TABLE usuario_favoritos (
  id_usuario INT NOT NULL,
  id_receta INT NOT NULL,
  fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_usuario, id_receta),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
  FOREIGN KEY (id_receta) REFERENCES recetas(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabla de dietas generadas
CREATE TABLE dietas (
  id_dieta INT AUTO_INCREMENT PRIMARY KEY,
  id_perfil INT NOT NULL,
  nombre_dieta VARCHAR(100),
  tipo ENUM('Diaria', 'Semanal'),
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_perfil) REFERENCES perfiles(id_perfil)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabla intermedia entre dieta y receta
CREATE TABLE dieta_receta (
  id_dieta INT NOT NULL,
  id_receta INT NOT NULL,
  comida ENUM('Desayuno', 'Comida-entrante', 'Comida-principal', 'Comida-postre'),
  dia_semana ENUM('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'),
  PRIMARY KEY (id_dieta, id_receta, dia_semana, comida),
  FOREIGN KEY (id_dieta) REFERENCES dietas(id_dieta),
  FOREIGN KEY (id_receta) REFERENCES recetas(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabla de lista de la compra generada automáticamente
CREATE TABLE lista_compra (
  id_lista INT AUTO_INCREMENT PRIMARY KEY,
  id_dieta INT NOT NULL,
  nombre_ingrediente VARCHAR(100) NOT NULL,
  cantidad_total DECIMAL(10,2),
  unidad VARCHAR(20),
  FOREIGN KEY (id_dieta) REFERENCES dietas(id_dieta)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;




-- INSERT DE DATOS FICTICIOS

INSERT INTO usuarios (nombre_completo, email, direccion, ciudad, pais, sexo, peso_kg, edad, contrasena_hash, es_premium, codigo_premium_usado)
VALUES
('Joaquín Salvador Sánchez', 'joaquin.sanchez@email.com', 'Calle Falsa 123', 'Sevilla', 'España', 'Masculino', 78.5, 45, 'hash123456', 1, '2987354');

INSERT INTO perfiles (id_usuario, nick, enfermedades, alergias)
VALUES
(1, 'JS', 'Diabetes,Colesterol', 'Frutos secos,Gluten'),
(1, 'esposa', 'Hipertensión', 'Pescado');

INSERT INTO codigos_premium (codigo, activo, usado_por_usuario_id, fecha_uso)
VALUES
('2987354', 0, 1, NOW());

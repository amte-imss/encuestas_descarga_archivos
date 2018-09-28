insert into encuestas.sse_modulo (descripcion_modulo, modulo_padre_cve, nom_controlador_funcion_mod, is_menu) VALUES 
('Archivo de volumetría', 3, '/operaciones/volumetria',1),
('Concentrado de alumnos', 3, '/operaciones/concentrado_alumnos',1);

insert into encuestas.sse_modulo_rol (modulo_cve, role_id, acceso) values
((SELECT m.modulo_cve from encuestas.sse_modulo m where nom_controlador_funcion_mod = '/operaciones/volumetria'), 1, 1),
((SELECT m.modulo_cve from encuestas.sse_modulo m where nom_controlador_funcion_mod = '/operaciones/concentrado_alumnos'), 1, 1);


insert into encuestas.sse_modulo (descripcion_modulo, modulo_padre_cve, nom_controlador_funcion_mod, is_menu) VALUES 
('Opciones de descarga', 3, '/operaciones/get_opciones_descarga',0);
insert into encuestas.sse_modulo_rol (modulo_cve, role_id, acceso) values
((SELECT m.modulo_cve from encuestas.sse_modulo m where nom_controlador_funcion_mod = '/operaciones/get_opciones_descarga'), 1, 1);
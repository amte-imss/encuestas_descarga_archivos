insert into encuestas.sse_modulo (descripcion_modulo, modulo_padre_cve, nom_controlador_funcion_mod, is_menu) VALUES 
('Descarga volumetía (implementaciones)', 3, '/operaciones/volumetria',1),
('Descarga concenrado de certificados de alumnos', 3, '/operaciones/concentrado_alumnos',1);

insert into encuestas.sse_modulo_rol (modulo_cve, role_id, acceso) values
((SELECT m.modulo_cve from encuestas.sse_modulo m where nom_controlador_funcion_mod = '/operaciones/volumetria'), 1, 1),
((SELECT m.modulo_cve from encuestas.sse_modulo m where nom_controlador_funcion_mod = '/operaciones/concentrado_alumnos'), 1, 1);

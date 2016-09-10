# TODO List


- 
-verificar cadena de eliminaciones al borrar user, instancia, proyecto, org_type, category, ...
acceso a admin tools
list sysadmins
user llist: make admin, revoke admin, view
- verificar que pasa con tablas vacias
- mejorar sistema de back to previous... sin tener que pasar por edits/view/edits/view/...
	- ejemplo: botón para volver a lista
- mejorar redirecciones.. ejemplo; al eliminar un proyecto, volver a la lista, mapa o gráfico, no al preview.
- checkear correcto funcionamiento de adds/edits
- más texto en cada vista
- editar fechas correctamente: project
- utilizar campos de configuración de la instancia
	- ej: max-categories.
sanitizar queries!
probar queries con parametros raros
link para view all --> implicará  agregar filtro por continente!
link para download
sql transsacciones encakephp


página no tiene resize de footer ni topbar
category add: manejar error al intentar crear categor[ia con el mismos nombres]

<!-- TODO: mostrar filtro actual -->

- aviso de max zoom

## ERRORES

## Relacionados con la Vista de Administración

### Instance Add

- next id no es atómico
- Autocompletar nombre en español, al rellenar versión en Inglés
- Autocompletar descripción en español, al rellenar versión en Inglés
- Upload del Logo + Preview
- Todos los campos checkeados por default
- mostrar ejemplo de url final al modificar el namespace
- agregar campos dummy a la base de datos ([unused field] ...)


## visualizaciones
- evitar esparcimiento de campos dummy
- map width height
- map size responsive
	- see: http://stackoverflow.com/questions/16265123/resize-svg-when-window-is-resized-in-d3-js

## Proyectos:

- view: acceder al user, pero sólo nombre y contacto
- crear, editar... reforzar constraints de labase de datos.

## VARIOS

- titulo de la ventana
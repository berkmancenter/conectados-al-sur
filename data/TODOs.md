# TODO List

COSAS IMPORTANTES:
- portada embebible
- tablas con hd celeste
- describr filtro en projects index
- error views!


REUNION: Ah! lo otro que me sugirió, es que hagamos bien claro en el correo que se va a publicar de los proyectos, que diga algo así cómo ¿Cuál es el correo de contacto que puede publicarse del proyecto?




DETALLES:
=====================================================

issues (dejados de lado):
-----------------------------------------------------
- problema con los forms y validación.. Form->create() no es llamado con la entidad, pues de lo contrario los campos con errores se ocultan y se comportan de manera extraña
- Primer mensaje flash se ve muy mal.. incluso desaparece en dispositivos pequeños


varios
-----------------------------------------------------

- view projects.. mostrar info de que no hay proyectos registrados para cierta instancia y user... en vez de mostrar tabla en blanco

logo:
-formatos aceptados y chequeo de tamaño y tipo
-posibilidad de borrar el logo?

# routes: 
# - probablemente graph, map, index y download puedan ser abstraídos al 
# mismo controlador!, pero con distintas vistas
#
# - limitar acceso con urls originales, que no ocupan el mapeo que propongo
# - bloquear acceso a vistas de Entidades Bloqueadas:
#    - Continents
#    - Subcontinents
#    - Countries
#    - Cities
#    - CategoriesProjects
#    - Genres
#    - ProjectStages
#    - Roles


- que hacer al borrar categoria u org type? 

- user view no muestra todos los proyectos para users sysadmin... habría que registrar a los sysadmins en otras instancias, para que puedan agregar proyectos.
- sysadmin debe poder ver sus proyectos, ordenados por instancia.. sólo el y otros sysadmins, el resto no debe poder verlos.
- verificar que datos de edit y add calcen con valores de la base de datos... ej> no agregar cat Id de otra instancia

- routeo de urls basura que redirija a home
- secure login data https
- ojo ccon los max limit del paginate!, puede limitar info de proyectos y otros
- project delete check instance
- evitar filtrar datos de instancia 0
- instance add --> agregar datos dummy
- buscar todos en el código
- add project tiene user fijo a 0!
- check de que al hablar de sysadmins haya coherencia con eso del instance_id... pues no debiera haber ese check
- agregar tooltips a todos los botones. ejemplo: instances index > users
-verificar cadena de eliminaciones al borrar user, instancia, proyecto, org_type, category, ...
acceso a admin tools

- verificar que pasa con tablas vacias
- mejorar sistema de back to previous... sin tener que pasar por edits/view/edits/view/...
	- ejemplo: botón para volver a lista
- mejorar redirecciones.. ejemplo; al eliminar un proyecto, volver a la lista, mapa o gráfico, no al preview
- más texto en cada vista
- editar fechas correctamente: project
- utilizar campos de configuración de la instancia
	- ej: max-categories.
sanitizar queries!
probar queries con parametros raros
link para view all --> implicará  agregar filtro por continente!
sql transsacciones encakephp
página no tiene resize de footer ni topbar

<!-- TODO: mostrar filtro actual -->

- aviso de max zoom

## ERRORES

### Instance Add

- Autocompletar nombre en español, al rellenar versión en Inglés
- Autocompletar descripción en español, al rellenar versión en Inglés
- Upload del Logo + Preview
- Todos los campos checkeados por default


## visualizaciones
- evitar esparcimiento de campos dummy
- map width height
- map size responsive
	- see: http://stackoverflow.com/questions/16265123/resize-svg-when-window-is-resized-in-d3-js

## Proyectos:

- crear, editar... reforzar constraints de labase de datos.

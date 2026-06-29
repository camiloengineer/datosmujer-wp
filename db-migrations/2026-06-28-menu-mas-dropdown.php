<?php
/**
 * 2026-06-28-menu-mas-dropdown.php
 * ---------------------------------------------------------------------------
 * MIGRACIÓN DE BASE DE DATOS (reproducible, idempotente). NO se ejecuta en
 * el deploy normal; es un script de mantenimiento de UN SOLO USO.
 *
 * Reconstruye desde cero el estado de producción aplicado el 2026-06-28:
 *   1) Ítem "MÁS ▾" al final del menú `td-demo-header-menu` con 20 categorías
 *      ocultas como hijos (ordenadas por nº de notas).
 *   2) CSS limpio de 2 columnas para ese dropdown, inyectado en el "CSS
 *      adicional" del Personalizador entre marcadores DM-MAS-START/END.
 *
 * USO:
 *   - Copiar a public_html/  (junto a wp-load.php) y abrir:
 *       https://datosmujer.cl/2026-06-28-menu-mas-dropdown.php?token=CAMBIAR
 *   - BORRAR el archivo del server al terminar y vaciar la caché.
 *
 * NOTAS TÉCNICAS (aprendidas a la mala, no perder):
 *   - El menú de escritorio lo pinta el bloque tagDiv `tdb_header_menu`; los
 *     submenús salen como `ul.sub-menu` estándar de WP.
 *   - `wp_update_custom_css_post()` ESCAPA los `>` a `&gt;` -> selector roto.
 *     => El CSS NO usa el combinador `>`; usa descendientes.
 *   - tagDiv abre el submenú con jQuery `.show()`, que mete `display:block`
 *     inline. => `display:flex` DEBE llevar `!important` o no aplica.
 * ---------------------------------------------------------------------------
 */

require __DIR__ . '/wp-load.php';

$TOKEN = 'CAMBIAR'; // <-- poner un token antes de subir; borrar el archivo después
if ( ! isset($_GET['token']) || $_GET['token'] !== $TOKEN ) { http_response_code(403); exit('forbidden'); }
header('Content-Type: text/plain; charset=utf-8');

$MENU_SLUG  = 'td-demo-header-menu';
$PARENT_TXT = 'MÁS';

// [ term_id, etiqueta a mostrar ] — orden por volumen de notas.
// OJO: cat 214 "Dato Tecno" y cat 72 "Tecnología" son SEPARADAS, ambas a propósito.
//      cat 2907 se muestra como "Cine" (su nombre real es "CINE" en mayúsculas).
$CATS = array(
    array(30,'Nosotras'), array(33,'Salud'), array(31,'Hijos'), array(214,'Dato Tecno'),
    array(60,'Tendencias'), array(213,'Dato Pyme'), array(61,'Fitness'), array(209,'Casa'),
    array(75,'Educación'), array(2419,'Mascotas'), array(210,'Viajes'), array(211,'Musica'),
    array(2508,'Dato Verde'), array(212,'TV'), array(2859,'Columna Datos Mujer'), array(32,'Food'),
    array(72,'Tecnología'), array(34,'Pasatiempos'), array(2907,'Cine'), array(62,'Tragos'),
);

$menu = wp_get_nav_menu_object($MENU_SLUG);
if ( ! $menu ) exit("ERROR: no existe el menú '$MENU_SLUG'.\n");
$menu_id = (int) $menu->term_id;
echo "Menú: {$menu->name} (id {$menu_id})\n";

// 1) Limpieza idempotente del MÁS previo + hijos.
$items = wp_get_nav_menu_items($menu_id, array('post_status' => 'any'));
$removed = 0;
foreach ($items as $it) {
    if ( trim($it->title) === $PARENT_TXT && (int)$it->menu_item_parent === 0 ) {
        foreach ($items as $child) {
            if ( (int)$child->menu_item_parent === (int)$it->ID ) { wp_delete_post($child->ID, true); $removed++; }
        }
        wp_delete_post($it->ID, true); $removed++;
    }
}
echo "Limpieza previa: $removed ítem(s).\n";

// 2) Padre "MÁS" (enlace # con clase dm-mas).
$parent_id = wp_update_nav_menu_item($menu_id, 0, array(
    'menu-item-title' => $PARENT_TXT, 'menu-item-url' => '#', 'menu-item-type' => 'custom',
    'menu-item-classes' => 'dm-mas', 'menu-item-status' => 'publish',
));
if ( is_wp_error($parent_id) ) exit('ERROR MÁS: ' . $parent_id->get_error_message());
echo "Padre MÁS (id $parent_id).\n";

// 3) Categorías como hijos.
$ok = 0;
foreach ($CATS as $c) {
    list($term_id, $label) = $c;
    if ( ! get_term($term_id, 'category') ) { echo "  SKIP $label (term $term_id inexistente)\n"; continue; }
    $cid = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => $label, 'menu-item-object' => 'category', 'menu-item-object-id' => $term_id,
        'menu-item-type' => 'taxonomy', 'menu-item-parent-id' => $parent_id, 'menu-item-status' => 'publish',
    ));
    if ( ! is_wp_error($cid) ) { echo "  + $label -> cat $term_id\n"; $ok++; }
}
echo "Categorías colgadas: $ok.\n";

// 4) CSS del dropdown (sin '>', con display:flex !important).
$css = <<<'CSS'
/* DM-MAS-START — dropdown MAS, no editar a mano */
.tdb_header_menu .tdb-menu li.dm-mas ul.sub-menu{display:flex !important;flex-wrap:wrap !important;width:380px !important;padding:6px 0 8px;left:auto !important;right:0 !important;border-top:3px solid #ef0e59;border-radius:0 0 3px 3px;box-shadow:0 8px 24px rgba(0,0,0,.14)}
.tdb_header_menu .tdb-menu li.dm-mas ul.sub-menu li.tdb-menu-item{flex:0 0 50% !important;max-width:50% !important;box-sizing:border-box;margin:0}
.tdb_header_menu .tdb-menu li.dm-mas ul.sub-menu li.tdb-menu-item a{padding:9px 18px !important;font-size:12px !important;line-height:18px !important;color:#222 !important;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;border-bottom:1px solid #f2f2f2;transition:background-color .15s ease,color .15s ease}
.tdb_header_menu .tdb-menu li.dm-mas ul.sub-menu li.tdb-menu-item:nth-child(odd) a{border-right:1px solid #f2f2f2}
.tdb_header_menu .tdb-menu li.dm-mas ul.sub-menu li.tdb-menu-item a:hover{background-color:#fff0f5 !important;color:#ef0e59 !important}
.tdb_header_menu .tdb-menu li.dm-mas a .tdb-sub-menu-icon{margin-left:5px}
@media (max-width:767px){.tdb_header_menu .tdb-menu li.dm-mas ul.sub-menu{width:100% !important;right:auto !important;left:0 !important}.tdb_header_menu .tdb-menu li.dm-mas ul.sub-menu li.tdb-menu-item{flex:0 0 100% !important;max-width:100% !important}.tdb_header_menu .tdb-menu li.dm-mas ul.sub-menu li.tdb-menu-item:nth-child(odd) a{border-right:0}}
/* DM-MAS-END */
CSS;

$existing = (string) wp_get_custom_css();
$existing = preg_replace('#/\* DM-MAS-START.*?DM-MAS-END \*/#s', '', $existing);
$res = wp_update_custom_css_post(trim(trim($existing) . "\n\n" . $css) . "\n");
echo is_wp_error($res) ? "CSS ERROR: " . $res->get_error_message() . "\n" : "CSS inyectado.\n";

echo "\nLISTO. Borra este archivo del server y vacía la caché.\n";
